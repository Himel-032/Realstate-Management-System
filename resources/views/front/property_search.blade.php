@extends('front.layouts.master')

@section('main_content')

    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Property Listing</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="property-result">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <form action="{{ route('property_search') }}" method="get">
                    <div class="property-filter">
                        <div class="widget">
                            <h2>Find Anything</h2>
                            <input type="text" name="name" class="form-control" placeholder="Search By Name..." value="{{ $form_name }}" />
                        </div>

                        <div class="widget">
                            <h2>Location</h2>
                            <select name="location" class="form-control select2" onchange="this.form.submit()">
                                <option value=""> Select Location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" @if($form_location == $location->id) selected @endif >{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Type</h2>
                            <select name="type" class="form-control select2" onchange="this.form.submit()">
                                <option value=""> Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" @if($form_type == $type->id) selected @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Purpose</h2>
                            <select name="purpose" class="form-control select2"  onchange="this.form.submit()">
                                <option value=""> Select Purpose</option>
                                <option value="Rent" @if($form_purpose == 'Rent') selected @endif>For Rent</option>
                                <option value="Sale" @if($form_purpose == 'Sale') selected @endif>For Sale</option>
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Amenities</h2>
                            <select name="amenity" class="form-control select2" onchange="this.form.submit()">
                                <option value="">Select Amenity</option>
                                @foreach($amenities as $amenity)
                                    <option value="{{ $amenity->id }}" @if($form_amenity == $amenity->id) selected @endif>{{ $amenity->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Bedrooms</h2>
                            <select name="bedroom" class="form-control select2" onchange="this.form.submit()">
                                <option value="">Select Bedrooms</option>
                                @for($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}" @if($form_bedroom == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Bathrooms</h2>
                            <select name="bathroom" class="form-control select2" onchange="this.form.submit()">
                                <option value="">Select Bathroom</option>
                                @for($i = 1; $i <= 50; $i++)
                                    <option value="{{ $i }}" @if($form_bathroom == $i) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Min Price</h2>
                            <select name="min_price" class="form-control select2" onchange="this.form.submit()">
                                <option value="">Select Minimum Price</option>
                                <option value="1000" {{ $form_min_price == 1000 ? 'selected' : '' }}>1000</option>
                                <option value="2000" {{ $form_min_price == 2000 ? 'selected' : '' }}>2000</option>
                                <option value="3000" {{ $form_min_price == 3000 ? 'selected' : '' }}>3000</option>
                                <option value="5000" {{ $form_min_price == 5000 ? 'selected' : '' }}>5000</option>
                                <option value="10000" {{ $form_min_price == 10000 ? 'selected' : '' }}>10000</option>
                                <option value="20000" {{ $form_min_price == 20000 ? 'selected' : '' }}>20000</option>
                                <option value="30000" {{ $form_min_price == 30000 ? 'selected' : '' }}>30000</option>
                                <option value="50000" {{ $form_min_price == 50000 ? 'selected' : '' }}>50000</option>
                                <option value="60000" {{ $form_min_price == 60000 ? 'selected' : '' }}>60000</option>
                                <option value="70000" {{ $form_min_price == 70000 ? 'selected' : '' }}>70000</option>
                                <option value="80000" {{ $form_min_price == 80000 ? 'selected' : '' }}>80000</option>
                                <option value="90000" {{ $form_min_price == 90000 ? 'selected' : '' }}>90000</option>
                                <option value="100000" {{ $form_min_price == 100000 ? 'selected' : '' }}>100000</option>
                                <option value="200000" {{ $form_min_price == 200000 ? 'selected' : '' }}>200000</option>
                                <option value="300000" {{ $form_min_price == 300000 ? 'selected' : '' }}>300000</option>
                                <option value="400000" {{ $form_min_price == 400000 ? 'selected' : '' }}>400000</option>
                                <option value="500000" {{ $form_min_price == 500000 ? 'selected' : '' }}>500000</option>
                                <option value="600000" {{ $form_min_price == 600000 ? 'selected' : '' }}>600000</option>
                                <option value="700000" {{ $form_min_price == 700000 ? 'selected' : '' }}>700000</option>
                                <option value="800000" {{ $form_min_price == 800000 ? 'selected' : '' }}>800000</option>
                                <option value="900000" {{ $form_min_price == 900000 ? 'selected' : '' }}>900000</option>
                                <option value="1000000" {{ $form_min_price == 1000000 ? 'selected' : '' }}>1000000</option>
                                <option value="2000000" {{ $form_min_price == 2000000 ? 'selected' : '' }}>2000000</option>
                                <option value="3000000" {{ $form_min_price == 3000000 ? 'selected' : '' }}>3000000</option>

                            </select>

                        </div>

                        <div class="widget">
                            <h2>Max Price</h2>
                            <select name="max_price" class="form-control select2" onchange="this.form.submit()">
                                <option value="">Select Maximum Price</option>
                                <option value="1000" @if($form_max_price == 1000) selected @endif>1000</option>
                                <option value="2000" @if($form_max_price == 2000) selected @endif>2000</option>
                                <option value="3000" @if($form_max_price == 3000) selected @endif>3000</option>
                                <option value="5000" @if($form_max_price == 5000) selected @endif>5000</option>
                                <option value="10000" @if($form_max_price == 10000) selected @endif>10000</option>
                                <option value="20000" @if($form_max_price == 20000) selected @endif>20000</option>
                                <option value="30000" @if($form_max_price == 30000) selected @endif>30000</option>
                                <option value="50000" @if($form_max_price == 50000) selected @endif>50000</option>
                                <option value="60000" @if($form_max_price == 60000) selected @endif>60000</option>
                                <option value="70000" @if($form_max_price == 70000) selected @endif>70000</option>
                                <option value="80000" @if($form_max_price == 80000) selected @endif>80000</option>
                                <option value="90000" @if($form_max_price == 90000) selected @endif>90000</option>
                                <option value="100000" @if($form_max_price == 100000) selected @endif>100000</option>
                                <option value="200000" @if($form_max_price == 200000) selected @endif>200000</option>
                                <option value="300000" @if($form_max_price == 300000) selected @endif>300000</option>
                                <option value="400000" @if($form_max_price == 400000) selected @endif>400000</option>
                                <option value="500000" @if($form_max_price == 500000) selected @endif>500000</option>
                                <option value="600000" @if($form_max_price == 600000) selected @endif>600000</option>
                                <option value="700000" @if($form_max_price == 700000) selected @endif>700000</option>
                                <option value="800000" @if($form_max_price == 800000) selected @endif>800000</option>
                                <option value="900000" @if($form_max_price == 900000) selected @endif>900000</option>
                                <option value="1000000" @if($form_max_price == 1000000) selected @endif>1000000</option>
                                <option value="2000000" @if($form_max_price == 2000000) selected @endif>2000000</option>
                                <option value="3000000" @if($form_max_price == 3000000) selected @endif>3000000</option>
                            </select>
                        </div>

                        <div class="filter-button">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="property">
                        <div class="container">
                            <div class="row">
                                @if(count($properties) == 0)
                                    <div class="alert alert-danger">No Property Found.</div>
                                @else
                                @foreach($properties as $item)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="item">
                                        <div class="photo">
                                            <img class="main" src="{{ asset('uploads/' . $item->featured_photo) }}" alt="">
                                            <div class="top">
                                                @if($item->purpose == 'Sale')
                                                    <div class="status-sale">
                                                        For Sale
                                                    </div>
                                                @elseif($item->purpose == 'Rent')
                                                    <div class="status-rent">
                                                        For Rent
                                                    </div>
                                                @endif
                                                @if($item->is_featured == 'Yes')
                                                    <div class="featured">
                                                        Featured
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="price">${{ $item->price }}</div>
                                            <!-- <div class="wishlist"><a href=""><i class="far fa-heart"></i></a></div> -->
                                        </div>
                                        <div class="text">
                                            <h3><a href="{{ route('property_detail', $item->slug)}}">{{ $item->name }}</a></h3>
                                            <div class="detail">
                                                <div class="stat">
                                                    <div class="i1">{{ $item->size }} sqft</div>
                                                    <div class="i2">{{ $item->bedroom }} Bed</div>
                                                    <div class="i3">{{ $item->bathroom }} Bath</div>
                                                </div>
                                                <div class="address">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $item->address }}
                                                </div>
                                                <div class="type-location">
                                                    <div class="i1">
                                                        <i class="fas fa-edit"></i> {{ $item->type->name }}
                                                    </div>
                                                    <div class="i2">
                                                        <i class="fas fa-location-arrow"></i> {{ $item->location->name }}
                                                    </div>
                                                </div>
                                                <div class="agent-section">
                                                    @if($item->agent->photo != '')
                                                        <img class="agent-photo" src="{{ asset('uploads/' . $item->agent->photo) }}" alt="">
                                                    @else
                                                        <img class="agent-photo" src="{{ asset('uploads/default.png') }}" alt="">
                                                    @endif
                                                    <a href="{{ route('agent', $item->agent->id) }}">{{ $item->agent->name }}
                                                        ({{ $item->agent->company }})</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-md-12 d-flex justify-content-center">
                                    {{ $properties->appends($_GET)->links() }}
                                </div>
                                @endif
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection