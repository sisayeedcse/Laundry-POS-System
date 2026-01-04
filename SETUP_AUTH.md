# Authentication Setup Instructions

## Admin User Credentials

**Email:** sohanlaundry@admin.com  
**Password:** sohal2026laundry

## Setup Steps

1. **Run Migrations** (if not already done):

    ```bash
    php artisan migrate
    ```

2. **Seed the Admin User**:

    ```bash
    php artisan db:seed --class=AdminUserSeeder
    ```

    Or run all seeders:

    ```bash
    php artisan db:seed
    ```

3. **Clear Application Cache**:

    ```bash
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    ```

4. **Access the System**:
    - Navigate to: `http://localhost/laudryPOS/public/login`
    - Or if using Valet/Homestead: `http://laudrypos.test/login`
    - Enter the credentials above

## What Was Implemented

✅ **LoginController** - Handles authentication logic
✅ **Login View** - Professional login page with Amazing Laundry branding
✅ **AdminUserSeeder** - Creates the admin user
✅ **Route Protection** - All routes now require authentication
✅ **Auth Middleware** - Applied to all dashboard, POS, orders, customers, etc.
✅ **Logout Functionality** - Already implemented in sidebar

## Security Features

-   Password hashing using Laravel's Hash facade
-   CSRF protection on all forms
-   Session regeneration on login
-   Remember me functionality
-   Protected routes with auth middleware
-   Guest middleware on login routes (prevents authenticated users from seeing login)

## File Locations

-   **Controller:** `app/Http/Controllers/Auth/LoginController.php`
-   **View:** `resources/views/auth/login.blade.php`
-   **Seeder:** `database/seeders/AdminUserSeeder.php`
-   **Routes:** `routes/web.php` (updated with auth middleware)

## Notes

-   This is a single-user system (admin only)
-   No registration functionality (as per requirements)
-   No password reset (single admin user)
-   Email verification is already marked as verified in seeder
-   All routes except login are now protected by authentication

## Testing

After running the seeder, you can test by:

1. Visiting the homepage (should redirect to login if not authenticated)
2. Logging in with the credentials above
3. Accessing any protected route (dashboard, POS, etc.)
4. Clicking logout in the sidebar
