<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$app->make('Illuminate\Contracts\Http\Kernel');

echo "=== Database Connection Check ===\n";
try {
    DB::connection()->getPdo();
    echo "✓ Database connected successfully\n";
} catch (\Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n=== Table Existence Check ===\n";
$tables = ['sliders', 'testimonials', 'settings', 'users'];
foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        $count = DB::table($table)->count();
        echo "✓ Table '$table' exists with $count records\n";
    } else {
        echo "✗ Table '$table' does NOT exist\n";
    }
}

echo "\n=== Sample Slider Data ===\n";
if (Schema::hasTable('sliders')) {
    $sliders = DB::table('sliders')->get();
    if ($sliders->count() > 0) {
        foreach ($sliders as $slider) {
            echo "  - {$slider->main_heading} (image: {$slider->slider_image})\n";
        }
    } else {
        echo "  No sliders found - you need to add some via admin panel\n";
    }
}

echo "\n=== Sample Testimonial Data ===\n";
if (Schema::hasTable('testimonials')) {
    $testimonials = DB::table('testimonials')->get();
    if ($testimonials->count() > 0) {
        foreach ($testimonials as $testimonial) {
            echo "  - {$testimonial->name} ({$testimonial->profession})\n";
        }
    } else {
        echo "  No testimonials found - you need to add some via admin panel\n";
    }
}
?>
