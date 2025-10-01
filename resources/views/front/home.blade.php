@extends('front.layouts.master')

@section('main_content')
    <div class="slider" style="background-image: url({{ asset('uploads/banner-home.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="item">
                        <div class="text">
                            <h2>Discover Your New Home</h2>
                            <p>
                                You can get your desired awesome properties, homes, condos etc. here by name, category
                                or location.
                            </p>
                        </div>
                        <div class="search-section">
                            <form action="{{ route('property_search') }}" method="get">
                                <div class="inner">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Search By Name..." >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select name="location" class="form-select select2">
                                                    <option value=""> Select Location</option>
                                                    @foreach($search_locations as $location)
                                                        <option value="{{ $location->id }}" >{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select name="type" class="form-select select2">
                                                    <option value="">Select Type</option>
                                                    @foreach($search_types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="property">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Featured Properties</h2>
                        <p>Find out the awesome properties that you must love</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($properties as $item)
                    <div class="col-lg-4 col-md-6 col-sm-12">
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
                                <!-- <div class="wishlist"><a href="{{ route('wishlist_add', $item->id) }}"><i class="far fa-heart"></i></a></div> -->
                                <div class="wishlist">
                                    @if(in_array($item->id, $wishlist_ids))
                                        <a href="{{ route('wishlist_add', $item->id) }}">
                                            <i class="fas fa-heart" style="color: pink;"></i> <!-- filled heart -->
                                        </a>
                                    @else
                                        <a href="{{ route('wishlist_add', $item->id) }}">
                                            <i class="far fa-heart" style="color: pink;"></i> <!-- empty heart -->
                                        </a>
                                    @endif
                                </div>

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
                                        <a href="{{ route('agent', $item->agent->id) }}">{{ $item->agent->name }} ({{ $item->agent->company }})</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>


    <div class="why-choose" style="background-image: url({{ asset('uploads/why-choose.jpg') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Why Choose Us</h2>
                        <p>
                            Describing why we are best in the property business
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="inner">
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="text">
                            <h2>Years of Experience</h2>
                            <p>
                                With decades of combined experience in the industry, our agents have the expertise and
                                knowledge to provide you with a seamless home-buying experience.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner">
                        <div class="icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="text">
                            <h2>Competitive Prices</h2>
                            <p>
                                We understand that buying a home is a significant investment, which is why we strive to
                                offer competitive prices to our clients.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner">
                        <div class="icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div class="text">
                            <h2>Responsive Communication</h2>
                            <p>
                                Our responsive agents are here to answer your questions and address your concerns,
                                ensuring a smooth and stress-free home-buying experience.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="agent">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Agents</h2>
                        <p>
                            Meet our expert property agents from the following list
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($agents as $agent)
                    <div class="col-lg-3 col-md-3">
                        <div class="item">
                            <div class="photo">
                                <a href="{{ route('agent', $agent->id) }}"><img src="{{ asset('uploads/' . $agent->photo) }}" alt=""></a>
                            </div>
                            <div class="text">
                                <h2>
                                    <a href="{{ route('agent', $agent->id) }}">{{ $agent->name }}</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>



    <div class="location pb_40">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Locations</h2>
                        <p>
                            Check out all the properties of important locations
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($locations as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="item">
                            <div class="photo">
                                <a href="{{ route('location', $item->slug) }}"><img src="{{ asset('uploads/' . $item->photo) }}" alt=""></a>
                            </div>
                            <div class="text">
                                <h2><a href="{{ route('location', $item->slug) }}">{{ $item->name }}</a></h2>
                                <h4>({{ $item->properties_count }} Properties)</h4>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>



    <div class="testimonial" style="background-image: url({{ asset('uploads/testimonial-bg.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-header">Our Happy Clients</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-carousel owl-carousel">
                        @foreach($testimonials as $item)
                        <div class="item">
                            <div class="photo">
                                <img src="{{ asset('uploads/' . $item->photo) }}" alt="" />
                            </div>
                            <div class="text">
                                <h4>{{ $item->name }}</h4>
                                <p>{{ $item->designation }}</p>
                            </div>
                            <div class="description">
                                    {!! $item->comment !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Latest News</h2>
                        <p>
                            Check our latest news from the following section
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/blog1.jpg') }}" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="post.html">5 Tips for Finding Your Dream Home</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    Lorem ipsum dolor sit amet, nibh saperet
                                    te pri, at nam diceret disputationi. Quo
                                    an consul impedit, usu possim evertitur
                                    dissentiet ei.
                                </p>
                            </div>
                            <div class="button">
                                <a href="post.html" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/blog2.jpg') }}" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="post.html">Pros & Cons of Renting vs. Buying</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    Nec in rebum primis causae. Affert
                                    iisque ex pri, vis utinam vivendo
                                    definitionem ad, nostrum omnes que per
                                    et. Omnium antiopam.
                                </p>
                            </div>
                            <div class="button">
                                <a href="post.html" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/blog3.jpg') }}" alt="" />
                        </div>
                        <div class="text">
                            <h2>
                                <a href="post.html">Maximizing Your Investment in 2023</a>
                            </h2>
                            <div class="short-des">
                                <p>
                                    Id pri placerat voluptatum, vero dicunt
                                    dissentiunt eum et, adhuc iisque vis no.
                                    Eu suavitate conten tiones definitionem
                                    mel, ex vide.
                                </p>
                            </div>
                            <div class="button">
                                <a href="post.html" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection