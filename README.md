# Steps to Run the Project Locally

1. **Start the Laravel Server**

    ```bash
    php artisan serve
    ```

2. **Start the Vue.js Development Server**

    ```bash
    npm run dev
    ```

3. **Configure Environment Variables**

    - Copy the `.env.example` file and rename it to `.env`:

      ```bash
      cp .env.example .env
      ```

    - Ensure the port in `VITE_APP_API_URL` matches the port of your Laravel server in the `.env` file.

4. **Generate the Application Key**

    ```bash
    php artisan key:generate
    ```

5. **Run Migrations**

    ```bash
    php artisan migrate
    ```