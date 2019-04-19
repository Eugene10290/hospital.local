@extends('layouts.app')
@section('header')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection
@section('content')
    <h1>{{ $userName }}(Выберите дату посещения этого врача)</h1>
    <h3>Время работы: {{ $user[0]->doctors['start_time'] }} - {{ $user[0]->doctors['end_time'] }}</h3>
    {{ Form::open(['route' => 'register-to.add', 'method' => 'POST', 'files' => 'true']) }}
    {{ csrf_field() }}
    <div class="form-group">
        {{ Form::label('Введите дату записи') }}
        {{ Form::date('start_date', null, ['class' => 'form-control start_date', 'id' => 'start_date', 'min' => \Carbon\Carbon::now()->format('Y-m-d'), 'max' => \Carbon\Carbon::now()->addDays(21)->format('Y-m-d')]) }}
    </div>
    {{ Form::hidden('doctor_id', $doctor_id) }}
    <div class="form-group">
        {{ Form::select('booking-time' ) }}
    </div>
    <div class="form-group">
        {!! Form::submit('Записаться', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {{ Form::close() }}
    <div class="panel-body">
        {!! $calendar->calendar() !!}
        {!! $calendar->script() !!}
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#start_date').on('change', function(e){
               e.preventDefault();
               var date = $(this).val();
               $.ajax({
                   type: 'POST',
                   url: '{{ route('register-time') }}',
                   dataType: "json",
                   data: {
                       "_token": "{{ csrf_token() }}",
                       date: date,
                       url: window.location.href,
                   },
                   success: function (data) {
                       $('#booking-time').html('');
                       var myHtml = "";
                       $.each(data.splittedTime, function (key, value) {
                           myHtml += "<option>" + value + "</option>";
                           $('select[name=booking-time]').html(myHtml);
                       });
                   },
               })
            });
        });
    </script>
@endsection
