<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    /**
     * Display the voting booth with all available candidates.
     * Prevents access if the user has already voted.
     */
    public function index()
    {
        $candidates = Candidate::all();
        $user = Auth::user();

        if ($user->has_voted) {
            return redirect()->route('dashboard')->with('error', 'You have already cast your vote.');
        }

        return view('voting.index', compact('candidates'));
    }

    /**
     * Handle the submission of a vote.
     * Validates choice, checks for duplicate votes, and updates status.
     */
    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $user = Auth::user();

        if ($user->has_voted) {
            return redirect()->route('dashboard')->with('error', 'You have already cast your vote.');
        }

        Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $request->candidate_id,
        ]);

        $user->update(['has_voted' => true]);

        return redirect()->route('dashboard')->with('success', 'Your vote has been cast successfully!');
    }
}
