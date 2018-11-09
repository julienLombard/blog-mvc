# blog-mvc
Professional Blog PHP MVC POO

## Installation

[1- Libraries](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-1--libraries)

[2- Database](https://github.com/julienLombard/blog-mvc/blob/master/README.md#step-2--database)

## Step-1 : Libraries

This professional blog works with various third-party libraries:

- twig / twig for generating views
- twig / extensions to display a summary of articles
- symfony / yaml for routes files

To install them, enter the command `composer install` in your command console, and press enter when `Search for a package:` appears.

```
composer install
```

All libraries will then be automatically installed in the `vendor` folder.

## Step-2 : Database

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

```
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
