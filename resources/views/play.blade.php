@extends('layouts')
@section('style')
    <style>
        h1 {
            font-weight:bold;
            color:#F7DE54;
            text-align:center;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 40px;
        }

        .padding-top-70 {
            padding-top:70px;
        }

        .question {
            font-weight:bold;
            text-align:center;
            color:#FFFFFF;
            font-size:34px;
            font-family: 'Poppins', sans-serif;
            margin-bottom:1em;
        }

        form {
            width: 50%;
            margin: 8em auto;
            text-align: center;
        }
        label {
            display: block;
            position: relative;
            margin: 40px 0px;
        }
        .label-txt {
            position: absolute;
            top: -1.6em;
            padding: 10px;
            font-family: sans-serif;
            font-size: .8em;
            letter-spacing: 1px;
            color: rgb(120,120,120);
            transition: ease .3s;
        }
        .input {
            width: 100%;
            padding: 10px;
            background: transparent;
            border: none;
            outline: none;
            color:#F7DE54;
            font-weight:bold;
            font-size:34px;
            text-transform: uppercase;
            font-family: 'Roboto', sans-serif;
            text-align:center;
            letter-spacing: 40px;
        }

        .line-box {
            position: relative;
            width: 100%;
            height: 2px;
            background: #BCBCBC;
        }

        .line {
            position: absolute;
            width: 0%;
            height: 2px;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
            background: #F7DE54;
            transition: ease .6s;
        }

        .input:focus + .line-box .line {
            width: 100%;
        }

        .label-active {
            top: -3em;
        }

        .btn-ultra-voilet{
            background: #654ea3;
            background: -webkit-linear-gradient(to right, #eaafc8, #654ea3);
            background: linear-gradient(to right, #eaafc8, #654ea3);
            color: #223750;
            border: 3px solid #eee;
            font-family: 'Poppins', sans-serif;
            font-size:24px;
        }

        .user-info {
            display:block;
            text-align:right;
        }

        .user-info p, a, a:hover {
            font-weight:bold;
            color:#8C6AAE;
            font-size:16px;
            text-decoration:none;
            font-family: 'Poppins', sans-serif;
        }

        .score p {
            color:#8C6AAE;
            font-weight:bold;
            font-family: 'Poppins', sans-serif;
            font-size:24px;
            text-align:center;
        }
    </style>
@endsection


@section('content')
<div class="container padding-top-70">
    <div class="row">
        <div class="col-md-12">
            @if(\Auth::check())
                <div class="user-info">
                    <p> 
                        <i class="glyphicon glyphicon-user"></i> {{ \Auth::user()->name }}

                        <a href="javascript:void(0)" onclick="play.logout()">
                            <i class="glyphicon glyphicon-log-out"></i> Logout
                        </a>
                        
                    </p>
                </div>
            @endif


            <div class="score">
                <p>
                    {{ $score }}
                    <i class="glyphicon glyphicon-tree-conifer"></i>
                </p>
                
            </div>
            
            <p class="question">Question number {{ $page }}</p>
            <h1>{{ $question }}</h1>
            <form id="myform" method="post">
                <label>
                    <input type="text" class="input" name="answer">
                    <input type="hidden" class="input" name="page" value="{{ $page }}">
                    <input type="hidden" class="input" name="question" value="{{ $question }}">
                    <div class="line-box">
                        <div class="line"></div>
                    </div>
                </label>
                <button class="btn btn-ultra-voilet btn-block">Answer !!</button>
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')

<script>

    let play = {
        init: function() {
            play.answer();
        },
        answer: function() {
            $("#myform").submit(function(event){

                event.preventDefault();

                let answer = $('input[name="answer"]').val();

                if(answer != "undefined" && answer != "") {
                    play.submitAnswer();
                } else {
                    swal("Answer Cannot Be Empty", "", "error");
                }
            });
        },
        logout: function() {
            $.ajax({
                type:"POST",
                url: "{{ url('logout') }}" ,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(){
                    window.location.href = "/";
                },
                error: function(){
                    swal("Logout Failed", "", "error");
                    window.location.href = "/login";
                }
            })
        },
        submitAnswer: function() {
            $.ajax({
                type:"POST",
                url: "{{ url('answer') }}" ,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#myform').serialize(),
                success: function(data){
                    let response = JSON.parse(data)

                    if(response.answer == false) {
                        swal("Wrong Answer", "", "error");
                    } else {
                        swal({title: "Cooollllll", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                    }
                },
                error: function(){
                    // swal("Logout Failed", "", "error");
                    // window.location.href = "/login";
                }
            })
        }
    }
    $(document).ready(function() {
        play.init();
    });
</script>

@endsection