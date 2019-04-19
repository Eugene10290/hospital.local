<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Registration;
use Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Возвращает все заказы пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        $orders = Auth::user()->orders->where('status','=', '1'); //отображение только оплаченных заказов
        $orders->transform(function ($order){
            $order->cart = unserialize($order->cart);

            return $order;
        });

        return view('user.profile', compact('orders'));
    }

    /**
     * Отобажение страниц регистраций врачей и пользователей
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registrations(){
        $user = Auth::user();
        if($user['is_doctor'] === 0){
            $registrations = $this->showUsersRegistration();

            foreach ($registrations as $registration){
                $doctors[] = User::where('id', '=', $registration->doctor_id)
                    ->get();
            }

            return view('registration.registrations_user',compact('registrations','doctors'));
        }else{
            $calendar = $this->showDoctorsRegistrations();

            return view('registration.registrations_doctor', compact('calendar'));
        }
    }
    /**
     * Выборка записей авторизированного пользователя к врачам
     *
     * @return mixed
     */
    private function showUsersRegistration(){
        $registrations = Registration::where('user_id', '=', Auth::user()->id)
            ->get()->reverse();

        return $registrations;
    }
    /**
     * Отображение календаря с записями для каждого отдельного врача
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showDoctorsRegistrations(){
        $registrations = Registration::where('doctor_id', '=', Auth::user()->id)
            ->get();
        $calendar = $this->showCalendar($registrations);

        return $calendar;
    }
    /**
     * Отображение календаря с записями
     *
     * @param $registrations
     * @return mixed
     */
    public function showCalendar($registrations){
        $events = [];
        $data = $registrations;
        if($data->count()) {
            foreach ($data as $key => $value) {
                $value->end_date < Carbon::now() ? $color = 'gray' : $color = 'green';
                $events[] = Calendar::event(
                    $value->title,
                    false,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.' +25 minutes'),
                    null,
                    [
                        'color' => $color,
                        'textColor' => 'white'
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);

        return $calendar;
    }

    public function profile(){
        return view('profile.index');
    }
    public function updateProfile(Request $request){
        $user = Auth::user();
        $user->doctors()->create($request->all());

        return redirect()->back();

    }
    /**
     * Формирование ссылки для загрузки нот
     *
     * @param $name
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadPdf($name) {
        $path = storage_path('app\notes/'.$name);

        return response()->download($path);
    }
}
