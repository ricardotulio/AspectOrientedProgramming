# Aspect Oriented Programming in PHP

[![Build Status](https://travis-ci.org/ricardotulio/AspectOrientedProgramming.svg?branch=master)](https://travis-ci.org/ricardotulio/AspectOrientedProgramming)
[![Coverage Status](https://coveralls.io/repos/github/ricardotulio/AspectOrientedProgramming/badge.svg?branch=master)](https://coveralls.io/github/ricardotulio/AspectOrientedProgramming?branch=master)

The purpose of this project is to demonstrate the use of aspect-oriented programming in PHP using Go!. Go! is a PHP framework that allows us to use aspect-oriented programming using Doctrine Annotations.

This project has three examples of using AOP in PHP:

- The transaction manager;
- The exception logger;
- The profiler.

All implementations of aspects are covered by tests.

# How to run this project

## Using Vagrant

Enter the root directory of the project and run `vagrant up`.

## Using Docker Compose

Enter the root directory of the project and run `docker-compose up`.

## Using PHP Built-in web-server

Enter the root directory of the project and run `php -S localhost:8000 -t public/`.
