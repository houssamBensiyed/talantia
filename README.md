# 🌟 Talantia — Professional Talent & Recruitment Network

Talantia is a modern, high-performance professional network and decentralized-style recruitment platform. Built on top of the latest **Laravel 12.x** and **Livewire 4.x** stack, it empowers Job Seekers to showcase their professional profiles and build connections, while providing Recruiters with a robust Applicant Tracking System (ATS) to post job opportunities and manage applications.

---

## 🚀 Key Features

### 👤 Multi-Role User Profiles
- **Role-Based Workflows**: Separate, tailored experiences for **Job Seekers** and **Recruiters**.
- **User Slugs**: Clean, SEO-friendly URLs (`/users/john-doe`) generated dynamically with SQLite-safe unique slugging.

### 📄 Interactive CV & Resume Builder (Job Seekers)
- **Candidate Profiles**: Custom bio, profile picture, title, and social links.
- **Formations (Education)**: Create, track, and update academic credentials.
- **Experiences**: Manage professional history, roles, companies, and durations.
- **Skill Tagging**: Seamless interactive skills management.

### 💼 Smart Job Board & ATS (Recruiters)
- **Job Offers Lifecycle**: Create, edit, publish, close, and reopen job listings.
- **Application Flow**: Job seekers apply directly to open jobs with one click.
- **Status Pipeline**: Recruiters can move applications through a pipeline: `Pending` ➡️ `Under Review` ➡️ `Accepted` or `Rejected` in real-time.
- **Application Tracking**: Detailed overview of active applications for both applicants and recruiters.

### 🤝 Professional Networking Engine
- **Friendship Lifecycle**: High-performance connection system allowing users to send, accept, reject, or cancel connection requests.
- **My Circle**: A dedicated space to manage active professional connections.
- **Discovery Search**: Live searching and filtering of professional users and active job openings.

---

## 🛠️ The Tech Stack

- **Framework**: Laravel 12.x
- **Frontend Interactivity**: Livewire 4.x & AlpineJS
- **Styling**: Tailwind CSS v4 & PostCSS
- **Build Tool**: Vite v7
- **Database**: SQLite (Pre-migrated, high-speed single-file DB)
- **Deployment & Containers**: Docker CLI (Composer / PHP isolated containers)

---

## 💻 Quick Start & Running Guide

This project is configured to run smoothly in a **Smart Hybrid Environment**. If you do not have PHP or Composer installed locally on your host machine, you can run all PHP processes in lightweight Docker containers while running Vite natively on your host.

### 📋 Prerequisites
- **Docker** (For isolated PHP/Laravel environment)
- **Node.js** (v22+) & **NPM** (For blazing fast frontend compilation)

---

### 1️⃣ Run the PHP Server & Queue (Docker)

To run the application back-end, launch the isolated containers using the official Composer/PHP Docker image:

```bash
# 1. Start the Laravel App Server (Port 8000)
docker run -d --name talantia-app \
  -p 8000:8000 \
  -v "$(pwd)":/app \
  -w /app \
  --entrypoint php \
  composer artisan serve --host=0.0.0.0 --port=8000

# 2. Start the Queue Listener for Background Tasks
docker run -d --name talantia-queue \
  -v "$(pwd)":/app \
  -w /app \
  --entrypoint php \
  composer artisan queue:listen --tries=1
```

---

### 2️⃣ Run the Frontend Dev Server (Host)

Install frontend dependencies and start Vite with hot-reload directly on your host machine:

```bash
# Install packages
npm install

# Start Vite server
npm run dev
```

Your services are now running at:
- **Application Homepage**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Vite Dev Server**: [http://localhost:5173](http://localhost:5173)

---

### 3️⃣ Managing PHP Commands via Docker

Since PHP is run inside Docker, use the following command wrappers to manage your database, seeders, or cache:

```bash
# Run Database Migrations
docker run --rm --entrypoint php -v "$(pwd)":/app -w /app composer artisan migrate

# Seed the Database
docker run --rm --entrypoint php -v "$(pwd)":/app -w /app composer artisan db:seed

# Clear Application Cache
docker run --rm --entrypoint php -v "$(pwd)":/app -w /app composer artisan cache:clear

# Run Pest PHP Unit Tests
docker run --rm --entrypoint php -v "$(pwd)":/app -w /app composer artisan test
```

To stop and clean up the backend containers:
```bash
docker rm -f talantia-app talantia-queue
```

---

## 📂 Project Architecture

```
talantia/
├── app/                  # Core Laravel PHP Logic
│   ├── Http/             # Controllers, Middlewares, Requests
│   └── Models/           # Eloquent Database Models
├── bootstrap/            # Application Bootstrap & Configuration
├── config/               # App configuration files
├── database/             # SQLite migrations, seeders, and factories
├── resources/            # Front-end resources (Blade views, CSS, JS)
│   ├── css/              # App Tailwind styling
│   ├── js/               # Client-side AlpineJS
│   └── views/            # Laravel Blade templates & Livewire components
├── routes/               # Web & Auth Route definitions
├── tests/                # Pest/PHPUnit testing suite
├── vite.config.js        # Vite compiler configuration
└── package.json          # Node dependencies & custom dev scripts
```

---

## 📝 License

The Talantia project is open-sourced software licensed under the [MIT license](LICENSE).
