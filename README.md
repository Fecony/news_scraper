# News Scrapping

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing
purposes.

### Prerequisites

Things you will need:

- [PHP](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [Docker](https://docs.docker.com/get-docker/)

### Installation

Clone the project

```bash
  git clone git@github.com:Fecony/news_scraper.git
```

Go to the project directory

```bash
  cd news_scraper
```

Install dependencies

#### Docker

> This command will run Docker container to install application dependencies
> You can refer to Laravel
> Sail [docs](https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects) for other useful
> commands!

```bash
  docker run --rm \
              -u "$(id -u):$(id -g)" \
              -v $(pwd):/opt \
              -w /opt \
              laravelsail/php80-composer:latest \
              composer install --ignore-platform-reqs
```

Then run Laravel Sail command to run Docker in background:

```bash
  ./vendor/bin/sail up -d
```

## Generating new Spiders

1) Generate new Spider for specific news page

```bash
sail php artisan roach:spider [name]
```

2) Write code to scrape news blocks and news items

Read more about Spiders and Scraping [here](https://roach-php.dev/docs/processing-responses)

3) Run your scraper

```bash
sail php artisan roach:run [name]
```

## Troubleshooting

Here is a list of common problems.

### Cannot start service mysql: Ports are not available: listen tcp 0.0.0.0:3306: bind: address already in use

Most likely you have running mysql service locally. There are 2 solutions to this isuse:

- You have to stop your local mysql service to make port 3306 available for docker
- Use `FORWARD_DB_PORT` in your .env to use different port for docker port binding
    - `FORWARD_DB_PORT=3307`
