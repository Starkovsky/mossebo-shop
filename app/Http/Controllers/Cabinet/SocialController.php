<?php

namespace App\Http\Controllers\Cabinet;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        return response()->json([
            'socials' => $this->getExistingProviders($user = Auth::user())
        ], 200);
    }

    public function detach(Request $request)
    {
        $provider = $request->input('provider');

        $user = Auth::user();

        $user->socialProviders()->where('provider', $provider)->delete();

        return response()->json([
            'socials' => $this->getExistingProviders($user)
        ], 200);
    }

    protected function getExistingProviders($user)
    {
        return array_column($user->socialProviders()->get()->toArray(), 'provider');
    }
}
