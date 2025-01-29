# Event Management System

## Project Overview
The Event Management System is a web application designed to help users manage events and attendees efficiently. It provides features for creating, editing, and deleting events, as well as managing attendees for each event.

## Features
- User authentication (login/logout)
- Event management (create, edit, delete events)
- Attendee management (add, remove attendees)
- Downloading attendee list as csv
- Pagination, sorting, and filtering of events
- Responsive design using Bootstrap

## Installation Instructions
1. **Clone the repository:**
    ```bash
    git clone https://github.com/Shaikat-CSE/Event-Management-System-using-PHP-MySQL.git
    ```

2. **Navigate to the project directory:**
    ```bash
    cd Event-Management-System-using-PHP-MySQL
    ```

3. **Set up the database:**
    - Create a MySQL database named `event_management`.
    - Import the provided SQL file to set up the database schema and initial data:
      ```bash
      mysql -u yourusername -p event_management < database.sql
      ```

4. **Configure the database connection:**
    - Open `config.php` and update the database connection details:
      ```php
      // filepath: /c:/xampp/htdocs/event_management/config.php
      <?php
      $servername = "localhost";
      $username = "your_db_username";
      $password = "your_db_password";
      $dbname = "event_management";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      ?>
      ```

5. **Start the server:**
    - If you are using XAMPP, place the project folder in the `htdocs` directory and start Apache and MySQL from the XAMPP control panel.
    - Access the application in your web browser at `http://localhost/event_management`.

## Login Credentials for Testing
- **Admin User:**
  - Username: `shaikat143@gmail.com`
  - Password: `5254`

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.