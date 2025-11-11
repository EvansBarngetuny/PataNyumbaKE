<?php

namespace App\Http\Livewire;

use App\Models\Listing;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AnalyticsTable extends Component
{
    public $successfulMatches;

    public $matchPercentageChange;

    public $vacantProperties;

    public $vacantChange;

    public $avgResponseTime;

    public $responseTimeChange;

    public $healthScore;

    public $healthStatus;

    public $popularCounties;

    public $bookedHouses;

    public $ocupiedCategories;

    public $timeRange = 'month';

    protected $listeners = ['refreshAnalytics' => 'loadData', 'timeRangeChanged' => 'setTimeRange'];

    public function mount()
    {
        $this->loadData();
    }

    public function setTimeRange($range)
    {
        $this->timeRange = $range;
        $this->loadData();
    }

    public function loadData()
    {
        $dateRange = $this->getDateRange($this->timeRange);
        $previousDateRange = $this->getPreviousDateRange($this->timeRange); // Fixed: changed $this->dateRange to $this->timeRange

        // Successful matches
        $this->successfulMatches = Message::where('is_successful', true)
            ->whereBetween('created_at', $dateRange)
            ->count();

        $previousMonthMatches = Message::where('is_successful', true)
            ->whereBetween('created_at', $previousDateRange) // Fixed: using correct variable
            ->count();

        $this->matchPercentageChange = $previousMonthMatches > 0
            ? round(($this->successfulMatches - $previousMonthMatches) / $previousMonthMatches * 100)
            : 100;

        // Vacant properties
        $this->vacantProperties = Listing::where('status', 'vacant')->count();

        $lastWeekVacant = Listing::where('status', 'vacant')
            ->whereBetween('updated_at', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek(),
            ])
            ->count();

        $this->vacantChange = $lastWeekVacant > 0
            ? round(($this->vacantProperties - $lastWeekVacant) / $lastWeekVacant * 100)
            : 0;

        // Response Time
        $this->avgResponseTime = DB::table('messages as m')
            ->join('messages as parent', 'parent.id', '=', 'm.parent_id')
            ->whereNotNull('m.parent_id')
            ->whereBetween('m.created_at', $dateRange)
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, parent.created_at, m.created_at) / 60) as avg_hours')
            ->first()->avg_hours;

        $previousAvgResponse = DB::table('messages as m')
            ->join('messages as parent', 'parent.id', '=', 'm.parent_id')
            ->whereNotNull('m.parent_id')
            ->whereBetween('m.created_at', $previousDateRange) // Fixed: using correct variable
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, parent.created_at, m.created_at) / 60) as avg_hours')
            ->first()->avg_hours;

        $this->responseTimeChange = $previousAvgResponse > 0
            ? round((($previousAvgResponse - $this->avgResponseTime) / $previousAvgResponse) * 100)
            : 0;

        // Platform health
        $activeUsers = User::where('last_active_at', '>', now()->subDay())->count();
        $totalUsers = User::count();
        $this->healthScore = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 100;
        $this->healthStatus = $this->healthScore > 90 ? 'All systems operational' :
                    ($this->healthScore > 70 ? 'Minor issues' : 'Needs attention');

        // Popular counties
        $this->popularCounties = Listing::select('county', DB::raw('COUNT(*) as total'))
            ->where('status', 'occupied')
            ->groupBy('county')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Booked houses
        $this->bookedHouses = Listing::select('category', DB::raw('COUNT(*) as total'))
            ->where('status', 'Booked')
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        // Occupied categories
        $this->ocupiedCategories = Listing::select('category', DB::raw('COUNT(*) as total'))
            ->where('status', 'occupied')
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(3)
            ->get();
    }

    private function getDateRange($range)
    {
        switch ($range) {
            case 'today':
                return [now()->startOfDay(), now()];
            case 'week':
                return [now()->startOfWeek(), now()];
            case 'year':
                return [now()->startOfYear(), now()];
            case 'month':
            default:
                return [now()->startOfMonth(), now()];
        }
    }

    private function getPreviousDateRange($range)
    {
        switch ($range) {
            case 'today':
                return [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()];
            case 'week':
                return [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()];
            case 'year':
                return [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()];
            case 'month':
            default:
                return [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()];
        }
    }

    public function render()
    {
        return view('livewire.analytics-table');
    }
}
