<?php

namespace App\Http\Controllers;

//use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SystemHealthController extends Controller
{
    //index
    public function index()
    {
        $systemStatus = $this->getSystemStatus();
        $serverStats = $this->getServerStats();
        $databaseStats = $this->getDatabaseStats();
        $cacheStats = $this->getCacheStats();
        $queueStats = $this->getQueueStats();
        $diskUsage = $this->getDiskUsage();
        $memoryUsage = $this->getMemoryUsage();
        $cpuUsage = $this->getCpuUsage();
        $chartData = $this->getChartData();
        $services = $this->getServicesStatus();

        return view('admin.system-health.index', compact(
            'systemStatus',
            'serverStats',
            'databaseStats',
            'cacheStats',
            'queueStats',
            'diskUsage',
            'memoryUsage',
            'cpuUsage',
            'chartData',
            'services'
        ));
}
//private function getSystemStatus()
//{
    // Check the system status (e.g., uptime, load average, etc.)
    //return [
      //  'uptime' => shell_exec('uptime'),
        //'load_average' => sys_getloadavg(),
        //'memory_usage' => memory_get_usage(),
        //'disk_space' => disk_free_space('/'),
        //'issues' => 0
    //];
//}
private function getSystemStatus()
{
    $loadAverage = [];
    $uptime = 'N/A';

    try {
        // Get uptime
        $uptime = shell_exec('uptime') ?? 'N/A';

        // Get CPU load with cross-platform support
        if (function_exists('sys_getloadavg')) {
            $loadAverage = sys_getloadavg();
        } else {
            // Windows fallback using WMIC
            $cpuLoad = shell_exec('wmic cpu get loadpercentage /format:value');
            if ($cpuLoad) {
                $loadPercentage = (float) filter_var($cpuLoad, FILTER_SANITIZE_NUMBER_FLOAT);
                $loadAverage = [$loadPercentage, 0, 0];
            }
        }
        $health = 'healthy'; // Default is healthy
        if (!empty($loadAverage) && $loadAverage[0] > 5) {
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
             'health' => 'unhealthy'
        ];
    }
}
private function getServerStats()
{
    // Get server stats (e.g., CPU usage, memory usage, etc.)
    $cpuLoad = $this->getCpuLoad();
    $uptime = 'N/A';
    $isAvailable = function_exists('sys_getloadavg');
    try {
        // Get uptime
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $uptime = shell_exec('uptime') ?? 'N/A';
        } else {
            $uptime = 'Uptime not available on Windows';
        }
    } catch (\Exception $e) {
        $uptime = 'N/A';
    }
    // Format the uptime
    //$uptime = $this->formatUptime($uptime);
    return [
        'cpu_usage' => [ 'load' => $cpuLoad, 'is_available' => $isAvailable,],
        'memory_usage' => memory_get_usage(),
        'disk_space' => disk_free_space('/'),
        'cpu_load' => $cpuLoad[0] ?? 0,
        'os' => PHP_OS,
        'uptime' => $this->formatUptime($uptime)
    ];
}
private function getDatabaseStats()
{
    // Get database stats (e.g., number of connections, queries per second, etc.)
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
private function getCacheStats()
{
    // Get cache stats (e.g., cache hits, misses, etc.)
    return [
        'cache_hits' => \Cache::get('cache_hits', 0),
        'cache_misses' => \Cache::get('cache_misses', 0),
    ];
}
private function getQueueStats()
{
    // Get queue stats (e.g., number of jobs, failed jobs, etc.)
    return [
        'jobs' => \DB::table('jobs')->count(),
        'failed_jobs' => \DB::table('failed_jobs')->count(),
    ];
}
private function getDiskUsage()
{
    // Get disk usage stats
    $diskTotal = disk_total_space('/');
    $diskFree = disk_free_space('/');
    $diskUsed = $diskTotal - $diskFree;
    $diskUsage = ($diskUsed / $diskTotal) * 100;

    return [
        'total' => $diskTotal,
        'free' => $diskFree,
        'used' => $diskUsed,
        'usage_percentage' => $diskUsage,
    ];
}
private function getMemoryUsage()
{
    // Get memory usage stats
    $memoryTotal = memory_get_usage(true);
    $memoryFree = $memoryTotal - memory_get_peak_usage();
    $memoryUsed = memory_get_usage();
    $memoryUsage = ($memoryUsed / $memoryTotal) * 100;

    return [
        'total' => $this->formatMemorySize($memoryTotal),
        'free' => $this->formatMemorySize($memoryFree),
        'used' => $this->formatMemorySize($memoryUsed),
        'usage_percentage' => round($memoryUsage, 2) . '%',
    ];
}
private function getCpuLoad()
{
    if (function_exists('sys_getloadavg')) {
        return sys_getloadavg();
    }

    try {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $cpu = shell_exec('wmic cpu get loadpercentage');
            return [(float) filter_var($cpu, FILTER_SANITIZE_NUMBER_FLOAT)];
        }

        // Mac/Linux fallback
        $load = explode(' ', shell_exec('uptime'));
        return array_map('floatval', array_slice($load, -3, 3));

    } catch (\Exception $e) {
        return [0, 0, 0];
    }
}
private function getCpuUsage()
{
    // Get CPU usage stats - Cross-platform
    if (function_exists('sys_getloadavg')) {
        return [
            'load' => sys_getloadavg(),
            'is_available' => true
        ];
    }

    // Windows-specific (COM) fallback
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        try {
            if (class_exists('COM')) {
                $wmi = new \COM("WinMgmts:\\\\.");
                $cpus = $wmi->ExecQuery("SELECT LoadPercentage FROM Win32_Processor");
                $load = 0;
                foreach ($cpus as $cpu) {
                    $load += $cpu->LoadPercentage;
                }
                return [
                    'load' => [$load / count($cpus), 0, 0],
                    'is_available' => true
                ];
            } else {
                throw new \Exception("COM class is not available.");
            }
        } catch (\Exception $e) {
            return [
                'load' => [0, 0, 0],
                'is_available' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    // Default for unsupported platforms
    return [
        'load' => [0, 0, 0],
        'is_available' => false
    ];
}

/*private function getChartData()
{
    // Fix duplicate return statement
    return [
        'cpu' => [
            'labels' => ['1 min', '5 min', '15 min'],
            'data' => $this->getCpuUsage()['load'],
        ],
        'memory' => [
            'labels' => ['Total', 'Free', 'Used'],
            'data' => [
                $this->getMemoryUsage()['total'],
                $this->getMemoryUsage()['free'],
                $this->getMemoryUsage()['used'],
            ],
        ],
        'disk' => [
            'labels' => ['Total', 'Free', 'Used'],
            'data' => [
                $this->getDiskUsage()['total'],
                $this->getDiskUsage()['free'],
                $this->getDiskUsage()['used'],
            ],
        ],
    ];
}*/
private function getChartData()
{
    return [
        'labels' => ['1 min', '5 min', '15 min'], // Use a common label for all datasets
        'cpu' => $this->getCpuUsage()['load'],
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
/*private function getChartData()
{
    // Get chart data for CPU, memory, and disk usage
    $cpuUsage = $this->getCpuUsage();
    $memoryUsage = $this->getMemoryUsage();
    $diskUsage = $this->getDiskUsage();

    return [
        'cpu' => [
            'labels' => ['1 min', '5 min', '15 min'],
            'data' => $cpuUsage['load'],
        ],
        'memory' => [
            'labels' => ['Total', 'Free', 'Used'],
            'data' => [
                $memoryUsage['total'],
                $memoryUsage['free'],
                $memoryUsage['used'],
            ],
        ],
        'disk' => [
            'labels' => ['Total', 'Free', 'Used'],
            'data' => [
                $diskUsage['total'],
                $diskUsage['free'],
                $diskUsage['used'],
            ],
        ],
    ];
    // Get CPU usage stats
    $cpuLoad = sys_getloadavg();

    return [
        'load' => $cpuLoad,
    ];
}
private function getServiceStatus()
{
    // Check the status of a specific service (e.g., MySQL, Redis, etc.)


    return Cache::remember('services_status', 60, function () {
        return [
            ['name' => 'Database', 'status' => $this->checkDatabase()],
            ['name' => 'Cache', 'status' => $this->checkCache()],
            ['name' => 'Queue', 'status' => $this->checkQueueWorker()],
        ];
    });
}*/
private function getServicesStatus()
{
    // Example services to monitor (you can customize this list)
    $services = [
        ['name' => 'Apache', 'status' => $this->checkServiceStatus('apache2')],
        ['name' => 'MySQL', 'status' => $this->checkServiceStatus('mysql')],
        // Add other services as needed
    ];

    return $services;
}
private function checkServiceStatus($serviceName)
{
    // Check service status using `systemctl` command or other methods
    $status = shell_exec("systemctl is-active $serviceName");

    return trim($status) === 'active';
}
private function checkDatabase()
{
    try {
        DB::connection()->getPdo();
        return true;
    } catch (\Exception $e) {
        return false;
    }
}
private function checkCache()
{
    try {
        Cache::put('test', 'test', 1);
        return Cache::has('test');
    } catch (\Exception $e) {
        return false;
    }
}

    private function checkQueue()
    {
        try {
            // Check if the queue worker is running
            $queueStatus = \Artisan::output();
            return strpos($queueStatus, 'queue:work') !== false;
        } catch (\Exception $e) {
            return false;
        }
}
private function formatUptime($uptime)
{
    // Format the uptime string into a more readable format
    preg_match('/up (.*),/', $uptime, $matches);
    if (isset($matches[1])) {
        return $matches[1];
    }
    return $uptime;
}
private function formatLoadAverage($loadAverage)
{
    // Format the load average into a more readable format
    return implode(', ', $loadAverage);
}
private function formatMemoryUsage($memoryUsage)
{
    // Format the memory usage into a more readable format
    return round($memoryUsage / 1024 / 1024, 2) . ' MB';
}
private function formatMemorySize($memorySize)
{
    // Format the memory size into a more readable format
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $power = $memorySize > 0 ? floor(log($memorySize, 1024)) : 0;
    return round($memorySize / 1024 ** $power, 2) . ' ' . $units[$power];
}
private function formatDiskSpace($diskSpace)
{
    // Format the disk space into a more readable format
    return round($diskSpace / 1024 / 1024 / 1024, 2) . ' GB';
}
private function formatDiskUsage($diskUsage)
{
    // Format the disk usage into a more readable format
    return round($diskUsage / 1024 / 1024 / 1024, 2) . ' GB';
}
private function formatCpuLoad($cpuLoad)
{
    // Format the CPU load into a more readable format
    return round($cpuLoad, 2) . ' %';
}

}
    // Format the memory usage into a more readable format
    // Check if the queue worker is running
