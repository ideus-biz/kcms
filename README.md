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

and open a newly created document root folder of `my-app`,
and run PHP internal server:

> cd my-app/public
> php -S localhost:8080

If everything done write you can see a page at http://localhost:8080/

Please read further instruction on the page.
