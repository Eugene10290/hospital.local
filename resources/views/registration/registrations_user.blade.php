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
                        <tr>
                            <th scope="row">Врач 1</th>
                            <td>26.02.2018</td>
                            <td>15:40</td>
                            <td>Врач ожидает вас</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
@endsection
