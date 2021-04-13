<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Word Scrambler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    


    <style>

        body {
            background-color: #2ABDC1;
        }
        .padding-top-70 {
            padding-top:70px;
        }
        .user-info {
            display:block;
            text-align:right;
        }

        .user-info p, .user-info > a, .user-info > a:hover {
            font-weight:bold;
            color:#8C6AAE;
            font-size:16px;
            text-decoration:none;
            font-family: 'Poppins', sans-serif;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,900&display=swap');
    </style>
    @yield('style')
</head>

<body class="padding-top-70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(\Auth::check())
                    <div class="user-info">
                        <p> 
                            <i class="glyphicon glyphicon-user"></i> {{ \Auth::user()->name }}

                            <a href="javascript:void(0)" onclick="logout()">
                                <i class="glyphicon glyphicon-log-out"></i> Logout
                            </a>
                            
                        </p>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        function logout() {
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
        }
    </script>

    @yield('script')
</body>
</html>