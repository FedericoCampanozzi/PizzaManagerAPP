## Pizza Manager APP

This is an example pizza tracking app built with Laravel, React, and Inertia.js to demonstrate automatic polling and live reloads.

## Bug To Fix
- URL problem into prod config (I can't change files)[Aruba]
- Enable SSH into Aruba DNS (change plan, pay more) in order to unzip file, and delete, into server.

## Getting Started

Clone this repo and run the following commands to install the dependencies and start up the development environment:

- `cp .env.example .env`
- `composer install`
- `npm install`
- `php artisan migrate --force`
- `php artisan db:seed`
- `php artisan serve`
- `npm run dev`

For regenerate database use

`php artisan migrate:refresh --seed`