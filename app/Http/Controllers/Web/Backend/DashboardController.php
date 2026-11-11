<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_user = User::count();
        return view('backend.layouts.dashboard.dashboard',compact('total_user'));
    }
}
