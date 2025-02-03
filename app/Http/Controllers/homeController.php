<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
        return view('home.index');
    }

    public function superuserDashboard() {
    return view('SuperUser.dashboard');
}

public function adminDashboard() {
    return view('Admin.dashboard');
}

public function userDashboard() {
    return view('User.dashboard');
}

}