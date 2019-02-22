@extends('layouts.app')
@section('header')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection
@section('content')
    <h1>{{ $userName }}(Выберите дату посещения этого врача)</h1>
    {{ Form::open(['route' => 'register-to.add', 'method' => 'POST', 'files' => 'true']) }}
    <div class="form-group">
        {{ Form::label('Введите дату записи') }}
        {{ Form::date('start_date', null, ['class' => 'form-control']) }}
    </div>

    {{ Form::hidden('doctor_id', $doctor_id) }}
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

@endsection
