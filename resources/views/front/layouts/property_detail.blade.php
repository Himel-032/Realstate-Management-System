@extends('front.layouts.master')

@section('main_content')

        <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
            <div class="bg"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{ $property->name }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="property-result pt_50 pb_50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="left-item">
                            <div class="main-photo">
                                <img src="{{ asset('uploads/' . $property->featured_photo) }}" alt="">
                            </div>
                            <h2>
                                Description
                            </h2>
                                {!! $property->description !!}
                        </div>
                        <div class="left-item">
                            <h2>
                                Photos
                            </h2>
                            <div class="photo-all">
                                <div class="row">
                                    @if($property->photos->count() == 0)
                                        <span class="text-danger">No Photos Available.</span>
                                    @else
                                    @foreach($property->photos as $photo)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="item">
                                            <a href="{{ asset('uploads/' . $photo->photo) }}" class="magnific">
                                                <img src="{{ asset('uploads/' . $photo->photo) }}" alt="" />
                                                <div class="icon">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                                <div class="bg"></div>
                                            </a>
                                        </div>
                                    </div>
                                   @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="left-item">
                            <h2>
                                Videos
                            </h2>
                            <div class="video-all">
                                <div class="row">
                                    @if($property->videos->count() == 0)
                                        <span class="text-danger">No Videos Available.</span>
                                    @else
                                    @foreach($property->videos as $video)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="item">
                                            <a class="video-button" href="http://www.youtube.com/watch?v={{ $video->video }}">
                                                <img src="http://img.youtube.com/vi/{{ $video->video }}/0.jpg" alt="" />
                                                <div class="icon">
                                                    <i class="far fa-play-circle"></i>
                                                </div>
                                                <div class="bg"></div>
                                            </a>
                                        </div>
                                    </div>
                                     @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="left-item mb_50">
                            <h2>Share</h2>
                            <div class="share">
                                @php
    $url = url('property/' . $property->slug);
    $photo = asset('uploads/' . $property->featured_photo);
    $text = $property->name;
    $description = $property->description;
                                @endphp
                                <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}&picture={{ $photo }}" target="_blank">
                                    Facebook
                                </a>
                                <a class="twitter" href="https://twitter.com/share?url={{ $url }}&text={{ $text }}" target="_blank">
                                    Twitter
                                </a>
                                <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url={{ $url }}&title={{ $text }}&summary={{ $description }}" target="_blank">
                                    LinkedIn
                                </a>
                            </div>
                        </div>


                        <div class="left-item">
                            <h2>
                                Related Properties
                            </h2>
                            <div class="property related-property pt_0 pb_0">
                                <div class="row">
                                    @php
                                        $related_properties = \App\Models\Property::where('type_id', $property->type_id)->where('id', '!=', $property->id)->where('status', 'Active')->orderBy('id', 'desc')->take(2)->get();
                                    @endphp
                                    @if($related_properties->count() == 0)
                                        <span class="text-danger">No Related Properties Found.</span>
                                    @else
                                    @foreach($related_properties as $item)
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
                                                    <div class="wishlist"><a href=""><i class="far fa-heart"></i></a></div>
                                                </div>
                                                <div class="text">
                                                    <h3><a href="{{ route('property_detail', $item->slug) }}">{{ $item->name }}</a></h3>
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
                                                            <a href="">{{ $item->agent->name }} ({{ $item->agent->company }})</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">

                        <div class="right-item">
                            <h2>Agent</h2>
                            <div class="agent-right d-flex justify-content-start">
                                <div class="left">
                                    <img src="uploads/agent2.jpg" alt="">
                                </div>
                                <div class="right">
                                    <h3><a href="">Michael Johnson</a></h3>
                                    <h4>Real Estate Agent</h4>
                                </div>
                            </div>
                            <div class="table-responsive mt_25">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Posted On: </td>
                                        <td>12 Dec, 2022</td>
                                    </tr>
                                    <tr>
                                        <td>Email: </td>
                                        <td>agent1@website.com</td>
                                    </tr>
                                    <tr>
                                        <td>Phone: </td>
                                        <td>122-232-1111</td>
                                    </tr>
                                    <tr>
                                        <td>Social: </td>
                                        <td>
                                            <ul class="agent-ul">
                                                <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href=""><i class="fab fa-twitter"></i></a></li>
                                                <li><a href=""><i class="fab fa-pinterest-p"></i></a></li>
                                                <li><a href=""><i class="fab fa-instagram"></i></a></li>
                                                <li><a href=""><i class="fab fa-linkedin-in"></i></a></li>
                                                <li><a href=""><i class="fab fa-youtube"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="right-item">
                            <h2>Features</h2>
                            <div class="summary">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><b>Price</b></td>
                                            <td>$49,222</td>
                                        </tr>
                                        <tr>
                                            <td><b>Location</b></td>
                                            <td>New York</td>
                                        </tr>
                                        <tr>
                                            <td><b>Type</b></td>
                                            <td>Villa</td>
                                        </tr>
                                        <tr>
                                            <td><b>Status</b></td>
                                            <td>For Rent</td>
                                        </tr>
                                        <tr>
                                            <td><b>Bedroom:</b></td>
                                            <td>4</td>
                                        </tr>
                                        <tr>
                                            <td><b>Bathroom:</b></td>
                                            <td>3</td>
                                        </tr>
                                        <tr>
                                            <td><b>Size:</b></td>
                                            <td>1200 sqft</td>
                                        </tr>
                                        <tr>
                                            <td><b>Floor:</b></td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td><b>Garage:</b></td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td><b>Balcony:</b></td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td><b>Address:</b></td>
                                            <td>937 Jamajo Blvd, Orlando FL 32803</td>
                                        </tr>
                                        <tr>
                                            <td><b>Built Year:</b></td>
                                            <td>2008</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="right-item">
                            <h2>Amenities</h2>
                            <div class="amenity">
                                <ul class="amenity-ul">
                                    <li><i class="fas fa-check-square"></i> Swimming Pool</li>
                                    <li><i class="fas fa-check-square"></i> Parking Lot</li>
                                    <li><i class="fas fa-check-square"></i> Gym & Fitness Center</li>
                                    <li><i class="fas fa-check-square"></i> Internet Connection</li>
                                    <li><i class="fas fa-check-square"></i> Room Service</li>
                                    <li><i class="fas fa-check-square"></i> Private Locker</li>
                                </ul>
                            </div>
                        </div>

                        <div class="right-item">
                            <h2>Location Map</h2>
                            <div class="location-map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3629.2542091435403!2d-97.90512175238419!3d38.06450160184029!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sbd!4v1671347381733!5m2!1sen!2sbd" width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>

                        <div class="right-item">
                            <h2>Enquery Form</h2>
                            <div class="enquery-form">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Full Name" />
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" placeholder="Email Address" />
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Phone Number" />
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control h-150" rows="3" placeholder="Message"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
@endsection