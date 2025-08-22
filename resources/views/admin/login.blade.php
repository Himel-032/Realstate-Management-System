@extends('admin.layouts.master')

@section('main_content')



<section class="section">
            <div class="container container-login">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary border-box">
                            <div class="card-header card-header-auth">
                                <h4 class="text-center">Admin Panel Login</h4>
                            </div>
                            <div class="card-body card-body-auth">
                                <form method="post" action="{{ route('admin_login_submit') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email Address" value="" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password"  placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg w_100_p">
                                            Login
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <a href="{{ route('admin_forget_password') }}">
                                                Forget Password?
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
{{-- <h2>Admin Login</h2>
@if($errors->any())
    @foreach($errors->all() as $error)
        {{ $error }}
    @endforeach
@endif

@if(session('success'))
        {{ session('success') }}
@endif

@if(session('error'))
        {{ session('error') }}
@endif

<form action="{{ route('admin_login_submit') }}" method="post">
    @csrf
    <table>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="email" placeholder="Email" >
            </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="password" placeholder="Password">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit">Login</button>
                <div>
                    <a href="{{ route('admin_forget_password') }}">Forget Password</a>
                </div>
            </td>
        </tr>
    </table>
</form> --}}
@endsection