# Laravel Stock Price Monitoring App

A simple web application built with Laravel to monitor real-time stock prices.

Design decisions for a real-time stock price monitoring application involve choices regarding architecture, technologies, user experience, scalability, and maintainability. Here are key design decisions for this application:

1. **Architecture**:
   - **Microservices Architecture**: Divide the application into smaller, manageable services like user authentication, stock data processing, and real-time updates. This promotes scalability and maintainability.

2. **Backend**:
   - **Laravel Framework**: Utilize Laravel for the backend due to its robustness, MVC architecture, built-in features, and ease of integration with various libraries and databases.
   - **RESTful API**: Design a RESTful API to enable communication between the frontend and backend, following best practices for endpoints and responses.

3. **Frontend**:
   - **React.js**: Use React for the frontend to build an interactive, dynamic user interface that provides a smooth experience for users.
   - **Pusher.js**: Integrate Pusher.js to enable real-time updates for stock prices and changes, providing users with live data.

4. **Database**:
   - **MySQL**: Choose a relational database like MySQL for storing stock data and other relevant data due to their reliability, ACID compliance, and support for complex queries.

5. **Real-Time Updates**:
   - **Pusher for Real-Time Communication**: Use Pusher to establish real-time communication between the backend and frontend, allowing users to receive immediate updates on stock prices.
   - **WebSockets**: Implement WebSockets for establishing a full-duplex communication channel, enabling efficient data flow between the server and clients.


6. **Caching**:
   - **Caching with Laravel Cache**: Implement caching mechanisms using Laravel Cache to store frequently accessed stock data temporarily, reducing the load on the server and improving response times.

7. **Error Handling**:
   - **Robust Error Handling**: Implement comprehensive error handling on both the frontend and backend to provide meaningful error messages and improve system resilience.


These design decisions help create a scalable, efficient, and maintainable real-time stock price monitoring application that provides a seamless user experience. Adjustments and refinements may be necessary based on specific project requirements and constraints.


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


