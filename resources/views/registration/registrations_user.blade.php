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
                    @foreach($doctors as $doctor)
                        @foreach($registrations as $registration)
                                <?php
                                    $date = explode(' ', $registration->start_date);
                                    $now = \Carbon\Carbon::now();
                                    $registrationDate = \Carbon\Carbon::parse($registration->start_date)->format('Y-m-d H:i:s');
                                ?>
                                <tr>
                                    <th scope="row">{{$doctor[0]->name}}</th>
                                    <td>{{ $date[0] }}</td>
                                    <td>{{ $date[1] }}</td>
                                    @if($registrationDate > $now)
                                        <td>Визит запланирован</td>
                                    @else
                                        <td>Визит состоялся</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
