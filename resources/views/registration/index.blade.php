@extends('layouts\app')
@section('content')
    <h1>Список лiкарiв</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Типа врачи</div>

                    <div class="panel-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Почта</th>
                                <th>Должность</th>
                                <th>Действие</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key => $user)
                                @if($user->hasRole('Врач'))
                                    <tr class="list-users">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if(!empty($user->roles))
                                                @foreach($user->roles as $role)
                                                    <label class="label label-success">{{ $role->display_name }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="#">Запись</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection