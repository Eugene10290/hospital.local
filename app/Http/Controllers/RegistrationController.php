<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegistrationController extends Controller
{
    public function index() {
        $users = User::all();
        return view('registration.index', compact('users'));
    }
}
