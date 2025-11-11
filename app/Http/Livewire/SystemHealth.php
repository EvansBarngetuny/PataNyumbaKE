<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SystemHealth extends Component
{
    public $refreshInterval = 10; // seconds

    public $lastUpdated;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->lastUpdated = now();
    }

    public function getSystemStatus()
    {
        return Cache::remember('system_status', $this->refreshInterval, function () {
            $loadAverage = [];
            $uptime = 'N/A';

            try {
                $uptime = shell_exec('uptime') ?? 'N/A';

                if (function_exists('sys_getloadavg')) {
                    $loadAverage = sys_getloadavg();
                } else {
                    $cpuLoad = shell_exec('wmic cpu get loadpercentage /format:value');
                    if ($cpuLoad) {
                        $loadPercentage = (float) filter_var($cpuLoad, FILTER_SANITIZE_NUMBER_FLOAT);
                        $loadAverage = [$loadPercentage, 0, 0];
                    }
                }

                $health = 'healthy';
                if (! empty($loadAverage) && $loadAverage[0] > 5) {
                    $health = 'unhealthy';
                }

                return [
                    'uptime' => $this->formatUptime($uptime),
                    'load_average' => $loadAverage,
                    'memory_usage' => memory_get_usage(),
                    'disk_space' => disk_free_space('/'),
                    'issues' => 0,
                    'os' => PHP_OS,
                    'health' => $health,
                ];
            } catch (\Exception $e) {
                return [
                    'uptime' => 'N/A',
                    'load_average' => [0, 0, 0],
                    'memory_usage' => 0,
                    'disk_space' => 0,
                    'issues' => 1,
                    'os' => PHP_OS,
                    'health' => 'unhealthy',
                ];
            }
        });
    }

    public function getServerStats()
    {
        $cpuLoad = $this->getCpuLoad();
        $uptime = 'N/A';
        $isAvailable = function_exists('sys_getloadavg');

        try {
            $uptime = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
                ? shell_exec('uptime') ?? 'N/A'
                : 'Uptime not available on Windows';
        } catch (\Exception $e) {
            $uptime = 'N/A';
        }

        return [
            'cpu_usage' => ['load' => $cpuLoad, 'is_available' => $isAvailable],
            'memory_usage' => memory_get_usage(),
            'disk_space' => disk_free_space('/'),
            'cpu_load' => $cpuLoad[0] ?? 0,
            'os' => PHP_OS,
            'uptime' => $this->formatUptime($uptime),
        ];
    }

    public function getDatabaseStats()
    {
        try {
            $connections = DB::connection()->getPdo()->query('SHOW STATUS LIKE "Threads_connected"')->fetch();
            $maxConnections = DB::connection()->getPdo()->query('SHOW VARIABLES LIKE "max_connections"')->fetch();

            return [
                'connections' => $connections ? (int) $connections['Value'] : 0,
                'max_connections' => $maxConnections ? (int) $maxConnections['Value'] : 0,
            ];
        } catch (\Exception $e) {
            return [
                'connections' => 0,
                'max_connections' => 0,
            ];
        }
    }

    public function getCacheStats()
    {
        return [
            'cache_hits' => Cache::get('cache_hits', 0),
            'cache_misses' => Cache::get('cache_misses', 0),
        ];
    }

    public function getQueueStats()
    {
        return [
            'jobs' => \DB::table('jobs')->count(),
            'failed_jobs' => \DB::table('failed_jobs')->count(),
        ];
    }

    public function getDiskUsage()
    {
        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        $diskUsage = ($diskUsed / $diskTotal) * 100;

        $diskUsedCleaned = str_replace([' GB', ' MB', ' KB', ' B'], '', $this->formatDiskSpace($diskUsed));
        $diskFreeCleaned = str_replace([' GB', ' MB', ' KB', ' B'], '', $this->formatDiskSpace($diskFree));

        return [
            'total' => $diskTotal,
            'total_formatted' => $this->formatDiskSpace($diskTotal),
            'free' => $diskFree,
            'free_cleaned' => $diskFreeCleaned,
            'free_formatted' => $this->formatDiskSpace($diskFree),
            'used' => $diskUsed,
            'used_cleaned' => $diskUsedCleaned,
            'used_formatted' => $this->formatDiskSpace($diskUsed),
            'usage_percentage' => $diskUsage,
        ];
    }

    public function getMemoryUsage()
    {
        $memoryTotal = memory_get_usage(true);
        $memoryFree = $memoryTotal - memory_get_peak_usage();
        $memoryUsed = memory_get_usage();
        $memoryUsage = ($memoryUsed / $memoryTotal) * 100;

        $memoryUsedCleaned = str_replace([' GB', ' MB', ' KB', ' B'], '', $this->formatMemorySize($memoryUsed));
        $memoryFreeCleaned = str_replace([' GB', ' MB', ' KB', ' B'], '', $this->formatMemorySize($memoryFree));

        return [
            'total' => $this->formatMemorySize($memoryTotal),
            'free' => $this->formatMemorySize($memoryFree),
            'free_cleaned' => $memoryFreeCleaned,
            'used' => $this->formatMemorySize($memoryUsed),
            'used_cleaned' => $memoryUsedCleaned,
            'usage_percentage' => round($memoryUsage, 2).'%',
        ];
    }

    public function getCpuLoad()
    {
        if (function_exists('sys_getloadavg')) {
            return sys_getloadavg();
        }

        try {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $cpu = shell_exec('wmic cpu get loadpercentage');

                return [(float) filter_var($cpu, FILTER_SANITIZE_NUMBER_FLOAT)];
            }

            $load = explode(' ', shell_exec('uptime'));

            return array_map('floatval', array_slice($load, -3, 3));
        } catch (\Exception $e) {
            return [0, 0, 0];
        }
    }

    public function getChartData()
    {
        return [
            'labels' => ['1 min', '5 min', '15 min'],
            'cpu' => $this->getCpuLoad(),
            'memory' => [
                $this->getMemoryUsage()['total'],
                $this->getMemoryUsage()['free'],
                $this->getMemoryUsage()['used'],
            ],
            'disk' => [
                $this->getDiskUsage()['total'],
                $this->getDiskUsage()['free'],
                $this->getDiskUsage()['used'],
            ],
        ];
    }

    public function getServicesStatus()
    {
        $services = [
            ['name' => 'Database', 'status' => $this->checkDatabase()],
            ['name' => 'Cache', 'status' => $this->checkCache()],
            ['name' => 'Queue', 'status' => $this->checkQueue()],
        ];

        if (function_exists('shell_exec')) {
            $services = array_merge($services, [
                ['name' => 'Apache', 'status' => $this->checkServiceStatus('apache2')],
                ['name' => 'MySQL', 'status' => $this->checkServiceStatus('mysql')],
            ]);
        }

        return $services;
    }

    public function checkServiceStatus($serviceName)
    {
        try {
            $status = shell_exec("systemctl is-active $serviceName");

            return trim($status) === 'active';
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkDatabase()
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkCache()
    {
        try {
            Cache::put('test', 'test', 1);

            return Cache::has('test');
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkQueue()
    {
        try {
            $queueStatus = \Artisan::output();

            return strpos($queueStatus, 'queue:work') !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function poll()
    {
        $this->lastUpdated = now();
        $this->emitSelf('refresh');
    }

    // Formatting methods
    private function formatUptime($uptime)
    {
        preg_match('/up (.*),/', $uptime, $matches);

        return $matches[1] ?? $uptime;
    }

    private function formatMemorySize($memorySize)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $memorySize > 0 ? floor(log($memorySize, 1024)) : 0;

        return round($memorySize / 1024 ** $power, 2).' '.$units[$power];
    }

    private function formatDiskSpace($diskSpace)
    {
        return round($diskSpace / 1024 / 1024 / 1024, 2).' GB';
    }

    public function render()
    {
        return view('livewire.system-health', [
            'systemStatus' => $this->getSystemStatus(),
            'serverStats' => $this->getServerStats(),
            'databaseStats' => $this->getDatabaseStats(),
            'cacheStats' => $this->getCacheStats(),
            'queueStats' => $this->getQueueStats(),
            'diskUsage' => $this->getDiskUsage(),
            'memoryUsage' => $this->getMemoryUsage(),
            'chartData' => $this->getChartData(),
            'services' => $this->getServicesStatus(),
        ]);
    }
}
