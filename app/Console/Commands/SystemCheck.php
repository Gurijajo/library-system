<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SystemCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:check 
                            {--detailed : Show detailed output}
                            {--json : Output as JSON}
                            {--save-report : Save report to file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LibraryMS სისტემის სრული შემოწმება - Created by Guram-jajanidze';

    private $errors = [];
    private $warnings = [];
    private $duplicates = [];
    private $info = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 LibraryMS System Check');
        $this->info('Developer: Guram-jajanidze');
        $this->info('Date: ' . now()->format('Y-m-d H:i:s') . ' UTC');
        $this->info('====================================');

        $this->newLine();

        // Run all checks
        $this->checkFileStructure();
        $this->checkDatabase();
        $this->checkRoutes();
        $this->checkModels();
        $this->checkControllers();
        $this->checkViews();
        $this->checkConfig();
        $this->checkPermissions();

        // Display results
        $this->displayResults();

        return Command::SUCCESS;
    }

    private function checkFileStructure()
    {
        $this->task('📁 File Structure შემოწმება', function () {
            $requiredDirs = [
                'app/Http/Controllers',
                'app/Models',
                'database/migrations',
                'resources/views',
                'routes'
            ];

            foreach ($requiredDirs as $dir) {
                if (!File::isDirectory(base_path($dir))) {
                    $this->errors[] = "❌ Directory არ არსებობს: {$dir}";
                    return false;
                }
            }

            return true;
        });
    }

    private function checkDatabase()
    {
        $this->task('🗃️ Database Connection შემოწმება', function () {
            try {
                DB::connection()->getPdo();
                
                // Check required tables
                $requiredTables = ['users', 'books', 'authors', 'categories', 'borrowings', 'reservations'];
                
                foreach ($requiredTables as $table) {
                    if (!DB::getSchemaBuilder()->hasTable($table)) {
                        $this->errors[] = "❌ Table არ არსებობს: {$table}";
                        return false;
                    }
                }

                return true;
            } catch (\Exception $e) {
                $this->errors[] = "❌ Database კავშირის შეცდომა: " . $e->getMessage();
                return false;
            }
        });
    }

    private function checkRoutes()
    {
        $this->task('🛣️ Routes შემოწმება', function () {
            $routes = Route::getRoutes();
            $routeCount = count($routes);
            
            if ($routeCount < 10) {
                $this->warnings[] = "⚠️ Routes ძალიან ცოტაა ({$routeCount})";
            }

            $this->info[] = "📊 სულ {$routeCount} route ნაპოვნია";
            return true;
        });
    }

    private function checkModels()
    {
        $this->task('🏗️ Models შემოწმება', function () {
            $modelPath = app_path('Models');
            $requiredModels = ['User.php', 'Book.php', 'Author.php', 'Category.php', 'Borrowing.php', 'Reservation.php'];
            
            foreach ($requiredModels as $model) {
                if (!File::exists($modelPath . '/' . $model)) {
                    $this->errors[] = "❌ Model არ არსებობს: {$model}";
                    return false;
                }
            }

            return true;
        });
    }

    private function checkControllers()
    {
        $this->task('🎮 Controllers შემოწმება', function () {
            $controllerPath = app_path('Http/Controllers');
            $requiredControllers = [
                'BookController.php',
                'ReservationController.php', 
                'BorrowingController.php',
                'DashboardController.php'
            ];
            
            foreach ($requiredControllers as $controller) {
                if (!File::exists($controllerPath . '/' . $controller)) {
                    $this->errors[] = "❌ Controller არ არსებობს: {$controller}";
                    return false;
                }
            }

            return true;
        });
    }

    private function checkViews()
    {
        $this->task('🗡️ Views შემოწმება', function () {
            $viewPath = resource_path('views');
            $requiredViewDirs = ['books', 'reservations', 'borrowings', 'layouts'];
            
            foreach ($requiredViewDirs as $dir) {
                if (!File::isDirectory($viewPath . '/' . $dir)) {
                    $this->errors[] = "❌ View directory არ არსებობს: {$dir}";
                    return false;
                }
            }

            return true;
        });
    }

    private function checkConfig()
    {
        $this->task('⚙️ Configuration შემოწმება', function () {
            // Check if app key is set
            if (empty(config('app.key'))) {
                $this->errors[] = "❌ APP_KEY არ არის დაყენებული";
                return false;
            }

            // Check database config
            if (empty(config('database.connections.mysql.database'))) {
                $this->errors[] = "❌ Database კონფიგურაცია არასრულია";
                return false;
            }

            return true;
        });
    }

    private function checkPermissions()
    {
        $this->task('🔐 Permissions შემოწმება', function () {
            $checkPaths = [
                'storage' => 775,
                'bootstrap/cache' => 775
            ];

            foreach ($checkPaths as $path => $expectedPerms) {
                $fullPath = base_path($path);
                if (File::exists($fullPath)) {
                    if (!File::isWritable($fullPath)) {
                        $this->warnings[] = "⚠️ არა-writable: {$path}";
                    }
                }
            }

            return true;
        });
    }

    private function displayResults()
    {
        $this->newLine();
        
        if (!empty($this->info)) {
            $this->line('<fg=blue>ℹ️ ინფორმაცია:</fg=blue>');
            foreach ($this->info as $info) {
                $this->line($info);
            }
            $this->newLine();
        }

        if (!empty($this->errors)) {
            $this->line('<fg=red>🚨 შეცდომები:</fg=red>');
            foreach ($this->errors as $error) {
                $this->line('<fg=red>' . $error . '</fg=red>');
            }
            $this->newLine();
        }

        if (!empty($this->warnings)) {
            $this->line('<fg=yellow>⚠️ გაფრთხილებები:</fg=yellow>');
            foreach ($this->warnings as $warning) {
                $this->line('<fg=yellow>' . $warning . '</fg=yellow>');
            }
            $this->newLine();
        }

        // Summary
        $totalIssues = count($this->errors) + count($this->warnings);
        
        if ($totalIssues === 0) {
            $this->line('<fg=green>🎉 ყველაფერი კარგადაა! სისტემა მზადაა!</fg=green>');
        } else {
            $this->line("<fg=cyan>📊 შედეგები: {$totalIssues} საკითხი ნაპოვნია</fg=cyan>");
        }

        // Save report if requested
        if ($this->option('save-report')) {
            $this->saveReport();
        }

        // JSON output if requested
        if ($this->option('json')) {
            $this->outputJson();
        }
    }

    private function saveReport()
    {
        $report = [
            'timestamp' => now()->toISOString(),
            'developer' => 'Guram-jajanidze',
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'info' => $this->info,
            'status' => empty($this->errors) ? 'PASS' : 'FAIL'
        ];

        $filename = 'system-check-' . now()->format('Y-m-d-H-i-s') . '.json';
        File::put(storage_path('logs/' . $filename), json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        $this->info("📄 რეპორტი შენახულია: storage/logs/{$filename}");
    }

    private function outputJson()
    {
        $output = [
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'info' => $this->info,
            'status' => empty($this->errors) ? 'PASS' : 'FAIL'
        ];

        $this->line(json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}