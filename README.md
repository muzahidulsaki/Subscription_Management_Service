<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Subscription Management Microservice

A standalone backend microservice developed with **Laravel** to handle user subscription plans, durations, and expiration logic. This service is containerized using **Docker** for easy deployment and testing.

##  Features

- **Package Management:** Pre-seeded packages (Gold, Platinum, Diamond, Trial).
- **Subscription Logic:**
  - Users can subscribe to plans.
  - **Trial Logic:** A user can only avail of the "Trial" package once.
  - **Overlap Protection:** A user cannot have two active subscriptions simultaneously.
  - **Auto Expiry:** Expiration dates are calculated automatically based on package duration.
- **History & Status:** Check active subscription status and full subscription history.
- **Microservice Architecture:** No internal user authentication (relies on external `user_id`).

##  Tech Stack

- **Framework:** Laravel (Latest Stable)
- **Database:** MySQL 8.0
- **Containerization:** Docker & Docker Compose
- **Language:** PHP 8.2

---

##  Installation & Running (Docker)

You can run the entire project with a few commands using Docker.

### Prerequisites
- Docker Desktop installed and running.
- Git installed.

### Step-by-Step Guide

1. **Clone the Repository**
   ```bash
   git clone [https://github.com/YOUR_USERNAME/subscription-service.git](https://github.com/YOUR_USERNAME/subscription-service.git)
   cd subscription-service
2. **Setup Environment**
   ```bash
   cp .env.example .env
3. **Start Containers**
   ```bash
   docker compose up -d --build
4. **Install Dependencies & Database Setup**
   ```bash
   docker compose exec app composer install
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate:fresh --seed

##  Database Design (Overview)

### Packages Table
| Column | Description |
|------|------------|
| id | Primary key |
| name | Package name |
| price | Package price |
| duration_days | Duration in days |
| type | trial / monthly |

### Subscriptions Table
| Column | Description |
|------|------------|
| id | Primary key |
| user_id | External user ID |
| package_id | Linked package |
| type | trial / monthly |
| started_at | Subscription start |
| ends_at | Subscription expiry |

---

##  API Documentation

#### `1. Get All Packages`
Returns a list of available subscription packages.

- Endpoint: GET /api/subscribe
  
  ![image alt](https://github.com/muzahidulsaki/Subscription_Management_Service/blob/8701e4376ec0050b14cd2dce8927867d3a47301c/public/images/1.packages.png)

#### `2. Subscribe a User`
Assign a package to a user. Validates trial usage and overlapping subscriptions.

- Endpoint: POST /api/subscribe
- Body:
  
  ```bash
   {
    "user_id": 1002,
    "package_id": 1
    }

  
![image alt](https://github.com/muzahidulsaki/Subscription_Management_Service/blob/8701e4376ec0050b14cd2dce8927867d3a47301c/public/images/2.subscribe.png)

#### `3. Overlapping Subscriptions`
Assign a package to a user. Validates trial usage and overlapping subscriptions.

- Endpoint: POST /api/subscribe
- Body:
  
  ```bash
   {
    "user_id": 1002,
    "package_id": 1
    }

  
![image alt](https://github.com/muzahidulsaki/Subscription_Management_Service/blob/8701e4376ec0050b14cd2dce8927867d3a47301c/public/images/3.overlap.png)

#### `4. Check Subscription Status`
Check if a user has an active plan.

- Endpoint: GET /api/status/{user_id}

![image alt](https://github.com/muzahidulsaki/Subscription_Management_Service/blob/8701e4376ec0050b14cd2dce8927867d3a47301c/public/images/4.status.png)

#### `5. Subscription History`
View all past subscriptions for a user.

- Endpoint: GET /api/history/{user_id}

![image alt](https://github.com/muzahidulsaki/Subscription_Management_Service/blob/8701e4376ec0050b14cd2dce8927867d3a47301c/public/images/5.history.png)
