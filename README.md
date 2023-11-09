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

For regenerate database use

`php artisan migrate:refresh --seed`

---------------------------------------------------------
## Bug
- In admin query (weekly and monthly) need to add 0 for month or week without data
- Update role doesn't work correctly
- In worker page (chef + delivery man) doesn't show some columns
- Edit Status doesn't work correctly
- Understand bindings attribute from react to php
- Chef and Deliveryman have to see pizzas in their state (Chef => isPizzaStatus = 1, Deliveryman => isPizzaStatus = 0)
- Size e crush have to select combo