# Castello Nekretnine

Official website project for **Castello Nekretnine Vrsac**, built to showcase available real estate listings, provide agency contact information, and allow visitors to subscribe to property alerts.

The platform is focused on helping users browse properties in Vrsac and surrounding areas, with a simple experience for discovering apartments, houses, commercial spaces, land, and other listing categories.

Website: [vrsacnekretnine.rs](https://vrsacnekretnine.rs/)

## Overview

The website includes:

- a homepage with featured properties
- category-based property browsing
- detailed listing pages
- agency contact information and social links
- a mortgage calculator
- email subscription for new property alerts based on selected criteria

The public site presents listings and services related to:

- apartments
- houses
- commercial spaces
- plots
- agricultural land
- Belgrade properties

## Key Features

- featured and active property listings
- filtering by property type and listing attributes
- email subscription for new listings
- email verification flow for subscribers
- dynamic filters based on selected property type
- groundwork for grouped daily email notifications

## Tech Stack

This project is built on Laravel with a server-rendered frontend.

- PHP / Laravel
- Blade templates
- JavaScript
- HTML / CSS
- MySQL
- SMTP-based email delivery

## Local Setup

1. Clone the repository.
2. Install PHP dependencies:

```bash
composer install
```

3. Copy the environment file:

```bash
cp .env.example .env
```

4. Configure database and mail settings inside `.env`.
5. Generate the application key:

```bash
php artisan key:generate
```

6. Run migrations:

```bash
php artisan migrate
```

7. Seed the database if needed:

```bash
php artisan db:seed
```

8. Start the local development server:

```bash
php artisan serve
```

## Email Notifications

The application supports user subscriptions for newly published properties based on selected search criteria. The typical flow is:

- the visitor enters an email address and selects property criteria
- a subscription record is created
- a verification email is sent
- once the email address is confirmed, the subscription becomes active
- new properties can then be matched against active subscriptions

If you are using a real SMTP server, make sure the following `.env` values are configured correctly:

- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION`

For local development without sending real emails, you can use:

```env
MAIL_MAILER=log
```

## Project Structure Highlights

The main functional areas of the project include:

- property management
- listing display and filtering
- subscribers and subscription filters
- subscription email verification
- dynamic filter definitions by property type

## Notes

- filters can be displayed dynamically depending on the selected property type
- named routes must be defined correctly for email verification links
- queue-based mail sending is recommended for production use
- daily digest notifications are a natural next step for improving the subscription experience

## Contact

**Castello Nekretnine Vrsac**  
Vaska Pope 2, entrance from Gavrila Principa  
Phone: `+381 65 8234 501`  
Email: `castellonekretnine@gmail.com`

## License

This project belongs to Castello Nekretnine unless stated otherwise in the repository.
