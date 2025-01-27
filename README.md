# News Aggregator

![Innoscripta Logo](innoscripta-logo-dark.svg)

## Description

The News Aggregator is a web application that collects and displays news articles from various sources. It provides an API to filter and search articles by category, author, source, and keywords. The application also includes a Swagger documentation interface for easy API exploration.

## Features

- Fetch news articles from multiple providers (NewsAPI, The Guardian, The New York Times)
- Filter and search articles by category, author, source, and keywords
- Paginated results
- Swagger documentation for API endpoints
- Dockerized setup for easy deployment

## Prerequisites

- Docker
- Docker Compose

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/news-aggregator.git
    cd news-aggregator
    ```

2. Make the `start.sh` script executable:
    ```bash
    chmod +x scripts/start.sh
    ```

3. Create a `.env` file and configure your environment variables:
    ```bash
    cp .env.example .env
    ```

4. Update the `.env` file with your database and API keys.

## Usage

1. Start the application using the provided script:
    ```bash
    ./scripts/start.sh
    ```

2. The application will start the following services:
    - PHP-FPM (app)
    - Nginx (nginx)
    - MySQL (db)
    - phpMyAdmin (phpmyadmin)

3. Access the application:
    - API: [http://localhost:8000](http://localhost:8000)
    - phpMyAdmin: [http://localhost:8080](http://localhost:8080)
    - Swagger Documentation: [http://localhost:8000/api/documentation#/](http://localhost:8000/api/documentation#/)

## API Endpoints

### Get Filtered Articles

- **URL:** `/api/articles`
- **Method:** `GET`
- **Query Parameters:**
  - `category` (string, optional)
  - `author` (string, optional)
  - `source` (string, optional)
  - `search` (string, optional)
  - `page` (integer, optional)
  - `perPage` (integer, optional)
- **Response:** JSON array of articles with pagination info

### Get Filter Values

- **URL:** `/api/articles/filters`
- **Method:** `GET`
- **Response:** JSON object with arrays of categories, authors, and sources

## Fetching News Articles

The application includes a command to fetch news articles from configured providers. You can run the command manually:

```bash
docker-compose exec app php artisan fetch:news
```

## Setting Up a Cron Job

To automatically fetch news articles every hour, you can set up a cron job. Follow these steps:

1. Open your crontab file:
    ```bash
    crontab -e
    ```

2. Add the following line to schedule the command to run every hour:
    ```bash
    0 * * * * cd /path/to/your/news-aggregator && docker-compose exec app php artisan fetch:news
    ```

3. Save and exit the crontab editor.

This will ensure that the news articles are fetched every hour automatically.

## License

This project is licensed under the MIT License.
