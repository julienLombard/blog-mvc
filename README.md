# blog-mvc
Professional Blog PHP MVC POO

## Installation

[1- Generate autoload and download Libraries](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-1--generate-autoload-and-download-libraries)

[2- Set Database connection](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-2--set-database-connection)

[3- Create Database](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-3--create-database)

## Step-1 : Generate autoload and download Libraries

This professional blog works with various third-party libraries:

- twig / twig for generating views
- twig / extensions to display a summary of articles
- symfony / yaml for routes files

To install them and generate autoload file, change the folder directory to the directory where the project is located by using the `cd <directory>` command on the command console.

```
cd <directory>
```

Then, enter the command `composer install`.

```
composer install
```

```
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
Package operations: 7 installs, 0 updates, 0 removals
  - Installing symfony/asset (dev-master 89be18e): Cloning 89be18e3e4 from cache
  - Installing symfony/polyfill-ctype (dev-master 9d31bef): Cloning 9d31bef82d from cache
  - Installing twig/twig (1.x-dev 76cc345): Cloning 76cc34554b from cache
  - Installing symfony/twig-bridge (dev-master b4fd80f): Cloning b4fd80f68e from cache
  - Installing symfony/yaml (dev-master 07a9881): Cloning 07a9881ca5 from cache
  - Installing twig/extensions (dev-master 2c1a865): Cloning 2c1a86526d from cache
  - Installing symfony/dotenv (dev-master b9bfcb9): Cloning b9bfcb9d3f from cache
symfony/asset suggests installing symfony/http-foundation ()
symfony/twig-bridge suggests installing symfony/expression-language (For using the ExpressionExtension)
symfony/twig-bridge suggests installing symfony/finder ()
symfony/twig-bridge suggests installing symfony/form (For using the FormExtension)
symfony/twig-bridge suggests installing symfony/http-kernel (For using the HttpKernelExtension)
symfony/twig-bridge suggests installing symfony/routing (For using the RoutingExtension)
symfony/twig-bridge suggests installing symfony/security (For using the SecurityExtension)
symfony/twig-bridge suggests installing symfony/stopwatch (For using the StopwatchExtension)
symfony/twig-bridge suggests installing symfony/templating (For using the TwigEngine)
symfony/twig-bridge suggests installing symfony/translation (For using the TranslationExtension)
symfony/twig-bridge suggests installing symfony/var-dumper (For using the DumpExtension)
symfony/twig-bridge suggests installing symfony/web-link (For using the WebLinkExtension)
symfony/yaml suggests installing symfony/console (For validating YAML files using the lint command)
twig/extensions suggests installing symfony/translation (Allow the time_diff output to be translated)
Generating autoload files
```

All libraries andd autoload file will then be automatically installed in the `vendor` folder.

## Step-2 : Set Database connection

First, to set the connection to the database, open the config folder. Copy and rename the .env.dist file to an .dist file and set your connection information inside:

```
# .env
DB_HOST=
DB_NAME=
DB_USER=
DB_PASSWORD=
```

Once done, add your `.env` file to the `.gitignore` file:

```
/vendor/
/config/.env
```

## Step-3 : Create Database

If you wish, a database file `blog_mvc.sql` is available in the `diagrams` folder. The default administrator login is `admin` and the password is `0000`. Pour change le mot de passe, To change the login and the password, you will have to modify it directly in the database.

Otherwise you must create the database consisting of 3 tables:

- comment
- post
- user

The structures to respect for each table are as follows:

```
--
comment
--
id : integer, not null,PK
post_id : integer, not null,FK
user_id : integer, not null,FK
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
synopsis : varchar (100), not null
content : text, not null
publication_date : timestamp, not null
modification_date : timestamp, null

--
user
--
id : integer, not null,PK
login: varchar (25), not null
password : varchar (50), not null 
register_date : timestamp, not nul
validate : tinyint, not null
administrator : tinyint, not null

```

Lastly, to be able to access the administration part of the site, you will have to configure the login and password of the user from the database.
