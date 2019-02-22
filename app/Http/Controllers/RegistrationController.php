<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Calendar;
use App\Registration;
use Auth;
class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
    /**
     * Вывод страницы со списком врачей
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $users = User::all();
        return view('registration.index', compact('users'));
    }
    /**
     * Страница регистрации к врачу
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerTo(Request $request){
        $user = User::where('slug','=', $request->slug)->get();
        $userName = $user[0]->name;
        $events = [];
        $data = Registration::all();
        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    $value->title,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        //'url' => '/register-to/'. $user[0]->slug,
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        $doctor_id = $user[0]->id;
        return view('registration.register', compact('userName', 'calendar','doctor_id'));
    }
    /**
     * Регистрация записи к врачу
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addRegistrationEvent(Request $request){
        $user = Auth::user();
        $request['title'] = $user->name;
        $request['end_date'] = $request['start_date'];
        $user->registrations()->create($request->all());

        return redirect('/doctors/list');
    }
}
