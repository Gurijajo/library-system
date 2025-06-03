<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class SystemCheckService
{
    private $errors = [];
    private $warnings = [];
    private $info = [];

    /**
     * Run complete system check
     * Created by: Guram-jajanidze
     * Date: 2025-06-03 10:50:06 UTC
     */
    public function runCompleteCheck(): array
    {
        $this->errors = [];
        $this->warnings = [];
        $this->info = [];

        $this->checkApplicationStructure();
        $this->checkDatabaseConnection();
        $this->checkModelsIntegrity();
        $this->checkControllersIntegrity();
        $this->checkRoutesIntegrity();
        $this->checkViewsIntegrity();
        $this->checkSecuritySettings();
        $this->checkPerformanceSettings();

        return $this->generateReport();
    }

    public function checkApplicationStructure(): bool
    {
        $requiredDirectories = [
            'app/Http/Controllers',
            'app/Models',
            'app/Services',
            'database/migrations',
            'database/seeders',
            'resources/views/books',
            'resources/views/reservations',
            'resources/views/borrowings',
            'storage/app',
            'storage/logs'
        ];

        foreach ($requiredDirectories as $dir) {
            if (!File::isDirectory(base_path($dir))) {
                $this->errors[] = "Directory არ არსებობს: {$dir}";
                return false;
            }
        }

        $this->info[] = "Application სტრუქტურა სწორია";
        return true;
    }

    public function checkDatabaseConnection(): bool
    {
        try {
            DB::connection()->getPdo();
            
            $tables = DB::select('SHOW TABLES');
            $tableCount = count($tables);
            
            $this->info[] = "Database კავშირი OK - {$tableCount} tables";
            return true;
        } catch (\Exception $e) {
            $this->errors[] = "Database კავშირის შეცდომა: " . $e->getMessage();
            return false;
        }
    }

    public function checkModelsIntegrity(): bool
    {
        $models = ['User', 'Book', 'Author', 'Category', 'Borrowing', 'Reservation'];
        
        foreach ($models as $model) {
            $className = "App\\Models\\{$model}";
            
            if (!class_exists($className)) {
                $this->errors[] = "Model არ არსებობს: {$model}";
                return false;
            }

            // Check if model has required methods/properties
            $reflection = new \ReflectionClass($className);
            
            if (!$reflection->hasProperty('fillable') && !$reflection->hasProperty('guarded')) {
                $this->warnings[] = "Model-ს არ აქვს fillable/guarded: {$model}";
            }
        }

        $this->info[] = "Models integrity OK";
        return true;
    }

    public function checkControllersIntegrity(): bool
    {
        $controllers = [
            'BookController',
            'ReservationController', 
            'BorrowingController',
            'CategoryController',
            'UserController',
            'DashboardController'
        ];

        foreach ($controllers as $controller) {
            $className = "App\\Http\\Controllers\\{$controller}";
            
            if (!class_exists($className)) {
                $this->errors[] = "Controller არ არსებობს: {$controller}";
                return false;
            }
        }

        $this->info[] = "Controllers integrity OK";
        return true;
    }

    public function checkRoutesIntegrity(): bool
    {
        $routes = Route::getRoutes();
        $routeCount = count($routes);

        if ($routeCount < 20) {
            $this->warnings[] = "Routes რაოდენობა ნაკლებია მოსალოდნელზე: {$routeCount}";
        }

        // Check for important routes
        $importantRoutes = [
            'dashboard',
            'books.index',
            'reservations.index',
            'borrowings.index'
        ];

        foreach ($importantRoutes as $routeName) {
            if (!Route::has($routeName)) {
                $this->warnings[] = "მნიშვნელოვანი route არ არის: {$routeName}";
            }
        }

        $this->info[] = "Routes count: {$routeCount}";
        return true;
    }

    public function checkViewsIntegrity(): bool
    {
        $requiredViews = [
            'layouts/app.blade.php',
            'dashboard/index.blade.php',
            'books/index.blade.php',
            'books/show.blade.php',
            'books/create.blade.php',
            'reservations/index.blade.php',
            'reservations/show.blade.php',
            'reservations/create.blade.php',
            'reservations/queue.blade.php'
        ];

        foreach ($requiredViews as $view) {
            if (!File::exists(resource_path("views/{$view}"))) {
                $this->errors[] = "View ფაილი არ არსებობს: {$view}";
                return false;
            }
        }

        $this->info[] = "Views integrity OK";
        return true;
    }

    public function checkSecuritySettings(): bool
    {
        // Check APP_KEY
        if (empty(config('app.key'))) {
            $this->errors[] = "APP_KEY არ არის დაყენებული";
            return false;
        }

        // Check debug mode in production
        if (config('app.env') === 'production' && config('app.debug') === true) {
            $this->warnings[] = "DEBUG mode ჩართულია production-ში";
        }

        // Check HTTPS in production
        if (config('app.env') === 'production' && !str_starts_with(config('app.url'), 'https://')) {
            $this->warnings[] = "HTTPS არ არის კონფიგურირებული production-ში";
        }

        $this->info[] = "Security settings შემოწმდა";
        return true;
    }

    public function checkPerformanceSettings(): bool
    {
        // Check if caches are configured
        $cacheFiles = [
            'bootstrap/cache/config.php',
            'bootstrap/cache/routes-v7.php'
        ];

        $hasCaches = false;
        foreach ($cacheFiles as $file) {
            if (File::exists(base_path($file))) {
                $hasCaches = true;
                break;
            }
        }

        if (!$hasCaches && config('app.env') === 'production') {
            $this->warnings[] = "Performance caches არ არის (გაუშვით: php artisan optimize)";
        }

        $this->info[] = "Performance settings შემოწმდა";
        return true;
    }

    private function generateReport(): array
    {
        return [
            'timestamp' => now()->toISOString(),
            'developer' => 'Guram-jajanidze',
            'version' => '1.0.0',
            'total_errors' => count($this->errors),
            'total_warnings' => count($this->warnings),
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'info' => $this->info,
            'status' => empty($this->errors) ? 'PASS' : 'FAIL'
        ];
    }

    public function saveReport(array $report): string
    {
        $filename = 'system-check-' . now()->format('Y-m-d-H-i-s') . '.json';
        Storage::disk('local')->put("reports/{$filename}", json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        return $filename;
    }
}