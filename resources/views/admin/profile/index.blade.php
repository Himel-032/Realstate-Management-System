@extends('admin.layouts.master')
@section('main_content')

    @include('admin.layouts.nav')
    @include('admin.layouts.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Profile</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin_profile_submit') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if(Auth::guard('admin')->user()->photo == null)
                                                <img src="{{ asset('uploads/default.png') }}" alt=""
                                                    class="profile-photo w_100_p">
                                            @else

                                                <img src="{{ asset('uploads/' . Auth::guard('admin')->user()->photo) }}" alt=""
                                                    class="profile-photo w_100_p">
                                            @endif

                                            <input type="file" class="mt_10" name="photo">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-4">
                                                <label class="form-label">Name *</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ Auth::guard('admin')->user()->name }}">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Email *</label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ Auth::guard('admin')->user()->email }}">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Retype Password</label>
                                                <input type="password" class="form-control" name="confirm_password">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label"></label>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection




<!-- 
<form action="{{ route('admin_profile_submit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <table>
        <tr>
            <td>Existing Photo:</td>
            <td>
                @if(Auth::guard('admin')->user()->photo == null)
                    No Photo Found
                @else
                    <img src="{{ asset('uploads/' . Auth::guard('admin')->user()->photo) }}" alt=""
                        style="width: 100px; height: auto;">
                @endif
            </td>
        </tr>
        <tr>
            <td>Change Photo:</td>
            <td>
                <input type="file" name="photo">
            </td>
        </tr>
        <tr>
            <td>Name:</td>
            <td>
                <input type="text" name="name" value="{{ Auth::guard('admin')->user()->name }}">
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="email" value="{{ Auth::guard('admin')->user()->email }}">
            </td>
        </tr>

        <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="password" placeholder="Password">
            </td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td>
                <input type="password" name="confirm_password" placeholder="Confirm Password">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>

                <button type="submit">Update</button>

            </td>
        </tr>
    </table>
</form> -->