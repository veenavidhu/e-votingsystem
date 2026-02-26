<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main analytics dashboard.
     * Calculates turnout rates, total votes, and identifies frontrunners.
     */
    public function index()
    {
        $candidates = Candidate::withCount('votes')->get();
        $totalVotes = $candidates->sum('votes_count');

        // Participation Analytics
        $totalVoters = \App\Models\User::where('role', 'voter')->count();
        $votesCast = \App\Models\User::where('role', 'voter')->where('has_voted', true)->count();
        $turnoutPercentage = $totalVoters > 0 ? round(($votesCast / $totalVoters) * 100, 1) : 0;

        // Tie-Breaking Logic: Get all candidates with the maximum votes
        $maxVotes = $candidates->max('votes_count');
        $frontrunners = $totalVotes > 0
            ? $candidates->where('votes_count', $maxVotes)
            : collect();

        return view('dashboard', compact('candidates', 'totalVotes', 'frontrunners', 'totalVoters', 'votesCast', 'turnoutPercentage'));
    }
}
