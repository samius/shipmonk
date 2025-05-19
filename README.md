# ShipMonk homework - SortedLinkedList - Milan Krupa

## Problem Statement
“Implement a library providing SortedLinkedList (linked list that keeps values sorted). 
It should be able to hold string or int values, but not both. 
Try to think about what you'd expect from such library as a user in terms of usability and best practices, and apply those.”

## Implementation notes
- I am using PHPStan level 6 for static analysis. 
  I consider higher level too strict with impact on annotation readability (e.g. range of integers, etc).
- PHPStan rules are extended with ShipMonk custom rules.
- PHP ECS with default Symfony coding standard is used for code style analysis.
- PHPUnit is used for unit testing.
- All settings are in root folder.
- Docker image is not included, as this is should be a library, not an application.

## Installation
To import this library into your project, add following line to your `composer.json` file:
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/samius/shipmonk"
    }
  ]
}
```
and then 
```bash
composer require samius/sorted-linked-list
```

## Checking the homework
Or you can just clone this repository and run tests, static analysis, and code style checks
```bash
composer install
composer phpunit
composer phpstan
composer ecs
```