<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'voter')->count();
        $votedUsers = User::where('role', 'voter')->where('has_voted', true)->count();
        $pendingUsers = $totalUsers - $votedUsers;

        $votedPercentage = $totalUsers > 0 ? ($votedUsers / $totalUsers) * 100 : 0;

        $candidateStats = Candidate::withCount('votes')->get();
        $votes = Vote::with(['user', 'candidate'])->latest()->paginate(20);

        return view('admin.reports.index', compact(
            'totalUsers',
            'votedUsers',
            'pendingUsers',
            'votedPercentage',
            'candidateStats',
            'votes'
        ));
    }
}
