# ChatApp

## Overview

ChatApp is a simple chat application built using PHP 8.4.3, Slim Framework, and SQLite as the database. It follows Clean Architecture and repository pattern to ensure scalability and maintainability.

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
|── .env
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

![image](https://github.com/user-attachments/assets/63b3591c-08d2-4d2b-b102-a159f8383847)

## Installation
NOTE About .env:
  for best practice we should put sensitive data into .env such as paths and credentials. But, in this project .env did not configured yet the paths are directly written in database.php file.
  
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

POST /users
![image](https://github.com/user-attachments/assets/3fc187e5-eaff-4063-8dfd-400e93867535)
GET /users/{id}
![image](https://github.com/user-attachments/assets/7bb7ff50-c6b3-4104-8456-ee8a22ac71a9)

### Group Routes

| Method | Endpoint       | Description            |
| ------ | -------------- | ---------------------- |
| POST   | `/groups`      | Create a new group     |
| POST   | `/groups/join` | Join an existing group |
| GET    | `/groups`      | List all groups        |

POST /groups
![image](https://github.com/user-attachments/assets/9befe0a3-25e1-4339-bbbb-75f80a7d6384)

POST /groups/join
Creator of group automatically joins the group
![image](https://github.com/user-attachments/assets/5ed776d3-db71-475d-ac2f-f495b3e391ab)
Other users can join freely
![image](https://github.com/user-attachments/assets/e1a6cc04-e34f-49f6-8b33-fc086b173e14)

GET /groups
![image](https://github.com/user-attachments/assets/5c3e01e3-1820-4b0f-b7e2-5f55fb9f56a8)

### Message Routes

| Method | Endpoint               | Description               |
| ------ | ---------------------- | ------------------------- |
| POST   | `/messages/{group_id}` | Send a message in a group |
| GET    | `/messages/{group_id}` | Fetch messages in a group |

POST /messages/{group_id}
members of the group can send message
![image](https://github.com/user-attachments/assets/fb53f603-30ee-40fa-b892-360c2dfae4b6)
Non meembers cannot send message to a group
![image](https://github.com/user-attachments/assets/d8ae446d-91be-42f3-b816-b4b2d7dfdb86)

GET /messages/{group_id}
Only group members can list messages
![image](https://github.com/user-attachments/assets/1a6e6be1-bf49-4cb2-995b-36f8da1a7f6f)
Non members cannot list messages
![image](https://github.com/user-attachments/assets/9d4abc9c-27e0-447a-9454-b279a412fd31)

---
