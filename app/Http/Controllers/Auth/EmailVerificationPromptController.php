<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        //     return $request->user()->hasVerifiedEmail()
        //                 ? redirect()->intended(RouteServiceProvider::HOME)
        //                 : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
        $roles = auth()->user()->roles->toArray();
        if (count($roles) == 1 && $roles[0]['name'] === "user") {
            $redirect = RouteServiceProvider::CLIENT_HOME;
        } else {
            $redirect = RouteServiceProvider::ADMIN_HOME;
        }
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended($redirect)
            : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
