<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\User;
use Calendar;
use App\Registration;
use Auth;
use DateTime;
use DatePeriod;
use DateInterval;

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
    public function index()
    {
        $users = User::all();

        return view('registration.index', compact('users'));
    }

    /**
     * Страница регистрации к врачу
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerTo(Request $request)
    {
        $user      = User::where('slug', '=', $request->slug)->get();
        $userName  = $user[0]->name;
        $calendar  = $this->getCalendar();
        $doctor_id = $user[0]->id;

        return view('registration.register', compact('userName', 'calendar', 'doctor_id', 'user'));
    }

    /**
     * Ajax функция для выбора даты и времени
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerTime(Request $request)
    {
        $selectedDate     = $request['date'];
        $url              = $request['url'];
        $parsedUrl        = parse_url($url);
        $explodeParsedUrl = explode('/', $parsedUrl['path']);
        $doctor           = User::where('slug', '=', $explodeParsedUrl[3])->get();
        $splittedTime     = $this->splitTime($doctor, $selectedDate);

        return response()->json(['success' => 'true', 'splittedTime' => $splittedTime]);
    }

    /**
     * Функция делит время на промежутки
     *
     * @param $doctor
     * @param $selectedDate
     *
     * @return array
     */
    private function splitTime($doctor, $selectedDate)
    {
        $startTime = strtotime(
            $selectedDate . ' ' . $doctor[0]['doctors']['start_time']
        );
        //Начало и конец смены врача
        $endTime       = strtotime($selectedDate . ' ' . $doctor[0]['doctors']['end_time']);
        $currentDocReg = Registration::where('doctor_id', $doctor[0]['id'])
            ->where('reg_day', $selectedDate)
            ->get();

        $interval = "25";
        $time     = $startTime;
        while ($time < $endTime) {
            $array[] = date('H:i', $time);
            $time    = strtotime('+' . $interval . ' minutes', $time);
        }//исключение забронированного времени для вывода

        foreach ($currentDocReg as $regTime) {
            $bookedTime = date('H:i', strtotime($regTime->start_date));

            if (($key = array_search($bookedTime, $array)) !== false) {
                unset($array[$key]);
            }
        }

        return $array;
    }

    /**
     * Инициализация календаря с событиями
     *
     * @return mixed
     * @throws \Exception
     */
    private function getCalendar()
    {
        $events = [];
        $data   = Registration::all();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    $value->title,
                    false,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date . ' +25 minutes'),
                    null,
                    [
                        'color' => '#f05050',
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);

        return $calendar;
    }

    /**
     * Регистрация записи к врачу
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addRegistrationEvent(Request $request)
    {
        $this->validateRegistrationDate($request);
        $insertedDateTime      = date(
            'Y-m-d H:i:s',
            strtotime($request['start_date'] . $request['booking-time'])
        );
        $user                  = Auth::user();
        $request['title']      = $user->name;
        $request['reg_day']    = $request['start_date'];
        $request['start_date'] = $insertedDateTime;
        $request['end_date']   = $insertedDateTime;
        $user->registrations()->create($request->all());

        return redirect('/doctors/list');
    }

    /**
     * Проверка на выбор старых дат
     *
     * @param $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function validateRegistrationDate($request)
    {
        $now          = Carbon::now()->format('Y-m-d');
        $selectedDate = Carbon::createFromFormat('Y-m-d', $request['start_date']);

        if ($selectedDate->diffInDays($now, false) < 0) { //если выбрана старая дата
            return redirect()->back();
        };
    }
}
