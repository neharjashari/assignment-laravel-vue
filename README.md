# Assignment – Laravel + Vue App

A full-stack demo shopping app built with **Laravel 10** and **Vue 3 + Inertia.js**. Features include product listing, editing, cart management, and API session-based authentication.

## Setup

### Requirements

- PHP 8.2+, Composer
- Node.js 20+

### How to run?

1. Create .env file locally and update the DB variables
    ```bash
    cp .env.example .env
    ```

2. Install composer and npm packages
    ```bash
    composer install
    npm install
    ```

3. Run migrations and generate key
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

4. Command to import products
    ```bash
    php artisan app:import-products
    ```

5. Run application
    ```bash
    composer run dev
    ```

### Tests

Run test cases in Laravel:
```bash
php artisan test
```

Run test cases in Vue:
```bash
npm run test
```

### Backend Notes

- The main business logic is located in the `app/Modules` directory, where I integrated a folder structure commonly referred as a Modular (or Feature-Based) Architecture in Laravel
- Used a Service / Repository Pattern inside each Module
- The commands are located on the `app/Console/Commands` directory

### Frontend Notes

- Located under `resources/js/`
- Uses axios wrapper for CSRF/cookie-based API calls
- State management with Pinia (stores/cart.ts)
- UI feedback via Toastification

