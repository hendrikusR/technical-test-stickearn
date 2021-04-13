@extends('layouts')
@section('style')
    <style>
        h1 {
            font-weight:bold;
            color:#FFFFFF;
            text-align:center;
            font-family: 'Poppins', sans-serif;
        }

        .padding-top-70 {
            padding-top:70px;
        }

        .btn-custom {
            width: 50%;
            display:block;
            margin:auto;
            margin-top:5em;
            font-size:24px;
            font-weight:bold;
            text-decoration:none;
            color:#FFFFFF;
        }
    </style>
@endsection


@section('content')

<div class="container padding-top-70">
    <div class="row">
        <div class="col-md-12">
            <h1>WORD SCRAMBLER</h1>        
            <a href="{{ route('play') }}" class="btn btn-warning btn-custom">
                PLAY !!
            </a>
        </div>
    </div>
</div>
@endsection
