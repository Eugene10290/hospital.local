@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <h1> Електронна картка пацiента </h1>
            <table class="table table-hover" style="margin-top: 50px">
                <thead>
                <tr>
                    <th scope="col">Лікар</th>
                    <th scope="col">Пациент</th>
                    <th scope="col">Час</th>
                    <th scope="col">Дія</th>
                </tr>
                </thead>
                <tbody>
                @if($registrations)
                    @foreach($registrations as $reg)
                        <tr>
                            <th scope="row">{{ $reg->id }}</th>
                            <td> {{ $reg->patient->name }}</td>
                            <td> {{ $reg->start_date }}</td>
                            {{ dd($reg) }}
                            <td>
                                <button type="button" class="btn btn-danger">Створити запис</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    {{ $registrations->render() }}
@endsection
