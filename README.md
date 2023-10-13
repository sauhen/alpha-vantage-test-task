# Laravel Stock Price Monitoring App

A simple web application built with Laravel to monitor real-time stock prices.

## Getting Started

These instructions will help you set up and run the project on your local machine for development and testing purposes.

### Prerequisites

Make sure you have the following software installed on your machine:

- [PHP (>= 8.0)](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en/)
- [MySQL](https://www.mysql.com/)

### Installing

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/sauhen/alpha-vantage-test-task.git
   cd alpha-vantage-test-task

2. **Install Dependencies:**

     ```bash
     composer install

3. **Set Up Environment Variables:**

Create a copy of the .env.example file and save it as .env. Update the .env file with your local configuration settings, including the database connection, pusher connection (add config data for tests) and Alpa Vantage API keys.

4. **Generate an Application Key:**

    ```bash
    php artisan key:generate

5. **Database Setup:**

    ```bash
    php artisan migrate --seed

### Running the Application

1. **Start the Development Server:**

    ```bash
    php artisan serve

2. **Run the Queue Worker (for jobs):**

    ```bash
    php artisan queue:work

### Running Tests

To run PHPUnit tests, use the following command:

  ```bash
    phpunit
