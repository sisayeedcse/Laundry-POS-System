<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = 'setting_' . $key;
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        Cache::forget('setting_' . $key);
    }

    /**
     * Cast value to appropriate type
     */
    protected static function castValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup(string $group): array
    {
        $cacheKey = 'settings_group_' . $group;
        
        return Cache::remember($cacheKey, 3600, function () use ($group) {
            $settings = Setting::where('group', $group)->get();
            
            $result = [];
            foreach ($settings as $setting) {
                $result[$setting->key] = self::castValue($setting->value, $setting->type);
            }
            
            return $result;
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }

    /**
     * Initialize default settings
     */
    public static function initializeDefaults(): void
    {
        $defaults = [
            // Business Settings
            ['key' => 'business_name', 'value' => 'Laundry POS', 'type' => 'string', 'group' => 'business', 'description' => 'Business name'],
            ['key' => 'business_address', 'value' => '', 'type' => 'string', 'group' => 'business', 'description' => 'Business address'],
            ['key' => 'business_phone', 'value' => '', 'type' => 'string', 'group' => 'business', 'description' => 'Business phone number'],
            ['key' => 'business_email', 'value' => '', 'type' => 'string', 'group' => 'business', 'description' => 'Business email'],
            ['key' => 'tax_rate', 'value' => '0', 'type' => 'float', 'group' => 'business', 'description' => 'Tax rate percentage'],
            ['key' => 'currency', 'value' => 'QAR', 'type' => 'string', 'group' => 'business', 'description' => 'Currency code'],
            ['key' => 'logo_path', 'value' => '', 'type' => 'string', 'group' => 'business', 'description' => 'Business logo path'],
            
            // Order Settings
            ['key' => 'order_prefix', 'value' => 'ORD', 'type' => 'string', 'group' => 'order', 'description' => 'Order number prefix'],
            ['key' => 'default_order_status', 'value' => 'pending', 'type' => 'string', 'group' => 'order', 'description' => 'Default order status'],
            ['key' => 'auto_print_receipt', 'value' => 'false', 'type' => 'boolean', 'group' => 'order', 'description' => 'Auto print receipt after order'],
            ['key' => 'require_customer', 'value' => 'true', 'type' => 'boolean', 'group' => 'order', 'description' => 'Require customer for orders'],
            ['key' => 'enable_express_service', 'value' => 'true', 'type' => 'boolean', 'group' => 'order', 'description' => 'Enable express service option'],
            ['key' => 'default_delivery_days', 'value' => '3', 'type' => 'integer', 'group' => 'order', 'description' => 'Default delivery days'],
            
            // System Settings
            ['key' => 'timezone', 'value' => 'Asia/Qatar', 'type' => 'string', 'group' => 'system', 'description' => 'System timezone'],
            ['key' => 'date_format', 'value' => 'Y-m-d', 'type' => 'string', 'group' => 'system', 'description' => 'Date format'],
            ['key' => 'time_format', 'value' => 'H:i:s', 'type' => 'string', 'group' => 'system', 'description' => 'Time format'],
            ['key' => 'items_per_page', 'value' => '10', 'type' => 'integer', 'group' => 'system', 'description' => 'Items per page in lists'],
            ['key' => 'enable_notifications', 'value' => 'true', 'type' => 'boolean', 'group' => 'system', 'description' => 'Enable system notifications'],
            ['key' => 'low_stock_threshold', 'value' => '10', 'type' => 'integer', 'group' => 'system', 'description' => 'Low stock alert threshold'],
        ];

        foreach ($defaults as $default) {
            self::firstOrCreate(
                ['key' => $default['key']],
                $default
            );
        }
    }
}
