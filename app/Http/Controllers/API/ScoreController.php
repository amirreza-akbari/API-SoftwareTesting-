<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Score;

class ScoreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'score' => 'required|integer',
        ]);

        Score::create($request->all());

        return response()->json(['status' => 'success', 'message' => 'نمره با موفقیت ثبت شد']);
    }

    public function topScores()
    {
        $users = Score::where('score', '>', 15)->orderBy('score', 'desc')->get(['name', 'surname', 'email', 'score']);
        return response()->json($users);
    }
}
