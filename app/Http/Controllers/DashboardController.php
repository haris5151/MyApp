<?php

namespace App\Http\Controllers;

use App\Models\CdCompany;
use App\Models\CdBranch;
use App\Models\MdService;
use App\Models\CdAppointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    public function countUsersByGender()
    {
        // Query to get the count of users grouped by gender
        $usersCountByGender = User::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get();

        // Initialize counters for male and female counts
        $maleCount = 0;
        $femaleCount = 0;

        // Iterate through the results to sum counts based on gender
        foreach ($usersCountByGender as $result) {
            if ($result->gender === 'male') {
                $maleCount = $result->count;
            } elseif ($result->gender === 'female') {
                $femaleCount = $result->count;
            }
        }

        // Return the counts of users by gender in a JSON response
        return response()->json([
            'male' => $maleCount,
            'female' => $femaleCount
        ]);
    }


    public function BranchesCreatedLastSevenDays()
    {
        // Initialize an array to store the count of companies for each day
        $companiesCountByDay = [];

        // Loop through the last 7 days (including today)
        for ($i = 0; $i < 7; $i++) {
            // Calculate the date for each day (going back from today)
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->toDateString(); // Get the date in 'YYYY-MM-DD' format

            // Query to count companies created on this day
            $companiesCount = CdBranch::whereDate('created_at', $formattedDate)
                ->count();

            // Store the count in the array
            $companiesCountByDay[] = $companiesCount;
        }

        // Reverse the array to have counts in chronological order (from oldest to newest)
        $companiesCountByDay = array_reverse($companiesCountByDay);

        // Return the array of company counts for the last 7 days
        return response()->json($companiesCountByDay);
    }


    public function ServicesCreatedLastSevenDays()
    {
        // Initialize an array to store the count of companies for each day
        $companiesCountByDay = [];

        // Loop through the last 7 days (including today)
        for ($i = 0; $i < 7; $i++) {
            // Calculate the date for each day (going back from today)
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->toDateString(); // Get the date in 'YYYY-MM-DD' format

            // Query to count companies created on this day
            $companiesCount = MdService::whereDate('created_at', $formattedDate)
                ->count();

            // Store the count in the array
            $companiesCountByDay[] = $companiesCount;
        }

        // Reverse the array to have counts in chronological order (from oldest to newest)
        $companiesCountByDay = array_reverse($companiesCountByDay);

        // Return the array of company counts for the last 7 days
        return response()->json($companiesCountByDay);
    }
    /**
     * Get the total counts of companies, branches, services, and users.
     */
    public function totalCounts()
    {
        // Count of companies
        $totalCompanies = CdCompany::count();

        // Count of branches
        $totalBranches = CdBranch::count();

        // Count of services
        $totalServices = MdService::count();
        $totalOrders = CdAppointment::count();

        // Count of users
        $totalUsers = User::count();

        // Return the total counts in a JSON response
        return response()->json([
            'total_companies' => $totalCompanies,
            'total_branches' => $totalBranches,
            'total_services' => $totalServices,
            'total_orders' => $totalOrders,
            'total_users' => $totalUsers,
        ]);
    }


    public function companiesCreatedLastSevenDays()
    {
        // Initialize an array to store the count of companies for each day
        $companiesCountByDay = [];

        // Loop through the last 7 days (including today)
        for ($i = 0; $i < 7; $i++) {
            // Calculate the date for each day (going back from today)
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->toDateString(); // Get the date in 'YYYY-MM-DD' format

            // Query to count companies created on this day
            $companiesCount = CdCompany::whereDate('created_at', $formattedDate)
                ->count();

            // Store the count in the array
            $companiesCountByDay[] = $companiesCount;
        }

        // Reverse the array to have counts in chronological order (from oldest to newest)
        $companiesCountByDay = array_reverse($companiesCountByDay);

        // Return the array of company counts for the last 7 days
        return response()->json($companiesCountByDay);
    }
    public function OrderCreatedLastSevenDays()
    {
        // Initialize an array to store the count of companies for each day
        $companiesCountByDay = [];

        // Loop through the last 7 days (including today)
        for ($i = 0; $i < 7; $i++) {
            // Calculate the date for each day (going back from today)
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->toDateString(); // Get the date in 'YYYY-MM-DD' format

            // Query to count companies created on this day
            $companiesCount = CdAppointment::whereDate('created_at', $formattedDate)
                ->count();

            // Store the count in the array
            $companiesCountByDay[] = $companiesCount;
        }

        // Reverse the array to have counts in chronological order (from oldest to newest)
        $companiesCountByDay = array_reverse($companiesCountByDay);

        // Return the array of company counts for the last 7 days
        return response()->json($companiesCountByDay);
    }

    public function orderCountsByStatus()
    {
        // Query to get the counts of orders grouped by status
        $orderCountsByStatus = CdAppointment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Initialize an array to hold the counts
        $orderCounts = [];

        // Iterate through the results and store in the array
        foreach ($orderCountsByStatus as $result) {
            $orderCounts[$result->status] = $result->count;
        }

        // Return the order counts by status in a JSON response
        return response()->json($orderCounts);
    }
}
