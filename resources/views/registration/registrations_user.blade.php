@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
                <table class="table table-hover" style="margin-top: 50px">
                    <thead>
                        <tr>
                            <th scope="col">Лікар</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Час</th>
                            <th scope="col">Статус</th>
							<th scope="col">Дія</th>
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
                                        <td>Візит заплановано</td>
                                    @else
                                        <td>Візит відбувся</td>
                                    @endif
									<td> 
										<button type="button" class="btn btn-danger">Відміна</button>
									</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
