## Pizza Manager APP

This is an example pizza tracking app built with Laravel, React, and Inertia.js to demonstrate automatic polling and live reloads.

## Getting Started

Clone this repo and run the following commands to install the dependencies and start up the development environment:

- `cp .env.example .env`
- `composer install`
- `npm install`
- `php artisan migrate --force`
- `php artisan db:seed`
- `php artisan serve`
- `npm run dev`

---------------------------------------------------------
## New Features
- add status table. status(id, descrizione, sequence, isPreparing)
    - add factory and migrations
- implement SQLite
- add role into users
    - add admin page/component to assign users role
    - an user can have only one role
- login role rules:
    1. admin => can modify users role
    2. chef => see orders and detail
    3. delivery-man => see only ready orders and can modify only his order
    4. normal user are redirect to last order page