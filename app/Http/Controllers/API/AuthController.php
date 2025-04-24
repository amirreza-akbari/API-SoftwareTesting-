<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Score;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json(['status' => 'success', 'message' => 'اطلاعات با موفقیت ذخیره شد.']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'ایمیل یافت نشد']);
        }

        if ($user->password !== $request->password) {
            return response()->json(['status' => 'error', 'message' => 'رمز عبور اشتباه است']);
        }

        $score = Score::where('email', $user->email)->first();

        if (!$score) {
            return response()->json(['status' => 'error', 'message' => 'نمره یافت نشد']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'ورود موفق',
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'score' => $score->score
        ]);
    }
}
