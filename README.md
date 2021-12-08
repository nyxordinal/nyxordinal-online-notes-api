# Nyxordinal Notes Backend

## Description

Backend service of Nyxordinal Notes.

## Development Tools

-   [Lumen v8.0.1](https://lumen.laravel.com/)
-   [Faker](https://github.com/fzaninotto/Faker)

## Development

A. Set Up

1. Clone this repo and change directory to project folder  
   `git clone https://github.com/nyxordinal/nyxordinal-online-notes.git && cd /nyxordinal-online-notes`
2. Install dependencies  
   `composer install`
3. Copy .env.example to .env  
   `cp .env.example .env`
4. Generate aplication key  
   `php artisan key:generate`
5. Set your database credential in .env on key DB\_\*
6. If you are in production, do not forget to set APP_ENV in .env to "production" and set APP_DEBUG to "false"

B. Run Dev Server

1. Open terminal in your project folder
2. Use below command in the terminal  
   `php artisan serve`
3. Access development server in http://localhost:8000

## Deployment Database Setup

1. Create `notes` database in your RDMBS
2. Run migration  
   `php artisan migrate`

## Docker

A. Publish Development Changes

1. Do your changes
2. Build notes-be docker image  
   `docker build -t nyxordinal/notes-be:{tag} .`
3. Push docker image to nyxordinal registry  
   `docker push nyxordinal/notes-be:{tag}`

B. Deploy Docker Image (Production Server)

1. Pull notes-be docker image  
   `docker pull nyxordinal/notes-be:{tag}`
2. Create and start notes-be container

```
docker run -d -p {host-port}:8001 --name notes-be \
    --env APP_NAME="Nyxordinal Online Notes API" \
    --env APP_ENV=production \
    --env APP_DEBUG=false \
    --env APP_URL=http://localhost:8001 \
    --env APP_TIMEZONE=UTC \
    --env DB_CONNECTION=mysql \
    --env DB_HOST={your-docker-host-ip} \
    --env DB_PORT=3306 \
    --env DB_DATABASE=notes \
    --env DB_USERNAME={your-db-username} \
    --env DB_PASSWORD={your-db-password} \
    nyxordinal/notes-be:{tag}
```

4. Access notes-be in http://localhost:{host-port}

> **_NOTE:_** How to check your docker host IP, find out [in this link](https://nickjanetakis.com/blog/docker-tip-35-connect-to-a-database-running-on-your-docker-host)  
> Or you can add `--net="host"` in `docker run` command and then for DB_HOST you can use `"localhost"`.  
> If you use `--net="host"` in `docker run` command, `-p {host-port}:8001` must be removed from `docker run` command

## Developer Team

Developed with passion by [Nyxordinal](https://github.com/nyxordinal)
