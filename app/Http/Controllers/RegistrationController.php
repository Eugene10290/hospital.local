<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Calendar;
use App\Registration;

class RegistrationController extends Controller
{
    public function index() {
        $users = User::all();
        return view('registration.index', compact('users'));
    }

    public function registerTo(){
        return view('registration.register');
    }
    public function addRegistrationEvent(Request $request){
        $validator = Validator::make($request->all(), [
            'complaint' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back();
        }

        $registration = new Registration();
        $registration->complaint = $request['complaint'];
        $registration->start_date = $request['start_date'];
        $registration->end_date = $request['end_date'];
        $registration->save();

        return redirect('/doctors/list');
    }
}
