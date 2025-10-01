@extends('front.layouts.master')

@section('main_content')

    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Blog</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="blog">
        <div class="container">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/' . $post->photo) }}" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                            </h2>
                            <div class="short-des">
                                {!! $post->short_description !!}
                            </div>
                            <div class="button">
                                <a href="{{ route('post', $post->slug) }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-12 d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>


@endsection