# Wordy

Wordy is a server-rendered vocabulary learning application built with Laravel. It helps learners organize words into personal lists, create flashcards, search saved vocabulary, and review definitions in a focused interface.

The project is intended for individual learners who want a simple way to maintain and practise their own vocabulary collection.

## Tech Stack

### Core

- PHP 8.1 or later
- Laravel 10
- MySQL
- Laravel Blade
- Eloquent ORM

### Supporting Libraries and Tools

- Laravel UI for authentication scaffolding
- Bootstrap 5 for interface components and layout
- JavaScript and jQuery for client-side interactions
- Axios and Cropper.js for profile image upload and cropping
- Cloudinary for profile image storage
- PHPUnit for automated tests

The repository does not use a Node.js build pipeline. Required browser assets are loaded from public files or CDNs.

## Key Features

### Authentication

- User registration and session-based login
- Logout
- Email verification through signed verification links
- Password reset by email

### Vocabulary Lists

- Create, view, rename, and delete vocabulary lists
- Associate each list with the authenticated user
- Paginate list results

### Flashcards

- Add, edit, and delete flashcards within a vocabulary list
- Add multiple flashcards in one request
- Store the word, definition, word type, pronunciation, and examples
- Search saved flashcards and paginate the results
- Show or hide definitions while practising
- Play word pronunciation through the browser's speech synthesis support

### Profile

- Update the user's display name and biography
- Upload and crop avatar and cover images before sending them to Cloudinary

## Database Structure

The main application data follows this relationship:

```text
users (1) ──────< word_lists (1) ──────< flashcards
```

| Table | Purpose | Main relationship |
| --- | --- | --- |
| `users` | Stores accounts, verification state, and profile information | Has many `word_lists` |
| `word_lists` | Groups vocabulary created by a user | Belongs to `users`; has many `flashcards` |
| `flashcards` | Stores vocabulary content for a list | Belongs to `word_lists` |

Deleting a word list also deletes its flashcards through a database cascade. Deleting a user does not automatically delete the user's word lists.

Additional migrations provide support tables for password reset tokens, failed jobs, personal access tokens, and media records.

## Installation and Setup

### Requirements

- PHP 8.1 or later with the extensions required by Laravel
- Composer
- MySQL
- An SMTP-compatible mail service for verification and password reset emails
- A Cloudinary account if profile image upload will be used

Node.js is not required for the current repository.

### 1. Clone the repository

```bash
git clone https://github.com/Myyly/wordy-neww.git
cd wordy-neww
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create the environment file and application key

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Create and configure the MySQL database

Create a new database, for example:

```sql
CREATE DATABASE wordy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Update the database section in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wordy
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```

Configure the `MAIL_*` values when testing email verification or password reset. Profile image upload also requires valid Cloudinary configuration. Keep all credentials in local environment configuration and never commit secrets to the repository.

### 5. Run migrations and seed sample data

```bash
php artisan migrate --seed
```

The seeder creates a demo account and sample vocabulary lists with flashcards:

```text
Email: demo@wordy.local
Password: password
```

These credentials are intended for local development only.

### 6. Start the application

```bash
php artisan serve
```

Open `http://127.0.0.1:8000` in a browser.

### 7. Run the automated tests

```bash
php artisan test
```

## Screenshots

Screenshots have not yet been added to the repository. Suggested additions:

- Home and vocabulary list page
- Flashcard management page
- Flashcard practice and search page
- Profile editing page

## Current Scope

Wordy is primarily a Laravel Blade application rather than a REST API. This README documents features that are present in the current source code; discontinued dictionary lookup and translation integrations are intentionally excluded.
