# CreateService Livewire Component - Documentation

## Overview

A fully functional Livewire component for creating laundry services with image upload capabilities.

## Features

✅ Modal-based form interface
✅ Image upload with live preview
✅ File validation (PNG/JPG, max 2MB)
✅ Local storage (storage/app/public/services)
✅ Real-time validation with error messages
✅ Loading states for better UX
✅ QAR currency support
✅ Strict PHP typing

## File Structure

### 1. Livewire Component Class

**Location:** `app/Livewire/CreateService.php`

**Key Features:**

-   Strict type declarations (`declare(strict_types=1)`)
-   File upload trait (`WithFileUploads`)
-   Validation attributes using PHP 8 attributes
-   Image preview functionality
-   Database storage with local file path

### 2. Service Model

**Location:** `app/Models/Service.php`

**Features:**

-   Mass assignable fields
-   Decimal casting for prices
-   Image URL accessor (`$service->image_url`)
-   Relationships with OrderItems
-   Query scopes (active, byCategory)

### 3. Blade View

**Location:** `resources/views/livewire/create-service.blade.php`

**Components:**

-   Trigger button
-   Modal overlay
-   Form with validation
-   Image preview
-   Loading indicators

## Usage

### Basic Implementation

```blade
<!-- In any Blade view -->
<livewire:create-service />
```

### In a Page Layout

```blade
<x-layouts.app title="Services">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Services Management</h1>
            <livewire:create-service />
        </div>
    </div>
</x-layouts.app>
```

## Database Schema

```php
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('image_path')->nullable();
    $table->string('category')->nullable();
    $table->decimal('price_normal', 10, 2)->default(0);
    $table->decimal('price_urgent', 10, 2)->default(0);
    $table->boolean('is_active')->default(true);
    $table->text('description')->nullable();
    $table->timestamps();
});
```

## Validation Rules

| Field        | Rules                                         |
| ------------ | --------------------------------------------- |
| name         | required, string, max:255                     |
| category     | nullable, string, max:255                     |
| price_normal | required, numeric, min:0                      |
| price_urgent | required, numeric, min:0                      |
| image        | nullable, image, max:2048, mimes:png,jpg,jpeg |

## File Upload Process

### 1. Image Selection

```php
public function updatedImage(): void
{
    $this->imagePreview = $this->image?->temporaryUrl();
}
```

-   Automatically triggered when file is selected
-   Generates temporary URL for preview
-   No server upload until form submission

### 2. File Storage

```php
if ($this->image) {
    $imagePath = $this->image->store('services', 'public');
}
```

-   Stores file in: `storage/app/public/services/`
-   Accessible via: `storage/services/{filename}`
-   Returns relative path stored in database

### 3. Retrieving Image URL

```php
// In Service Model
public function getImageUrlAttribute(): ?string
{
    if (!$this->image_path) {
        return null;
    }
    return Storage::disk('public')->url($this->image_path);
}

// Usage in Blade
<img src="{{ $service->image_url }}" alt="{{ $service->name }}">
```

## Storage Configuration

### Create Symbolic Link

```bash
php artisan storage:link
```

This creates: `public/storage -> storage/app/public`

### Storage Structure

```
storage/
└── app/
    └── public/
        └── services/
            ├── abc123.jpg
            ├── xyz789.png
            └── ...
```

### Public Access

```
http://localhost:8000/storage/services/abc123.jpg
```

## Component Events

### Emitted Events

```php
// After successful save
$this->dispatch('service-created');
```

### Listening for Events

```blade
<!-- In parent component or Alpine.js -->
<div
    x-data="{ services: [] }"
    @service-created.window="$wire.$refresh()"
>
    <!-- Component content -->
</div>
```

## Error Handling

### Validation Errors

-   Displayed below each field
-   Red border on invalid inputs
-   Real-time error messages

### File Upload Errors

```php
@error('image')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
```

Common errors:

-   File too large (>2MB)
-   Invalid file type (not PNG/JPG)
-   Upload failed

## Testing the Component

### 1. Navigate to Services Page

```
http://localhost:8000/services
```

### 2. Click "Add New Service"

-   Modal opens with form

### 3. Fill Form Fields

-   Name: "Shirt Wash"
-   Category: "Clothing"
-   Normal Price: 10.00
-   Urgent Price: 15.00
-   Image: Upload a PNG/JPG (max 2MB)

### 4. Submit Form

-   Loading state shows
-   Validation runs
-   File uploads to storage
-   Record saved to database
-   Modal closes
-   Success message displayed

## Customization

### Change Storage Path

```php
// In CreateService.php save() method
$imagePath = $this->image->store('custom-path', 'public');
```

### Add Description Field

```php
// In CreateService.php
#[Validate('nullable|string|max:1000')]
public string $description = '';

// In Service::create()
'description' => $validated['description'] ?? null,
```

### Change Max File Size

```php
// Change from 2MB to 5MB
#[Validate('nullable|image|max:5120|mimes:png,jpg,jpeg')]
public $image;
```

## Security Notes

✅ **Local Storage Only** - No external API calls
✅ **File Validation** - Type and size restrictions
✅ **CSRF Protection** - Built-in Laravel protection
✅ **Input Sanitization** - Laravel validation handles this
✅ **Unique Filenames** - Laravel auto-generates unique names

## Deployment on cPanel

### 1. Create Storage Directory

```bash
mkdir -p storage/app/public/services
chmod 755 storage/app/public/services
```

### 2. Create Symbolic Link

```bash
ln -s /home/username/public_html/storage/app/public /home/username/public_html/public/storage
```

### 3. Set Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## Troubleshooting

### Image Not Displaying

1. Check if storage link exists: `ls -la public/storage`
2. Verify file exists: `ls storage/app/public/services/`
3. Check permissions: `chmod 755 storage/app/public/services`

### Upload Fails

1. Check PHP upload limits in `php.ini`:
    ```ini
    upload_max_filesize = 2M
    post_max_size = 2M
    ```
2. Verify storage directory is writable
3. Check Laravel logs: `storage/logs/laravel.log`

### Validation Errors

1. Ensure image is PNG/JPG
2. Check file size (max 2MB = 2048KB)
3. Verify form fields are not empty

## API Reference

### Public Methods

```php
// Open modal
$this->openModal()

// Close modal
$this->closeModal()

// Save service
$this->save()

// Update image preview (auto-called)
$this->updatedImage()
```

### Public Properties

```php
public string $name = '';
public string $category = '';
public string $price_normal = '';
public string $price_urgent = '';
public $image;
public ?string $imagePreview = null;
public bool $showModal = false;
```

## Example Output

### Database Record

```json
{
    "id": 1,
    "name": "Shirt Wash",
    "image_path": "services/abc123xyz.jpg",
    "category": "Clothing",
    "price_normal": "10.00",
    "price_urgent": "15.00",
    "is_active": true,
    "created_at": "2026-01-03T21:30:00.000000Z",
    "updated_at": "2026-01-03T21:30:00.000000Z"
}
```

### Image URL

```
http://localhost:8000/storage/services/abc123xyz.jpg
```

---

**Created for:** Laundry POS System (Qatar)
**Laravel Version:** 11.47.0
**Livewire Version:** 3.7.3
**Currency:** QAR (Qatar Riyal)
