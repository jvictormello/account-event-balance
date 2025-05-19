# Account Event Balance API

## 📌 Description
This is an API for account management and transactions, allowing you to create accounts, make deposits, withdrawals, and transfers between accounts.

## 🚀 Technologies Used
- **PHP 8.1**
- **Laravel 10.x**
- **MySQL** (Docker)
- **Docker and Docker Compose** (including Ngrok as a service)

## 📦 Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/your-repository.git
   cd your-repository
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Set up Docker:
   ```bash
   docker-compose build
   docker-compose up -d
   ```

4. Configure Ngrok Token:
   - Access the Ngrok Dashboard: https://dashboard.ngrok.com/get-started/your-authtoken
   - Copy your Ngrok Auth Token.
   - Add the token to your Docker Compose environment file (`.env`):
     ```bash
     NGROK_AUTHTOKEN=your-ngrok-auth-token
     ```

5. Access the application container:
   ```bash
   docker-compose exec app bash
   ```

6. Run migrations to create the database tables:
   ```bash
   php artisan migrate
   ```

7. Generate the application key:
   ```bash
   php artisan key:generate
   ```

8. Ngrok is automatically configured as a service in Docker Compose. To access it, use:
   ```bash
   docker-compose logs ngrok
   ```

## 🚀 Usage
### API Routes
- **POST /event** - Creates an event (deposit, withdrawal, transfer)
  ```json
  {
    "type": "deposit",
    "destination": "100",
    "amount": 10
  }
  ```

- **GET /balance** - Retrieves the balance of an account
  ```json
  {
    "account_id": "100"
  }
  ```

## ✅ Testing
- To run tests:
  ```bash
   docker-compose exec app bash
   php artisan test
   ```

## ⚡ Deployment
- In production, configure the `.env` file with:
  ```env
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://your-domain.com
  LOG_LEVEL=error
  ```

- Ensure that the server uses HTTPS and that Rate Limiting is active on the routes.

## ⚠️ Troubleshooting
### Common Issues with Docker and Laravel
1. **Container cannot connect to MySQL:**
   - Make sure MySQL container is running.
   - Verify `.env` has the correct database credentials.

2. **Migrations fail:**
   - Access the application container: `docker-compose exec app bash`.
   - Run: `php artisan migrate:reset && php artisan migrate`.

3. **Application key missing:**
   - Run: `php artisan key:generate`.

4. **500 Internal Server Error:**
   - Check the container logs: `docker-compose logs app`.
   - Verify if the `.env` file has correct configurations.

## 📌 Author
Developed by João Victor Morais de Mello
