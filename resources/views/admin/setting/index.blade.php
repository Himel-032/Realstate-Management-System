@extends('admin.layouts.master')
@section('main_content')

    @include('admin.layouts.nav')
    @include('admin.layouts.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Settings</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin_setting_update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label>Existing Logo</label>
                                        <div><img src="{{ asset('uploads/' . $setting->logo) }}" alt="" class="w_200"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Logo</label>
                                        <div><input type="file" name="logo"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Existing favicon</label>
                                        <div><img src="{{ asset('uploads/' . $setting->favicon) }}" alt="" class="w_200"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change favicon</label>
                                        <div><input type="file" name="favicon"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Existing Banner</label>
                                        <div><img src="{{ asset('uploads/' . $setting->banner) }}" alt="" class="w_200"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Change Banner</label>
                                        <div><input type="file" name="banner"></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer Address *</label>
                                        <input type="text" class="form-control" name="footer_address" value="{{ $setting->footer_address }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer Email *</label>
                                        <input type="text" class="form-control" name="footer_email" value="{{ $setting->footer_email }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer Phone *</label>
                                        <input type="text" class="form-control" name="footer_phone" value="{{ $setting->footer_phone }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer Facebook *</label>
                                        <input type="text" class="form-control" name="footer_facebook" value="{{ $setting->footer_facebook }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer Twitter *</label>
                                        <input type="text" class="form-control" name="footer_twitter" value="{{ $setting->footer_twitter }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer Instagram *</label>
                                        <input type="text" class="form-control" name="footer_instagram" value="{{ $setting->footer_instagram }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer LinkedIn *</label>
                                        <input type="text" class="form-control" name="footer_linkedin" value="{{ $setting->footer_linkedin }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Footer Copyright *</label>
                                        <input type="text" class="form-control" name="footer_copyright" value="{{ $setting->footer_copyright }}">
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