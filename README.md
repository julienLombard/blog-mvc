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

By default, the database configured in the app \ ORM \ Database.php file (line 54) is as follows:

```
new Database("localhost","dev_blog", "root","");
```

You are free to configure another one or keep it.

This database consists of 3 tables:

- comment
- post
- user

The structures to respect for each table are as follows:

````
--
comment
--
id : integer, not null,PK
post_id : integer, not null,FK
author : varchar (25), not null
content : text, not null
publication_date :timestamp, not null
modification_date :timestamp, null
validate : tinyint, not null
reported : tinyint, null

--
post
--
id : integer, not null,PK
title : varchar (255), not null
author : varchar (25), not null
content : text, not null
publication_date : timestamp, not null
modification_date : timestamp, null

--
user
--
id : integer, not null,PK
login: varchar (25), not null
password : varchar (50), not null 

```

To be able to access the administration part of the site, you will have to configure the login and password of the user from the database.
