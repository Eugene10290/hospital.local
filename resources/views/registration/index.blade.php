@extends('layouts\app')
@section('header')
    <style>
        body{background:url(http://bootstraptema.ru/images/bg/bg-5.png)}

        .serviceBox{
            background: #fff;
            text-align: center;
            padding: 20px 0 40px;
            position: relative;
        }
        .serviceBox:hover{
            background:#98d7ce;
        }
        .serviceBox .service-icon{
            width: 100px;
            height: 100px;
            line-height: 95px;
            border-radius: 50%;
            /*border: 3px solid #b3b3b3;*/
            font-size: 50px;
            /*color: #b3b3b3;*/
            margin: 0 auto;
            transition: all 0.5s ease-in-out;
        }
        .serviceBox:hover .service-icon{
            transform: rotateY(360deg);
            color: #fff;
            /*border-color: #fff;*/
            background: #4acab4;
        }
        .serviceBox .service-content h3 a{
            font-size: 22px;
            color: #333;
        }
        .serviceBox .service-content p{
            font-size: 14px;
            padding: 0 20px;
            margin: 15px 0 30px;
            color:#333;
        }
        .serviceBox:hover h3 a,
        .serviceBox:hover p{
            color:#fff;
        }
        .serviceBox .btn{
            background: #4acab4;
            color: #fff;
            padding: 10px 35px;
            transition: all 0.6s ease-in-out;
            -webkit-transition: all 0.6s ease-in-out;
            -moz-transition: all 0.6s ease-in-out;
            -ms-transition: all 0.6s ease-in-out;
            -o-transition: all 0.6s ease-in-out;
        }
        .serviceBox:hover .btn{
            background: #333;
            color: #fff;
        }
        @media screen and (max-width: 990px){
            .serviceBox{
                margin-bottom: 20px;
                padding: 20px 0;
            }
        }
        .service-icon > img{
            width: 92px;
            height: 92px;

            border-radius: 50%;
        }
        h1{
            position: relative;
            margin: 0 auto;
            left: 40%;
            margin: 10px 10px;
        }
    </style>
@endsection
@section('content')


    <div class="container">
        <h1>Список лiкарiв</h1>
        <div class="row">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @foreach ($users as $key => $user)
                @if( ($user->is_doctor) === 1 )
                    <div class="col-md-4 col-sm-6">
                        <div class="serviceBox">
                            <div class="service-icon">
                                <img src="{{asset('public/images/uploads/avatars/'. $user->avatar)}}">
                            </div>
                            <div class="service-content">
                                <h3><a href="#">{{ $user->name }}</a></h3>
                                <p>{{ $user->doctors['description']  }}</p>
                            </div>
                            <div class="read">
                                <a href="{{ url('doctors/register-to/'.$user->slug) }}" class="btn btn-default">Запис</a>
                            </div>
                   </div>
                    </div>

                @endif
            @endforeach
        </div>
    </div><!-- ./row -->
    <!--</div>
@endsection
