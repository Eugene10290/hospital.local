@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
                <table class="table table-hover" style="margin-top: 50px">
                    <thead>
                        <tr>
                            <th scope="col">Врач</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Время</th>
                            <th scope="col">Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                            @foreach($doctors as $doctor)
                                <tr>
                                    <th scope="row">{{$doctor[0]->name}}</th>
                                    <td>{{ $registration->start_date }}</td>
                                    <td>15:40</td>
                                    <td>Врач ожидает вас</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
