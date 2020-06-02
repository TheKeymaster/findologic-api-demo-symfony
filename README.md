# FINDOLOGIC-API Demo - Symfony 5

*Work In Progress! Some features may not be implemented. Use it at your own risk.*

This is a small Symfony 5 application, which utilizes the [FINDOLOGIC-API](https://github.com/findologic/findologic-api)
to display a search in a "real" shop.

You can find a **publicly available demo** of this repository [here](https://demo.findologic.com/findologic-api).

## Installation

Since this is a plain Symfony project with only one controller, please
refer to the [Symfony documentation](https://symfony.com/doc/current/setup.html#running-symfony-applications).

The only thing that needs to be done manually is setting the ServiceId/Shopkey
in the `.env` file. The key is `FINDOLOGIC_SERVICE_ID`.

## Usage

Having installed the [Symfony CLI](https://symfony.com/download), a simple `symfony serve` should be enough to start
the web server. You can access the search via the `/search` route, or by clicking this link: http://localhost:8000/search.

## Development

### Search

The search implementation, which talks to the FINDOLOGIC-API, can be found in
`src/Controllers/FindologicApiController`.

### JavaScript / SCSS Compilation

For local development you can have a file watcher. To enable it, run:

1. `yarn install` which install all necessary dependencies.
1. `yarn run encore dev --watch` which starts the file watcher.
