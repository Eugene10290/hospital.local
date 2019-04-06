@extends('layouts.app')

@section('content')
<h1>Редактирование профиля</h1>
    @if(Auth::user()['is_doctor'] === 1)
        <h2>Редактирование информации врача</h2>
        {!! Form::open(['route' => 'profile.update', 'method' => 'post']) !!}
            {!! Form::token() !!}
            <div class="form-group">
                {!! Form::label('start_time','От') !!}
                {!! Form::time('start_time',null,  ['class' => 'form-control']) !!}
                {!! Form::label('end_time','До') !!}
                {!! Form::time('end_time', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('position', 'Должность') !!}
                {!! Form::text('position', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Информация') !!}
                {!! Form::textarea('description',null, ['class' => 'form-control']) !!}
            </div>
            {!! Form::submit('Обновить', ['class' => 'btn btn-primary form-control']) !!}
        {!! Form::close() !!}
    @endif
@endsection