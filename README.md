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
- implement different dashboard:
    1. if admin => can see all users and can modify his role
    2. if chef => see only pizzas with fk_pizzastatus = NULL OR fk_chef = *my_id*
    3. if delivery-man => see only pizzas with (fk_deliveryman = NULL AND fk_pizzastatus = 3) OR fk_deliveryman = *my_id*
    4. if guest => can see mine pizzas and their states (show.jsx) (fk_client = *my_id*) or put a new order
- put a button in table that change the next state (*id_state* += 1) [pt. 2 and 3]
- put nice toppings label

---------------------------------------------------------
## Done
- added tables (model, factory, seeder, ....):
    1. role
    2. status
    3. added foreign key into pizzas and users