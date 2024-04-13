# Project Title
- Admin panel

A brief description of the project.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)

## Installation

1. Clone the repository:

    ```
    git clone https://github.com/maulik231/LaravelAdminPanel.git
    ```

2. Navigate to the project directory:

    ```
    cd LaravelAdminPanel
    ```

3. Install dependencies:

    ```
    composer install
    npm install
    ```

4. Copy the `.env.example` file to `.env` and update the database configuration:

    ```
    cp .env.example .env
    ```

5. Generate application key:

    ```
    php artisan key:generate
    ```

6. Run migrations:

    ```
    php artisan migrate
    ```

7. Run seeders:

    ```
    php artisan db:seed
    ```

## Usage

### Products CRUD
### Shops CRUD

## Admin Panel

The admin panel can be accessed at `/admin/login`.