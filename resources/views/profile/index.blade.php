@extends('layouts.app')
@section('header')
    <link href="{{ asset('public/css/profile/profile.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
    <div class="container wrapper">
        <h1>Редагування профілю</h1>

        <div class="avatar" >
            <img src="{{ asset('public/images/uploads/avatars/' .  Auth::user()->avatar ) }}" style="width: 150px; height: 150px; border-radius: 50%;">
        </div>
        {!! Form::open(['route' => 'profile.update', 'method' => 'post', 'files' => true]) !!}
        {!! Form::token() !!}
        {!! Form::file('avatar')!!}
        <div class="form">
            @if(Auth::user()['is_doctor'] === 0)
                <div class="form-group">
                    {!! Form::label('address', 'Адреса') !!}
                    {!! Form::text('address',null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('card_number', 'Номер картки') !!}
                    {!! Form::text('card_number',null, ['class' => 'form-control']) !!}
                </div>
            @endif
            @if(Auth::user()['is_doctor'] === 1)
                <br><br><br><br><h2>Редагування інформації лікаря</h2>
                <div class="form-group>
                    {!! Form::label('start_time','От') !!}
                    {{ Form::time('start_time', isset($doctor->start_time) ? (date('H:i', strtotime($doctor->start_time))) : null,  ['class' => 'form-control']) }}
                    {!! Form::label('end_time','До') !!}
                    {{ Form::time('end_time', isset($doctor->end_time) ? (date('H:i', strtotime($doctor->end_time))) : null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {!! Form::label('position','Посада') !!}
                    {!! Form::text('position', isset($doctor->position) ? $doctor->position : null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Інформація') !!}
                    {!! Form::textarea('description',isset($doctor->description) ? $doctor->description : null, ['class' => 'form-control']) !!}
                </div>
            @endif
        </div>


        {!! Form::submit('Оновити', ['class' => 'btn btn-primary form-control']) !!}
        {!! Form::close() !!}
    </div>
@endsection
