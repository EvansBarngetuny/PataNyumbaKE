<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Fetch analytics data from the database or any other source
        $popularCounties = Listing::select('county', DB::raw('COUNT(*) as total'))
            ->where('status', 'occupied')
            ->groupBy('county')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $bookedHouses = Listing::select('category', DB::raw('COUNT(*) as total'))
    ->where('status', 'Booked')
    ->groupBy('category')
    ->orderByDesc('total')
    ->limit(3)
    ->get();

        $ocupiedCategories = Listing::select('category', DB::raw('COUNT(*) as total'))
            ->where('status', 'occupied')
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        // $successfulMatches = Message::where('is_successful', true)
        //  ->whereBetween('created_at', [now()->startOfMonth(), now()])
        // ->count();
        // $previousMonthMatches = Message::where('is_successful', true)
        // ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
        // ->count();

        //        $matchPercentageChange = $previousMonthMatches > 0 ? round(($successfulMatches - $previousMonthMatches) / $previousMonthMatches * 100) : 100;

        $successfulMatches = Message::where('is_successful', true)
    ->whereBetween('created_at', [now()->startOfMonth(), now()])
    ->count();

        $previousMonthMatches = Message::where('is_successful', true)
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->count();
        $matchPercentageChange = $previousMonthMatches > 0
          ? round(($successfulMatches - $previousMonthMatches) / $previousMonthMatches * 100)
          : 100;

        $vacantProperties = Listing::where('status', 'vacant')
            ->count();
        $lastWeekVacant = Listing::where('status', 'vacant')
            ->whereBetween('updated_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        $vacantChange = $lastWeekVacant > 0 ?
        round(($vacantProperties - $lastWeekVacant) / $lastWeekVacant * 100) : 0;

        $avgResponseTime = DB::table('messages as m')
    ->join('messages as parent', 'parent.id', '=', 'm.parent_id')
    ->whereNotNull('m.parent_id')
    ->whereBetween('m.created_at', [Carbon::now()->subMonth(), Carbon::now()])
    ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, parent.created_at, m.created_at) / 60) as avg_hours')
    ->first()->avg_hours;

        // 4. Average Response Time (previous month)
        $previousAvgResponse = DB::table('messages as m')
            ->join('messages as parent', 'parent.id', '=', 'm.parent_id')
            ->whereNotNull('m.parent_id')
            ->whereBetween('m.created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, parent.created_at, m.created_at) / 60) as avg_hours')
            ->first()->avg_hours;

        $responseTimeChange = $previousAvgResponse > 0
    ? round((($previousAvgResponse - $avgResponseTime) / $previousAvgResponse) * 100)
    : 0;
        /*$avgResponseTime = Message::whereNotNull('messages.parent_id') // Specify table
           ->whereBetween('messages.created_at', [now()->subMonth(), now()])
           ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, parent_message.created_at, messages.created_at)/60) as avg_hours'))
           ->join('messages as parent_message', 'messages.parent_id', '=', 'parent_message.id')
           ->first()->avg_hours;

        $previousAvgResponse = Message::whereNotNull('parent_id')
            ->whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, parent_message.created_at, messages.created_at)/60) as avg_hours'))
            ->join('messages as parent_message', 'messages.parent_id', '=', 'parent_message.id')
            ->first()->avg_hours;

        $responseTimeChange = $previousAvgResponse > 0
            ? round((($previousAvgResponse - $avgResponseTime) / $previousAvgResponse) * 100)
            : 0; */
        // 4. Platform Health (mock data - would be real monitoring in production)
        $activeUsers = User::where('last_active_at', '>', now()->subDay())->count();
        $totalUsers = User::count();
        $healthScore = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 100;
        $healthStatus = $healthScore > 90 ? 'All systems operational' :
                    ($healthScore > 70 ? 'Minor issues' : 'Needs attention');

        return view('admin.analytics.index', compact(
            'ocupiedCategories',
            'matchPercentageChange',
            'bookedHouses',
            'vacantProperties',
            'vacantChange',
            'avgResponseTime',
            'responseTimeChange',
            'healthScore',
            'healthStatus',
            'popularCounties',
            'successfulMatches'
        ));
    }
}
