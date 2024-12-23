# KCMS Application

Application based on KCMS framework over Laravel


## Installation

This repo contains KCMS core packages in a separate corporation repository `bitbucket.ideus.biz`.

At first, you have to authorize your `composer` to access this repo.

>composer config --global --editor --auth

and write in your creds:

```json
{
    "http-basic": {
        "bitbucket.ideus.biz": {
            "username": "username",
            "password": "password"
        }
    }
}
```

More info and auth options is here: https://getcomposer.org/doc/articles/authentication-for-private-packages.md#command-line-http-basic

Create a project using `composer` tool:

>composer create-project ideus-biz/kcms ./my-app

It downloads and installs all required packages.

Open a newly created document root folder of `my-app`,
and run PHP internal server:

> cd ./my-app/public
> php -S localhost:8080

If everything done write you can see a page at http://localhost:8080/

Please read further instruction on the page.


## KCMS Package update

To be up-to-date you need to update `kcms/package` either separately or alone with all vendors
using `composer update` command.
Before updating, you have to know the latest KCMS package version.
One of the way to get the version is to search for the latest tag in the main branch of the corporate repository.
The tag looks like `v5.5.yyyy.mmdd.n`.
Copy such a string and fill it into the `reference` under `kcms/package` in the project's `composer.json`.

Then run either `composer update kcms/package` or `composer update`.
