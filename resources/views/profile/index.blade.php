@extends('layouts.app')

@section('content')
<h1>Редактирование профиля</h1>
<img src="{{ asset('images/uploads/avatars/' .  Auth::user()->avatar ) }}" style="width: 150px; height: 150px; float: left; border-radius: 50%">
{!! Form::open(['route' => 'profile.update', 'method' => 'post', 'files' => true]) !!}
{!! Form::token() !!}
{!! Form::file('avatar')!!}
    @if(Auth::user()['is_doctor'] === 1)
        <br><br><br><br><h2>Редактирование информации врача</h2>
            <div class="form-group">
                {!! Form::label('start_time','От') !!}
                {!! Form::time('start_time',date('H:i',strtotime($doctor->start_time)),  ['class' => 'form-control']) !!}
                {!! Form::label('end_time','До') !!}
                {!! Form::time('end_time', date('H:i',strtotime($doctor->end_time)), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('position', 'Должность') !!}
                {!! Form::text('position', $doctor->position, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Информация') !!}
                {!! Form::textarea('description',$doctor->description, ['class' => 'form-control']) !!}
            </div>

    @endif
{!! Form::submit('Обновить', ['class' => 'btn btn-primary form-control']) !!}
{!! Form::close() !!}
@endsection