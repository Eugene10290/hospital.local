@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <h1> Електронна картка пацiента </h1>
            <table class="table table-hover" style="margin-top: 50px">
                <thead>
                <tr>
                    <th scope="col">Лікар</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Скарга</th>
                    <th scope="col">Дія</th>
                </tr>
                </thead>
                <tbody>
                    @if($cards)
                        @foreach($cards as $visit)
                            <tr>

                                <th scope="row">{{$visit->doctor->name}}</th>
                                <td>{{ $visit->created_at }}</td>
                                <td>{{ $visit->complaint }}</td>

                                <td>
                                    <button type="button" class="btn btn-danger">Переглянути</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
