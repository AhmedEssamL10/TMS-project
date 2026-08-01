# Task Management API

This Laravel project provides a simple task-management backend with users, projects, tasks, and a dashboard API.

## Installation Steps

### Option 1: Local environment
1. Clone the repository.
2. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
3. Install PHP and JavaScript dependencies:
   ```bash
   composer install
   npm install
   ```
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Run the database migrations and seed sample data:
   ```bash
   php artisan migrate --seed
   ```
6. Start the app:
   ```bash
   php artisan serve
   ```

### Option 2: Docker Compose
1. Build and start the containers:
   ```bash
   docker compose up --build
   ```
2. The app will be available at http://localhost:8000.
3. The MySQL service is exposed on port 3306.

## Environment Setup

The default environment variables are already defined in [.env.example](.env.example). For Docker, the compose file configures:

- App container running PHP 8.2 and Laravel
- MySQL 8 container with the database name `task_1`
- Default credentials:
  - Username: `task_user`
  - Password: `task_password`

To run the app locally with MySQL, update your `.env` file with your database details.

## API Documentation
Link: 6pzslx5zco.apidog.io

The API is available under the `api/v1` prefix.

### Authentication
- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout` (requires Sanctum token)

### Projects
- `GET /api/v1/projects`
- `POST /api/v1/projects`
- `GET /api/v1/projects/{project}`
- `PUT /api/v1/projects/{project}`
- `DELETE /api/v1/projects/{project}`

### Tasks
- `GET /api/v1/projects/{project}/tasks`
- `POST /api/v1/projects/{project}/tasks`
- `GET /api/v1/tasks/{task}`
- `PUT /api/v1/tasks/{task}`
- `DELETE /api/v1/tasks/{task}`

### Dashboard
- `GET /api/v1/dashboard`

## Seeders with Sample Data

The database seeder creates sample data for the main modules:

- A default admin user: `admin@example.com`
- Sample projects such as Alpha Launch and Website Refresh
- Sample tasks linked to those projects

To reseed the database:
```bash
php artisan migrate:fresh --seed
```
