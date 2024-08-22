# Fitness API

Welcome to the Fitness API repository! This project is a simple API designed for managing workout data, including CRUD operations, database integration, and testing.

## Table of Contents

- [Getting Started](#getting-started)
- [Prerequisites](#prerequisites)
- [Setup Instructions](#setup-instructions)
- [API](#API)


## Getting Started

To get started with the Fitness API, follow the steps below to set up and run the project on your local machine.

### Prerequisites

Ensure you have the following software installed:

- **PHP**: Version 8.0 or higher
- **Composer**: PHP dependency manager
- **MySQL**: Version 5.7 or higher
- **Node.js and npm** (Optional): For managing frontend dependencies if applicable

### Setup Instructions

1. **Clone the Repository**

   Clone the repository to your local machine:

   ```bash
   git clone https://github.com/your-username/fitness-api.git
   cd fitness-api

   make sure to have mysql server running.

   install npm packages using : npm install

   run database migrations using: php artisan migrate

   serve the application using : php artisan serve

   test endpoints using curl, thunderclient, postman etc

### API 

Once the setup is complete, you can access the API endpoints as follows:

- **GET**:  /api/workouts - Retrieve a list of all workouts
- **POST**: /api/workouts - Create a new workout
- **GET** /api/workouts/{id} - Retrieve a specific workout by ID
- **PUT** /api/workouts/{id} - Update a specific workout by ID
- **DELETE** /api/workouts/{id} - Delete a specific workout by ID
- The API will respond with JSON data.
