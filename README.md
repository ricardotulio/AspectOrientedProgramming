# PHPAspect

[![Build Status](https://travis-ci.org/ricardotulio/AspectOrientedProgramming.svg?branch=master)](https://travis-ci.org/ricardotulio/AspectOrientedProgramming) [![Coverage Status](https://coveralls.io/repos/github/ricardotulio/AspectOrientedProgramming/badge.svg?branch=master)](https://coveralls.io/github/ricardotulio/AspectOrientedProgramming?branch=master) [![Code Climate](https://codeclimate.com/github/ricardotulio/AspectOrientedProgramming/badges/gpa.svg)](https://codeclimate.com/github/ricardotulio/AspectOrientedProgramming)

PHPAspect é um tutorial de como utilizar [**AOP (Aspect Oriented Programming ou Programação Orientada à Aspecto)**](https://pt.wikipedia.org/wiki/Programa%C3%A7%C3%A3o_orientada_a_aspecto) em PHP. Ele possui uma implementação simples de um provilador que registra o tempo de execução de todos os métodos da aplicação.


## Aspect Oriented Programming

AOP é um paradigma de programação utilizado para diminuir o acoplamento de códigos de interesse compartilhado. Muitos dicionários definem Apecto como aparência ou face exterior. Em programação, Aspecto é aquele código que não está relacionado a um objetos em si, mas seu comportamento é compartilhado por diversos objetos da aplicação, ou seja, faz parte da aparência da aplicação e é de interesse compartilhado. Um bom exemplo disso é a autorização em sistemas. Toda vez que um recurso da aplicação é acessado, é necessário verificar se o usuário que está acessando tem autorização para acessá-lo. Mesmo se isolarmos o código de autorização, ele precisará ser executado a todo momento em que for necessário fazer esta verificação. Outro exemplo é o controle transacional em repositórios que acessam bancos de dados. Os métodos que gravam dados no banco (insert, update ou delete) muitas veze precisam ser executados dentro de uma transação. Ou seja, iniciar uma transação e efetivar a gravação dos dados no banco é um comportamento de interesse compartilhado entre a classes de repositório.
Nós veremos como separar este comportamento de interesse compartilhado com AOP utilizando o framework [Go! Aop](https://github.com/goaop/framework).


## Trabalhando com o Go!Aop

Para conseguirmos trabalhar com o Go! Aop, devemos entender como podemos dizer que uma parte do sistema possui um determinado aspecto e em que momento o aspecto irá trabalhar. Para isso, usamos **Pointcuts** e **Advices**. Para saber mais, acesse a sessão [documentação completa sobre pointcuts e advices](http://go.aopphp.com/docs/pointcuts-and-advices/).


### Pointcuts

Os *Pointcuts* informam quem são os alvos, ou seja, em que métodos do sistema o comportamento do aspecto será executado. Para isso, devemos informar se será aplicado em método publico ou privado, seguido da classe, do método e seus argumentos. Veja o exemplo a seguir:

```
<?php

	/**
	 * O método validaAcesso será executado toda vez que o método get da 
	 * classe Aspecto\Controller\ContatoController for invocado com o parâmetro $id
	 *
	 * @Before("execution(public Aspecto\Controller\ContatoController->get($id)")
	 */
	public function validaAcesso(MethodInvocation $invocation) {}
```

Podemos também utilizar o caracter * como coringa, o que nos permitirá aplicar o aspecto em diversas classes e diversos métodos. Aqui é onde as coisas ficam legais, pois é dessa forma que criamos um aspecto de fato na aplicação. 


### Advices

Os *Advices* determinam em que momento da execução do método alvo o aspecto será invocado. O Go! Aop nos permite fazer isso através de *annotations*. São elas: @Before, @After, @AfterThrowing e @Around. 

* @Before: O comportamento do aspecto será executado **antes** do método alvo
* @After: O comportamento do aspecto será executado **depois** do método alvo
* @AfterThrowing: O comportamento do aspecto será executado somente se o método alvo lançar alguma exceção
* @Around: O comportamento do aspecto será executado **antes e depois** do método alvo


### Exemplos

#### Exemplo 1 - Antes de qualquer método público da classe Aspecto\Controller\ContatoController com qualquer parâmetro

```
<?php

	/**
	 * @Before("execution(public Aspecto\Controller\ContatoController->*(*)")
	 */
	public function validaAcesso(MethodInvocation $invocation) {}
```

#### Exemplo 2 - Depois de qualquer método público de qualquer classe que estiver dentro do pacote Aspecto\Controller e terminar com Controller

```
<?php

	/**
	 * 
	 * @After("execution(public Aspecto\Controller\*Controller->*(*)")
	 */
	public function validaAcesso(MethodInvocation $invocation) {}
```

#### Exemplo 3 - Antes e depois de qualquer método da aplicação

```
<?php

	/**
	 * 
	 * @Around("execution(* *->*(*)")
	 */
	public function validaAcesso(MethodInvocation $invocation) {}
```


## Instalando e configurando o *Go! Aop*

Crie uma pasta chamada **PHPAspect** e dentro dela e crie um arquivo `composer.json` com o seguinte conteúdo:

```
{
    "require": {
        "goaop/framework": "^1.0",
        "respect/rest": "^0.6.0"
    },
    "autoload": {
    	"psr-4": {
    		"Aspect\\": "src/"
    	}
    }
}
```

Após isso, rode o comando `composer install` para instalar as dependências. Crie também uma pasta na raiz do projeto chamada `src` e dentro dela crie um arquivo chamado `ApplicationAspectKernel.php`. É este arquivo que conterá a classe responsável por integrar os aspectos à nossa aplicação. A nossa classe deve extender de `Go\Core\AspectKernel` e implementa o método `configureAop`, que nos permitirá registrar os aspectos. 

```
<?php
// src/ApplicationAspectKernel.php

namespace Aspect;

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;

/**
 * Application Aspect Kernel
 */
class ApplicationAspectKernel extends AspectKernel
{

    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container)
    {
    }
}
```

Após isso, iremos inicializar o framework no bootstrap da nossa aplicação. Crie um arquivo chamado `index.php` na raiz do projeto com o seguinte conteúdo: 

```
<?php

require_once('vendor/autoload.php');

use Aspect\ApplicationAspectKernel;

$applicationAspectKernel = ApplicationAspectKernel::getInstance();
$applicationAspectKernel->init(array(
        'includePaths' => array(
            __DIR__ . '/src/'
        )
));
```

Vamos criar duas classes para demonstrar o funcionamento do aspecto, chamadas `ClasseA` e `ClasseB`. Elas terão apenas o `executa()` e não receberá nenhum parâmetro. Crie os arquivos `ClasseA.php` e `ClaseB.php` dentro de `src`:

```
// src/ClasseA.php

namepace Aspect;

class ClasseA {
	public function executa() {}
}

```

```
// src/ClasseB.php

namepace Aspect;

class ClasseB {
	public function executa() {}
}

```

Para criar nosso aspecto, devemos criar uma classe que implemente a interface `Go\Aop\Aspect`. A partir daí, é possível criar os métodos que serão invocados, e por meio de anotações, informar os pointcuts e advices. 

Vamos criar nosso primeiro aspecto. Ele conterá a classe responsável imprimir o tempo total de execução de todos os métodos que forem executados. Como esse comportamento é um comportamento é um comportamento de interesse compartilhado, ele será um aspecto da nossa aplicação. Dentro de `src`, crie um arquivo chamado `ProfiladorAspect.php`:

```
<?php

namespace Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\After;

class ProfiladorAspect implements Aspect
{

    protected $objects = [];

    /**
     *
     * @param MethodInvocation $invocation Invocation
     * @Before("execution(public Aspect\*->*(*))")
     */
    public function beforeMethodExecution(MethodInvocation $invocation)
    {
    	$obj = $invocation->getThis();
    	$id = spl_object_hash($obj);
    	$this->objects[$id] = time();
    }

    /**
     *
     * @param MethodInvocation $invocation Invocation
     * @After("execution(public Aspect\*->*(*))")
     */
    public function afterMethodExecution(MethodInvocation $invocation)
    {
    	$obj = $invocation->getThis();
    	$id = spl_object_hash($obj);

    	$total = time() - $this->objects[$id];

    	$class = get_class($obj);
    	$method = $invocation->getMethod()->getName();

    	echo "O método {$method} da classe {$class} levou {$total} para ser executado \n";
    }
}
```

O método `beforeMethodInvocation` recebe a anotação `@Before` para que seja executado antes do nosso alvo, e `public Aspect\*->(*)` define que nosso alvo é qualquer método de qualquer classe que esteja dentro do pacote `Aspect`. O mesmo ocorre com o método `afterMethodInvocation`, a diferença é que este recebe a annotation `@After`, para que seja executado ao fim do método alvo, nos permitindo obter o tempo total de execução do método.

Após criado um aspecto, é necessário registrá-lo. Dessa forma, o Go! Aop passa a saber da sua existência, e pelas anotações identifica os advices e pointcuts do aspecto. Editaremos a classe `Aspect\ApplicationAspectKernel` e colocaremos uma linha dentro do método `configureAop()`, ficando então desta forma:

```
<?php

...
	protected function configureAop(AspectContainer $container) 
	{
		$container->registerAspect(new ProfiladorAspect());
	}
...
```

Registrado o nosso aspecto, vamos instanciar as classes `Aspect\ClasseA` e `Aspect\ClasseB` e executar seus métodos `executa()` dentro do arquivo `index.php`. Se tudo ocorrer bem, ao executar o método `executa()` de cada classe, os compartamentos contidos dentro do aspecto deverão ser invocados. Insira as linhas a seguir no final do arquivo `index.php`:

```
<?php

...
$a = new ClasseA();
$a->executa();

$b = new ClasseB();
$b->executa();
```

Com isso, basta executar o arquivo `index.php` que se encontra na raiz do projeto por linha de comando ou rodar um servidor php e veremos a saída do nosso provilador.

#### Linha de comando:

`$ php index.php`

#### Servidor:

`$ php -sS localhost:8080`

Deverá ser impresso a seguinte mensagem:

```
O método executa da classe Aspect\ClasseA levou 0 para ser executado 
O método executa da classe Aspect\ClasseB levou 0 para ser executado
```

Vamos colocar uma chamada da função `sleep()` dentro dos métodos `executa()` para ver melhor o seu funcionamento. Insira a seguinte linha nos dois métodos `executa()`:

```
<?php

...
	public function executa() {
		sleep(rand(1, 5));
	}
```

Execute novamente o arquivo index.php para ver o novo resultado.

Note que em momento algum a as classes `Aspect\ClasseA` ou `Aspect\ClasseB` tiveram contato com o nosso aspecto. Dessa forma, podemos isolar comportamentos de log de sistema, autenticação e autorização, sistemas transacionais e boa parte da nossa infraestrutura. Um controlador, por exemplo, não precisa saber que ele atende requisições HTTP, podemos deixar a comunicação com HTTP por parte de um aspecto. Basta que os controladores retornem os resultados esperados. O mesmo acontece com gerenciador de rotas. Todos esses exemplos são comportamentos de interesse compartilhado da aplicação e podem ser isolados em aspectos.
