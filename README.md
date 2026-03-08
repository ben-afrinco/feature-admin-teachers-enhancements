# LingoPulse AI — Graduation Project

A Laravel 12 English proficiency assessment platform with AI-powered explanations via Ollama, real-time sessions with Jitsi, and role-based dashboards for Students, Teachers, and Admins.

---

## Requirements

Before you begin, make sure you have the following installed:

| Tool | Version |
|------|---------|
| PHP | ≥ 8.2 |
| Composer | ≥ 2.x |
| Node.js + NPM | ≥ 18.x |
| Git | any |
| Ollama *(optional for AI)* | any |
| Docker + Docker Compose *(optional)* | any |

---

## 🚀 Method 1: Local Setup (Step-by-Step)

### Step 1 — Clone the Repository

```bash
git clone https://github.com/your-username/graduation-project.git
cd graduation-project
```

### Step 2 — Install PHP Dependencies

```bash
composer install
```

### Step 3 — Install JavaScript Dependencies & Build Assets

```bash
npm install
npm run build
```

### Step 4 — Configure Environment Variables

```bash
cp .env.example .env
```

Then open `.env` and verify/update these values:

```env
APP_NAME=LingoPulse
APP_ENV=local
APP_KEY=         # will be generated in the next step
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_DATABASE is auto-resolved to database/database.sqlite

OLLAMA_URL=http://localhost:11434
```

### Step 5 — Generate Application Key

```bash
php artisan key:generate
```

### Step 6 — Create the SQLite Database & Run Migrations

```bash
touch database/database.sqlite
php artisan migrate
```

### Step 7 — Set Storage Permissions

```bash
chmod -R 775 storage bootstrap/cache
```

### Step 8 — Start Ollama (optional — required for AI explanations)

```bash
ollama serve
```

> Make sure the model used by the app is pulled: `ollama pull tinyllama:1.1b`

### Step 9 — Start the Development Server

```bash
php artisan serve
```

Access the app at: **http://localhost:8000**

---

## 🐳 Method 2: Docker Setup (Recommended)

This method runs the entire application inside a Docker container and connects it to your local Ollama instance.

### Step 1 — Clone the Repository

```bash
git clone https://github.com/your-username/graduation-project.git
cd graduation-project
```

### Step 2 — Configure the `.env` File

```bash
cp .env.example .env
```

> No need to change anything for a basic Docker run — the `OLLAMA_URL` is automatically set to `http://host.docker.internal:11434` in `docker-compose.yml`.

### Step 3 — Start Ollama on your host machine

Docker containers cannot reach `127.0.0.1` on the host; you must bind Ollama to all interfaces:

```bash
OLLAMA_HOST=0.0.0.0:11434 ollama serve
```

> Verify Ollama is running: `curl http://localhost:11434`

### Step 4 — Build and Start the Docker Container

```bash
docker compose up -d --build
```

This will:
- Build the PHP 8.2 + Apache image (with Node.js multi-stage Vite build).
- Auto-generate `APP_KEY`.
- Create `database/database.sqlite`.
- Run all migrations with `php artisan migrate --force`.
- Start the Apache server.

### Step 5 — Access the Application

Open your browser at: **http://localhost:8000**

---

## 🔧 Useful Commands

| Command | Description |
|---------|-------------|
| `docker compose logs -f` | View container logs live |
| `docker compose down` | Stop and remove the container |
| `docker compose up -d` | Start the container (without re-building) |
| `docker exec -it lingopulse_app bash` | Access the container shell |
| `php artisan migrate:fresh --seed` | Reset database and seed |
| `php artisan tinker` | Interactive PHP console |

---

## 📁 Project Structure

```
graduation-project/
├── app/
│   └── Http/Controllers/   # All controllers (Test, Ollama, Admin, etc.)
├── database/
│   └── database.sqlite     # SQLite database
├── docs/
│   └── interfaces/         # Full page and function documentation
├── resources/views/        # Blade templates (student, teacher, admin)
├── routes/web.php          # All routes (Public, Student, Teacher, Admin)
├── Dockerfile              # Multi-stage Docker build
├── docker-compose.yml      # Docker orchestration
└── docker-entrypoint.sh    # Startup script inside container
```

---

## 👥 Roles

| Role | Access | Login Method |
|------|--------|--------------|
| **Student** | Tests, Results, Assignments | Registers with name & email |
| **Teacher** | Dashboard, Sessions, Grades | Email + Password |
| **Admin** | User & Class Management | Email + Password |

---

## 🤖 Ollama AI Explanation

The application uses [Ollama](https://ollama.com) to provide streaming AI explanations for incorrect test answers.

- Default model: `tinyllama:1.1b`
- To change the model, update the `OllamaController.php` or set `OLLAMA_MODEL` in `.env`.

---

## 📄 License

For academic use only.
