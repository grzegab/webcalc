# Example API for web calculator
Sample project for testing. Traditional MVC was replaced with CQRS patter.
To make this simpler, while calculating we will consider only 4 decimal digits.

### What is it?
It is a sample project build with Symfony framework on PHP 8.1

### How to start?
You need docker, than simply edit `.env` file (feel free to create `.env.local`) change port for docker app if needed

### How to use?
Read API documentation under `/api/swagger`. Basically it makes simple calculations on two float number:
* add
* multiply
* divide
* subtract

To get calculation just send POST request to `/cacl/make` with variables: `numberA`, `nubmerB` and `operation`

### What else?
Project is just an example, there can be added cache mechanism (like Redis), database for historical data and statistics

### Tests?
Tu run them use `php bin/phpunit` 