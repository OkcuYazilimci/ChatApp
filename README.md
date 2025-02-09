# ChatApp

## Overview

ChatApp is a simple chat application built using PHP 8.4.3, Slim Framework, and SQLite as the database. It follows Clean Architecture and best practices to ensure scalability and maintainability.

## Technologies Used

- **PHP 8.4.3** - Core programming language
- **Composer** - Dependency management
- **Slim Framework** - Lightweight and powerful micro-framework for handling HTTP requests
- **SQLite** - Database used for storing users, groups, and messages

## Project Structure

```
ChatApp/
│── src/
│   ├── Application/
│   ├── Domain/
│   ├── Infrastructure/
│   │   ├── Database/
│   │   ├── DI/
│   ├── Presentation/
│   │   ├── Controllers/
│   │   ├── Routes/
│── database/
│── tests/
│── bootstrap/
│── vendor/
│── public/
│── README.md
│── composer.json
│── phpunit.xml
```

## Database Schema & UML Diagram

This project follows a relational structure with the following tables:

### Users Table

- `user_id` (string, primary key)
- `username` (string, unique)
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Groups Table

- `id` (string, primary key)
- `name` (string, unique)
- `user_id` (string, foreign key referencing users)
- `description` (text, nullable)
- `member_number` (integer, default: 0)
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Messages Table

- `id` (string, primary key)
- `user_id` (string, foreign key referencing users)
- `group_id` (string, foreign key referencing groups)
- `content` (text)
- `created_at` (timestamp)
- `updated_at` (timestamp)

### Group Members (Pivot Table)

- `user_id` (string, foreign key referencing users)
- `group_id` (string, foreign key referencing groups)

### UML Diagram



## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/yourusername/ChatApp.git
   cd ChatApp
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Set up the database:
   ```sh
   touch database/database.sqlite
   ```
4. Run the migrations:
   ```sh
   php artisan migrate
   ```
5. Start the development server:
   ```sh
   php -S localhost:8000 -t public/
   ```

## Running Tests

Execute the test suite using PHPUnit:

```sh
vendor/bin/phpunit --testdox
```

## API Endpoints

### User Routes

| Method | Endpoint      | Description       |
| ------ | ------------- | ----------------- |
| POST   | `/users`      | Create a new user |
| GET    | `/users/{id}` | Get user details  |

### Group Routes

| Method | Endpoint       | Description            |
| ------ | -------------- | ---------------------- |
| POST   | `/groups`      | Create a new group     |
| POST   | `/groups/join` | Join an existing group |
| GET    | `/groups`      | List all groups        |

### Message Routes

| Method | Endpoint               | Description               |
| ------ | ---------------------- | ------------------------- |
| POST   | `/messages/{group_id}` | Send a message in a group |
| GET    | `/messages/{group_id}` | Fetch messages in a group |

---

### Contributing

Feel free to contribute to this project by submitting pull requests!

### License

This project is licensed under the MIT License.

