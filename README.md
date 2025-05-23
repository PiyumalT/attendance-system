# AttendancePro - Laravel Attendance & Payroll System

AttendancePro is a modern web application built with Laravel for managing employee attendance, leave requests, work schedules, and payroll. It is designed for HR teams, supervisors, and employees to easily track attendance, manage leaves, and generate salary reports. The system supports role-based access, salary calculations (including overtime, deductions, and EPF), and email notifications.

---

## Features
- User authentication and role-based permissions (Super Admin, HR Manager, Supervisor, Regular User)
- Mark and view attendance
- Manage users, roles, and permissions
- Work schedule management
- Leave request and approval workflow
- Salary info management and automated salary report generation
- Downloadable and emailable paysheets
- Responsive dashboard and navigation

---

## Getting Started

### 1. Clone the Repository

Open your terminal and run:

```bash
# Clone the project to your local machine
https://github.com/your-username/attendance-system.git
cd attendance-system
```

### 2. Install Dependencies

#### Install Composer dependencies:
```bash
composer install
```

#### Install NPM dependencies:
```bash
npm install
```

#### Build frontend assets:
```bash
npm run build
```

### 3. Environment Setup

Copy the example environment file and edit it:
```bash
cp .env.example .env
```

Open `.env` in a text editor and set the following (replace with your own values):

```
APP_NAME=AttendancePro
APP_URL=http://localhost

# Database settings
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite

# Email SMTP settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # or your SMTP provider
MAIL_PORT=2525
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=admin@example.com
MAIL_FROM_NAME="AttendancePro"

# Super Admin credentials
SUPERADMIN_EMAIL=superadmin@example.com
SUPERADMIN_PASSWORD=your_password_here
```

> **Note:** You can use SQLite for quick setup. For MySQL or others, update the DB settings accordingly.

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations and Seeders
```bash
php artisan migrate --seed
```
This will create the database tables and seed roles, permissions, and a super admin user.

### 6. Start the Development Server
```bash
php artisan serve
```
Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## Logging In
- Use the super admin credentials you set in `.env` to log in for the first time.
- You can then create and manage other users and roles from the dashboard.

---

## PHP Version Issues (XAMPP Users)
If you get errors about the PHP version, you may need to switch PHP versions in XAMPP. See this guide:
[How to Use Multiple PHP Versions in XAMPP](https://neutrondev.com/multiple-php-versions-in-xampp/)

---

## Customization & Tips
- Update your SMTP settings in `.env` to enable email notifications (for password resets, paysheets, etc).
- To change the super admin password/email, update the `.env` and re-run the seeder or update via the UI.
- For production, set `APP_ENV=production` and configure a secure mail provider.

---

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Need Help?
If you have issues or questions, feel free to open an issue or contact the maintainer.
