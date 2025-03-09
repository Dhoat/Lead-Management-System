# Lead Management System

A **single-page** Lead Management System built with **Laravel, jQuery/AJAX, and MySQL**.

## Features
- **Single Page Application (SPA)** (No page reloads)
- **Leads List with Filters** (Search by Name, Email, Status, Source)
- **Pagination** (20 records per page)
- **Admin Actions:**
  - Edit Lead (Edit all fields except Email & Mobile)
  - Post Updates (Log call updates with timestamp & admin ID)
  - View Updates (Popup showing updates in descending order)
- **Responsive UI** (Bootstrap & DataTables)

## Installation & Setup

### 1. Clone the Repository
```sh
git clone https://github.com/YOUR_GITHUB_USERNAME/lead-management-system.git
cd lead-management-system
```

### 2. Install Dependencies
```sh
composer install
npm install
```

### 3. Configure Environment
- Copy the `.env.example` file and rename it to `.env`:
  ```sh
  cp .env.example .env
  ```
- Update database credentials in the `.env` file:
  ```
  DB_DATABASE=your_database_name
  DB_USERNAME=your_database_user
  DB_PASSWORD=your_database_password
  ```

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Run Migrations & Seeders
```sh
php artisan migrate --seed
```
_(This will create the database tables and insert dummy leads for testing.)_

### 6. Start the Development Server
```sh
php artisan serve
```
_(The application will be available at `http://127.0.0.1:8000`)_

### 7. Run Frontend Build _(If using Vite)_
```sh
npm run dev
```

## API Routes
| Method | Endpoint | Description |
|--------|---------|-------------|
| GET | `/leads` | Get leads list with filters & pagination |
| POST | `/leads/{id}/update` | Post call update for a lead |
| PUT | `/leads/{id}` | Edit lead details |

## License
This project is **open-source** and free to use.

