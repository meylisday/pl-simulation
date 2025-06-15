# Premier League Simulation

This is a full-stack simulation project that models a simplified Premier League season.

## Stack

- **Backend:** Laravel 12 (PHP 8.3+)
- **Frontend:** Vue 3 + Vite + Axios
- **Database:** MySQL 8.3
- **Containerized with:** Docker + Docker Compose

---

## Features

- Full season simulation of league matches.
- Match results calculated based on teams' strength.
- Standings table updated dynamically after each week.
- Monte Carlo simulation for predictions of final positions.
- Predictions recalculated after each week.
- Fully interactive frontend: `Next Week`, `Play All`, `Reset`.

---

## Setup Instructions

### Clone the repository

```
git clone https://github.com/meylisday/pl-simulation.git
cd pl-simulation
```

### Start Docker containers
```
docker-compose up --build
```

### Run migrations and seeders inside the backend container
```
docker-compose exec laravel-backend php artisan migrate:fresh --seed
```

### Access frontend
Visit:
http://localhost:5173

## Main API Endpoints

### Simulation Endpoints
- `POST /api/simulate/next`  
  Simulate next match week.
- `POST /api/simulate/predict`  
  Recalculate predictions based on current standings.
- `POST /api/simulate/reset`  
  Reset the entire season and clear data.
---
### Standings & Matches
- `GET /api/standings`  
  Retrieve the current league standings.
- `GET /api/weeks`  
  Retrieve list of all available weeks (and current week).
- `GET /api/matches/week/{weekId}`  
  Retrieve all matches scheduled for specific week.
---
### Predictions
- `GET /api/predictions`  
  Retrieve calculated predictions for all teams (probabilities for each final position).


