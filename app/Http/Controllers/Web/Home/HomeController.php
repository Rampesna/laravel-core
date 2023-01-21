<?php

namespace App\Http\Controllers\Web\Home;

use App\Core\Controller;
use App\Core\HttpResponse;

class HomeController extends Controller
{
    use HttpResponse;

    public function index()
    {
        if (auth()->guard('user_web')->check()) {
            return redirect()->route('user.web.dashboard.index');
        }

        return view('home.modules.index.index');
    }

}
