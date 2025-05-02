<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SessionController extends Controller
{
    public function createSession(Request $request): Response
    {
        // session()->put()
        // \Illuminate\Support\Facades\Session::put()
        $request->session()->put('userId', 'john');
        $request->session()->put('isMember', 'true');

        return response("OK");
    }

    public function getSession(Request $request): string
    {
        $userId = $request->session()->get('userId', 'guest');
        $isMember = $request->session()->get('isMember', 'false');

        return "User Id : $userId, Is Member : $isMember";
    }
}
