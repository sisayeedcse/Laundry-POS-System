<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Permission matrix defining which roles can access which features
     */
    private const PERMISSIONS = [
        'admin' => ['*'], // Full access to everything
        'manager' => [
            'dashboard', 'pos', 'orders', 'customers', 'services', 
            'inventory', 'expenses', 'reports', 'users.view'
        ],
        'staff' => [
            'dashboard', 'pos', 'orders.view', 'orders.create', 
            'customers', 'services.view'
        ],
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Allowed roles for this route
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // If user is not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login');
        }

        // If no roles specified, allow any authenticated user
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has one of the allowed roles
        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Access denied
        abort(403, 'Unauthorized access. You do not have permission to access this resource.');
    }

    /**
     * Check if a user has permission for a specific feature
     */
    public static function hasPermission(string $userRole, string $permission): bool
    {
        // Admin has access to everything
        if ($userRole === 'admin') {
            return true;
        }

        // Check if role exists and has the permission
        if (isset(self::PERMISSIONS[$userRole])) {
            $permissions = self::PERMISSIONS[$userRole];
            
            // Check for wildcard or exact match
            return in_array('*', $permissions, true) || in_array($permission, $permissions, true);
        }

        return false;
    }

    /**
     * Check if user can manage users (admin only)
     */
    public static function canManageUsers(string $userRole): bool
    {
        return $userRole === 'admin';
    }

    /**
     * Check if user can manage settings (admin and manager)
     */
    public static function canManageSettings(string $userRole): bool
    {
        return in_array($userRole, ['admin', 'manager'], true);
    }

    /**
     * Check if user can view reports (admin and manager)
     */
    public static function canViewReports(string $userRole): bool
    {
        return in_array($userRole, ['admin', 'manager'], true);
    }

    /**
     * Check if user can manage inventory (admin and manager)
     */
    public static function canManageInventory(string $userRole): bool
    {
        return in_array($userRole, ['admin', 'manager'], true);
    }

    /**
     * Check if user can manage expenses (admin and manager)
     */
    public static function canManageExpenses(string $userRole): bool
    {
        return in_array($userRole, ['admin', 'manager'], true);
    }

    /**
     * Check if user can delete orders (admin only)
     */
    public static function canDeleteOrders(string $userRole): bool
    {
        return $userRole === 'admin';
    }

    /**
     * Get user role display name
     */
    public static function getRoleDisplayName(string $role): string
    {
        return match($role) {
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            default => ucfirst($role),
        };
    }

    /**
     * Get all available roles
     */
    public static function getAllRoles(): array
    {
        return ['admin', 'manager', 'staff'];
    }
}

