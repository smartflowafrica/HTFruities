<?php

use App\Models\SystemSetting;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    $setting = SystemSetting::where('entity', 'frontend_preloader')->first();
    $value = $setting ? $setting->value : 'Not Set';
    echo "frontend_preloader: " . $value . "\n";
    
    // Also check if there is an image associated with this value if it is an ID
    if(is_numeric($value)) {
        $upload = \App\Models\MediaManager::find($value);
        if($upload) {
             echo "Media Path: " . $upload->media_file . "\n";
        }
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
