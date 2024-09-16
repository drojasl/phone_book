# Steps to Run the Project Locally

1. **Install dependencies**
    
    ```bash
    composer install
    ```
    ```bash
    npm install
    ```

2. **Start the Laravel Server**

    ```bash
    php artisan serve
    ```

3. **Start the Vue.js Development Server**

    ```bash
    npm run dev
    ```

4. **Configure Environment Variables**

    - Copy the `.env.example` file and rename it to `.env`:

      ```bash
      cp .env.example .env
      ```

    - Ensure the port in `VITE_APP_API_URL` matches the port of your Laravel server in the `.env` file.

5. **Generate the Application Key**

    ```bash
    php artisan key:generate
    ```

6. **Run Migrations**

    ```bash
    php artisan migrate
    ```