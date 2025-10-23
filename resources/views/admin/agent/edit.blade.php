@extends('admin.layouts.master')
@section('main_content')

    @include('admin.layouts.nav')
    @include('admin.layouts.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Agent</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin_agent_index') }}" class="btn btn-primary"><i class="fas fa-eye"></i>View
                        All</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin_agent_update', $agent->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Existing Photo</label>
                                <div class="form-group">
                                    @if($agent->photo == null)
                                        <img src="{{ asset('uploads/default.png') }}" alt="" class="user-photo w_100">
                                    @else
                                        <img src="{{ asset('uploads/' . $agent->photo) }}" alt=""
                                            class="user-photo w_100">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Change Photo</label>
                                <div class="form-group">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Name *</label>
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $agent->name }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email *</label>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control"
                                        value="{{ $agent->email }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Company *</label>
                                <div class="form-group">
                                    <input type="text" name="company" class="form-control" value="{{ $agent->company }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Designation *</label>
                                <div class="form-group">
                                    <input type="text" name="designation" class="form-control" value="{{ $agent->designation }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone</label>
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" value="{{ $agent->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Address</label>
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" value="{{ $agent->address }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Country</label>
                                <div class="form-group">
                                    <input type="text" name="country" class="form-control" value="{{ $agent->country }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">State</label>
                                <div class="form-group">
                                    <input type="text" name="state" class="form-control" value="{{ $agent->state }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">City</label>
                                <div class="form-group">
                                    <input type="text" name="city" class="form-control" value="{{ $agent->city }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Zip</label>
                                <div class="form-group">
                                    <input type="text" name="zip" class="form-control" value="{{ $agent->zip }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Facebook</label>
                                <div class="form-group">
                                    <input type="text" name="facebook" class="form-control" value="{{ $agent->facebook }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Twitter</label>
                                <div class="form-group">
                                    <input type="text" name="twitter" class="form-control" value="{{ $agent->twitter }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Linkedin</label>
                                <div class="form-group">
                                    <input type="text" name="linkedin" class="form-control" value="{{ $agent->linkedin }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Instagram</label>
                                <div class="form-group">
                                    <input type="text" name="instagram" class="form-control" value="{{ $agent->instagram }}">
                                </div>
                            </div><div class="col-md-12 mb-3">
                                <label for="">Website</label>
                                <div class="form-group">
                                    <input type="text" name="website" class="form-control" value="{{ $agent->website }}">
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Password</label>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Confirm Password</label>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Biography</label>
                                <div class="form-group">
                                    <textarea name="biography" class="form-control h-200" rows="10" cols="30">{{ $agent->biography }}</textarea>
                                </div>
                            </div>
                                    <div class="form-group mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-select">
                                            <option value="0" {{ $agent->status == 0 ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ $agent->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="2" {{ $agent->status == 2 ? 'selected' : '' }}>Suspended
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
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