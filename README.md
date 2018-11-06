# blog-mvc
Professional Blog PHP MVC POO

## Installation

1- Composer.json file

2- Autoload

3- Libraries

4- Database

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

## Step-2 : Autoload

First add the following lines in your composer.json file after the `require` entry:

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
Then enter the command `composer update` in your command console.

After that, a `autoload.php` file is created in a new `vendor` folder. 

Add the `vendor` folder in the `.gitignore` file.

## Step-3 : Libraries

This professional blog works with various third-party libraries:

- twig / twig for generating views
- twig / extensions to display a summary of articles
- symfony / yaml for routes files

To install them, first add the following lines in the `require` entry:

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
    "require": {
        "twig/twig": "1.x-dev",
        "symfony/asset": "^4.2@dev",
        "symfony/twig-bridge": "^4.2@dev",
        "twig/extensions": "^1.5@dev",
        "symfony/yaml": "^4.2@dev"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app",
            "": "src"
        }
    }
}
```
Then enter the command `composer require` in your command console, and press enter when `Search for a package:` appears.

All libraries will then be automatically installed in the `vendor` folder.

## Step-4 : Database
