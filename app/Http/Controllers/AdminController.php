<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display detailed election results for administrative review.
     * Includes tie-breaking logic and vote counts.
     */
    public function results()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $candidates = Candidate::withCount('votes')->get();
        $totalVotes = $candidates->sum('votes_count');

        // Handle Ties: Get all candidates with the maximum votes
        $maxVotes = $candidates->max('votes_count');
        $frontrunners = $totalVotes > 0
            ? $candidates->where('votes_count', $maxVotes)
            : collect();

        return view('admin.results', compact('candidates', 'totalVotes', 'frontrunners'));
    }
}
