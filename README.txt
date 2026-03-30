Open command line terminals inside the backend and frontend folders

Backend terminal:
Download dependencies: 
- composer install
- npm install
- npm run build
Copy the .env file: cp .env.example .env
Generate a key for .env: php artisan key:generate

Build the database: php artisan migrate:fresh --seed

Run the PHP server: php artisan serve

To log into the admin account and CRUD go to: localhost:8000
Account provided: a@a.a
Password: P@$$w0rd

Frontend terminal:
Download dependencies: npm install
Run the frontend with: npm run dev
To view the frontend go to: localhost:5173


NOTES:
- Make sure backend is running first otherwise no data would appear on frontend
