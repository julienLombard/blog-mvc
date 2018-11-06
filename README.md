# blog-mvc
Professional Blog PHP MVC POO

## Installation

[1- Composer.json file](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-1--composerjson-file)

[2- Autoload](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-2--autoload)

[3- Libraries](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-3--libraries)

[4- Database](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-4--database)

## Step-1 : composer.json file

To generate the composer.json file, start to enter the command `composer init` in your command console.

```
composer init
```

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

```
composer update
```

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

```
composer require
```

All libraries will then be automatically installed in the `vendor` folder.

## Step-4 : Database

Par défault, la base de donnée configurée dans le fichier app\ORM\Database.php (ligne 54) est la suivante:

```
new Database("localhost","dev_blog", "root","");
```

Libre à vous d'en configurer une autre ou de garder celle-ci.

Cette base de donnée est constituée de 3 tables 

- comment
- post
- user
