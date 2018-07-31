<?php

namespace App\Http\Controllers\Cabinet;


use Auth;
use Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ProfileController extends Controller
{
    use ResetsPasswords;

    public function index()
    {
        $user = Auth::user();

        return response()->json([
            'status' =>'success',
            'profile' => new ProfileResource($user)
        ]);
    }

    public function save(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->update(
            $request->only(['first_name', 'last_name', 'phone', 'email', 'password', 'address', 'city', 'post_code'])
        );

        Auth::setUser($user);

        // todo: перевести
        return response()->json([
            'status' => 'success',
            'message' => 'Изменения сохранены'
        ]);
    }

    public function password(PasswordRequest $request)
    {
        $this->resetPassword(Auth::user(), $request->input('password_new'));

        // todo: перевести
        return response()->json([
            'status' => 'success',
            'message' => 'Изменения сохранены'
        ]);
    }
}
