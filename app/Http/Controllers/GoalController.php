<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Auth::user()->goals()->pluck('tekst');
        return response()->json($goals);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tekst' => 'required|string|max:255'
        ]);

        $goal = Auth::user()->goals()->create([
            'tekst' => $request->tekst
        ]);

        return response()->json($goal, Response::HTTP_CREATED);
    }

    public function destroy(Goal $goal)
    {
        if ($goal->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $goal->delete();
        return response()->json(['message' => 'Goal deleted successfully']);
    }
}
