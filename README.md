<p align="center">
    <h1 align="center">Mailbox API</h1>
    <br>
</p>

Application based on Yii2 framework, used Yii 2 Basic Project Template as a skeleton.
Implemented requirements contains in the document[\/task\/Mailbox API.pdf](https://github.com/buzyka/mail-api/blob/version1/task/Mailbox%20API.pdf) of this repository

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

Tested on PHP 5.6.28, MySql 5.5.48, Apache 2.4(enable mod_rewrite)


INSTALLATION
------------

### Install via Composer

Get code from GitHab repository [https:\/\/github.com\/buzyka\/mail-api](https:\/\/github.com\/buzyka\/mail-api) (download code, clone repository any suitable way).
Move to code directory.
Install application using the following command:
~~~
php composer.phar install
~~~
Point web root of your domain to the directory /web/ and restart your web server


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=database',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create seed the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.

### Run migrations

Migrations create tables in database and seed them with testing data.

For run migrations using the following command:
~~~
php yii migration/up
~~~

Now you can check yous site by url:

~~~
http://your-domain.com
~~~


USING API
---------

User manual available [here](https://github.com/buzyka/mail-api/blob/version1/task/manual.md)
