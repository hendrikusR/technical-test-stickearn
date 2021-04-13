@extends('layouts')


@section('style')
<style>
    
    #login-column {
        display:block;
        margin:auto;
        width:50%;
    }

    #login #login-row #login-box {
        margin-top: 120px;
        height: 320px;
        border: 1px solid #9C9C9C;
        background-color: #EAEAEA;
    }
    #login #login-row #login-box #login-form {
        padding: 20px;
    }
    #login #login-row #login-box #login-form #register-link {
        margin-top: -85px;
    }
</style>

@endsection
@section('content')
    <div class="container">
        <div id="login">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column">
                    <div id="login-box">    
                        <form id="login-form" class="form" action="{{ route('login-submit') }}" method="post">
                            @csrf
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @error('email')
        <script>
            swal("{{ $message }}", "", "error");
        </script>
    @enderror

@endsection