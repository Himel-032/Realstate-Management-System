@extends('front.layouts.master')

@section('main_content')

    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Agent: {{ $agent->name }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="agent-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner">
                        <div class="photo">
                            <img src="{{ asset('uploads/' . $agent->photo) }}" alt="">
                        </div>
                        <div class="detail">
                            <h3>{{ $agent->name }} ({{ $agent->company }})</h3>
                            <h4>{{ $agent->designation }}</h4>
                            @if($agent->biography != '' && $agent->biography != null)
                            {!! $agent->biography !!}
                            @endif
                            <div class="contact d-flex justify-content-center">
                                @if($agent->address != '' && $agent->city != '' && $agent->city != '' && $agent->state != '' && $agent->country != '' && $agent->zip != '')
                                <div class="item"><i class="fas fa-map-marker-alt"></i> {{ $agent->address }}, {{ $agent->city }}, {{ $agent->state }}, {{ $agent->country }}, {{ $agent->zip }}</div>
                                @endif
                                @if($agent->phone != '' && $agent->phone != null && $agent->phone != '#')
                                <div class="item"><i class="fas fa-phone"></i> {{ $agent->phone }}</div>
                                @endif

                                <div class="item"><i class="far fa-envelope"></i> {{ $agent->email }}</div>

                                @if($agent->website != '' && $agent->website != '#' && $agent->website != null)
                                <div class="item"><i class="fas fa-globe"></i> {{ $agent->website }}</div>
                                @endif
                            </div>
                            <ul class="agent-detail-ul">
                                @if($agent->facebook != '' && $agent->facebook != '#' && $agent->facebook != null)
                                <li><a href="{{ $agent->facebook }}"><i class="fab fa-facebook-f"></i> </a></li>
                                @endif
                                @if($agent->twitter != '' && $agent->twitter != '#' && $agent->twitter != null)
                                <li><a href="{{ $agent->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                @endif
                                @if($agent->instagram != '' && $agent->instagram != '#' && $agent->instagram != null)
                                <li><a href="{{ $agent->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                @endif
                                @if($agent->linkedin != '' && $agent->linkedin != '#' && $agent->linkedin != null)
                                <li><a href="{{ $agent->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="property">
        <div class="container">
            <div class="row">
                @if($properties->count() == 0)
                <div class="alert alert-danger mt_30 mb_30">
                    No property found for this Agent.
                </div>
                @else
                    @foreach($properties as $property)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="item">
                                <div class="photo">
                                    <img class="main" src="{{ asset('uploads/' . $property->featured_photo) }}" alt="">
                                    <div class="top">
                                        @if($property->purpose == 'Sale')
                                            <div class="status-sale">
                                                For Sale
                                            </div>
                                        @elseif($property->purpose == 'Rent')
                                            <div class="status-rent">
                                                For Rent
                                            </div>
                                        @endif
                                        @if($property->is_featured == 'Yes')
                                            <div class="featured">
                                                Featured
                                            </div>
                                        @endif
                                    </div>
                                    <div class="price">${{ $property->price }}</div>
                                    <div class="wishlist"><a href=""><i class="far fa-heart"></i></a></div>
                                </div>
                                <div class="text">
                                    <h3><a href="{{ route('property_detail', $property->slug) }}">{{ $property->name }}</a></h3>
                                    <div class="detail">
                                        <div class="stat">
                                            <div class="i1">{{ $property->size }} sqft</div>
                                            <div class="i2">{{ $property->bedroom }} Bed</div>
                                            <div class="i3">{{ $property->bathroom }} Bath</div>
                                        </div>
                                        <div class="address">
                                            <i class="fas fa-map-marker-alt"></i> {{ $property->address }}
                                        </div>
                                        <div class="type-location">
                                            <div class="i1">
                                                <i class="fas fa-edit"></i> {{ $property->type->name }}
                                            </div>
                                            <div class="i2">
                                                <i class="fas fa-location-arrow"></i> {{ $property->location->name }}
                                            </div>
                                        </div>
                                        <div class="agent-section">
                                            <img class="agent-photo" src="{{ asset('uploads/' . $property->agent->photo) }}" alt="">
                                            <a href="{{ route('agent', $property->agent->id) }}">{{ $property->agent->name }}
                                                ({{ $property->agent->company }})</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12 d-flex justify-content-center">
                        {{ $properties->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection