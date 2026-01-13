
# Easy API - Intuitive API Builder & Headless CMS

![Easy API Logo](./client/src/assets/logo.svg)
****
Easy API is a web application designed to simplify the process of architecting, managing, and prototyping APIs. It provides a visual interface to build data structures, define endpoints, and manage content without writing repetitive backend code.

Whether you're prototyping a new application or need a flexible headless CMS, Easy API streamlines the manual labor of API development.

## Core Features

- **Project Management**: Organize multiple API services under unique workspace projects.
- **Dynamic Schema Building**: Define endpoints and add custom fields with specific data types (Integer, Boolean, Text, Varchar).
- **Data Content Management**: An intuitive interface to store, view, and retrieve field values for your custom-built endpoints.
- **Secure Access**: Full authentication system integrated with Laravel Sanctum to manage private API designs.
- **Architecture Flexibility**: Support for both REST and GraphQL project types.

## Project Structure

The project follows a decoupled architecture with a modern JavaScript frontend and a robust PHP backend:
```

easyapi/
├── client/                  # Frontend implementation (Vue 3 + Vite)
│   ├── src/
│   │   ├── views/           # UI components for Projects, Endpoints, and Auth
│   │   ├── stores/          # Pinia state management
│   │   └── services/        # API communication logic
│   └── package.json         # Frontend dependencies and scripts
│
├── server/                  # Backend implementation (Laravel 10)
│   ├── app/
│   │   ├── Http/Controllers/# API business logic and field management
│   │   └── Models/          # Database ORM for Projects, Endpoints, and Values
│   ├── routes/              # API route definitions
│   └── database/            # Schema migrations and seeders
│
└── README.md                # Project documentation
```
## Technical Stack

### Frontend (Client)
- **Framework**: Vue 3 (Composition API)
- **Language**: TypeScript
- **Styling**: Tailwind CSS
- **State Management**: Pinia
- **Build Tool**: Vite
- **Testing**: Cypress (E2E) & Vitest (Unit)

### Backend (Server)
- **Framework**: Laravel 10
- **Language**: PHP 8.1+
- **Authentication**: Laravel Sanctum (Token-based)
- **Database**: MySQL (Default) / PostgreSQL
- **Logic**: Custom Validation Rules & Policy-based Authorization

## Prerequisites

- **PHP** (>= 8.1)
- **Node.js** (>= 18.0.0)
- **Composer** (for Laravel dependencies)
- **Yarn** (Preferred) or NPM
- **MySQL** or a compatible SQL database

## Getting Started

### 1. Backend Setup
```
bash
cd server
composer install
cp .env.example .env # Configure your database connection in .env
php artisan key:generate
php artisan migrate
php artisan serve
```
### 2. Frontend Setup
```
bash****
cd client
yarn install
yarn dev
```

The application will run locally at `http://localhost:5173`, proxying API requests to the Laravel server at `http://localhost:8000`.

## Security Considerations

Easy API is built with security as a priority:
- **Middleware Protection**: All project management routes are secured via Sanctum.
- **Data Integrity**: Custom rules ensure unique field names within endpoints and valid type-casting for values.
- **User Ownership**: Laravel Policies ensure users can only access and modify their own projects.

## License

This project is licensed under the MIT License.

****