<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('user.modules.settings.index.index');
    }

    public function userRole()
    {
        return view('user.modules.settings.userRole.index.index');
    }
}
