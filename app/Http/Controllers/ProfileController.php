<?php

namespace App\Http\Controllers;

use Auth;
use User;
use App\Registration;
use Calendar;

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
            return view('registration.registrations_user',compact('user'));
        }else{
            $calendar = $this->showRegistrations();

            return view('registration.registrations_doctor', compact('calendar'));
        }
    }
    /**
     * Отображение календаря с записями для каждого отдельного врача
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function showRegistrations(){

        $registrations = Registration::where('doctor_id','=',Auth::user()->id)->get();
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

        return $calendar;
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
