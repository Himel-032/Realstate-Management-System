@extends('admin.layouts.master')
@section('main_content')

    @include('admin.layouts.nav')
    @include('admin.layouts.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Page Content</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin_page_update') }}" method="post">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label>Terms Page Content *</label>
                                        @if($page != null)
                                        <textarea name="terms_content" id="" class="form-control editor" cols="30"
                                            rows="10">{{ $page->terms_content }}</textarea>
                                        @else
                                        <textarea name="terms_content" id="" class="form-control editor" cols="30"
                                            rows="10"></textarea>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Privacy Page Content *</label>
                                        @if($page != null)
                                        <textarea class="form-control editor" name="privacy_content" cols="30"
                                            rows="10">{{ $page->privacy_content }}</textarea>
                                        @else
                                        <textarea class="form-control editor" name="privacy_content" cols="30"
                                            rows="10"></textarea>
                                        @endif
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