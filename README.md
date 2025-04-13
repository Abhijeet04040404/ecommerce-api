Product Management CRUD Application

Overview

->This is a simple CRUD (Create, Read, Update, Delete) application built using Laravel, a PHP web framework. The application allows users to manage products, including creating, reading, updating, and deleting products.

Features

->Create new products with name, description, price, and image
->Read product details, including name, description, price, and image
->Update existing product details
->Delete products
->Validate user input using Laravel's built-in validation features

Requirements

->PHP 8.0 or higher
->Laravel 10.x or higher
->MySQL 5.7 or higher

Installation

->Clone the repository using Git: git clone https://github.com/your-username/product-management-crud.git

->Install dependencies using Composer: composer install
->Create a new MySQL database and update the .env file with your database credentials
->Run the migrations to create the database tables: php artisan migrate
->Run the seeder to create the fake data : php artisan migrate:fresh --seed
->Run the command for storage to create folder to image : php artisan storage:link
->Start the application using Laravel's built-in development server: php artisan serve

Usage

The application provides a RESTful API for managing products. The API endpoints are:

->GET /products: Retrieve a list of all products
->GET /products/{id}: Retrieve a single product by ID
->POST /products: Create a new product
->PUT|PATCH /products/{id}: Update a product
->DELETE /products/{id}: Delete a product

License

->This application is licensed under the MIT License.

To run the application in container

->Clone the repository or unzip the folder.
->Build and start the containers(If docker compose is not installed install it ):
   bash docker-compose up --build

      
API's documentation availability
-> /REST API basics- CRUD, test & variable.postman_collection.json