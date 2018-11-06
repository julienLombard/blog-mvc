# blog-mvc
Professional Blog PHP MVC POO

## Installation (1/1)

1- composer.json file

2- autoload

## Step-1 : composer.json file

To generate the composer.json file, start to enter the command `composer init` in your command console.

Then enter the following values:

```
This command will guide you through creating your composer.json config.

Package name (<vendor>/<name>) [julien/blog-mvc-master]: jlombard/blog-mvc-master
Description []: Professional Blog PHP MVC POO
Author [, n to skip]: JLOMBARD <julienlombard.fr@gmail.com>
Minimum Stability []: dev
Package Type (e.g. library, project, metapackage, composer-plugin) []:
License []: MIT

Define your dependencies.

Would you like to define your dependencies (require) interactively [yes]? no
Would you like to define your dev dependencies (require-dev) interactively [yes]? no

{
    "name": "jlombard/blog-mvc-master",
    "description": "Professional Blog PHP MVC POO",
    "license": "MIT",
    "authors": [
        {
            "name": "JLOMBARD",
            "email": "julienlombard.fr@gmail.com"
        }
    ],
    "minimum-stability": "dev",
    "require": {}
}

Do you confirm generation [yes]? yes
```

## Step-2 : autoload

First add the following lines in your composer.json file:

```
{
    "name": "jlombard/blog-mvc-master",
    "description": "Professional Blog PHP MVC POO",
    "license": "MIT",
    "authors": [
        {
            "name": "JLOMBARD",
            "email": "julienlombard.fr@gmail.com"
        }
    ],
    "minimum-stability": "dev",
    "require": {},
    "autoload": {
        "psr-4": {
            "App\\": "app",
            "": "src"
        }
    }
}
```
