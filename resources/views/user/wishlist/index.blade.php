@extends('front.layouts.master')
@section('main_content')

    <div class="page-top" style="background-image: url('uploads/banner.jpg')">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Customer Wishlist</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content user-panel">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="card">
                        @include('user.sidebar.index')
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                @if($wishlists->count() == 0)
                                <div class="alert alert-danger">No wishlist items found.</div>
                                @else
                                    <tr>
                                        <th>SL</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Detail</th>
                                        <th class="w-100">Action</th>
                                    </tr>
                                    @foreach($wishlists as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset('uploads/' . $item->property->featured_photo) }}" alt="" class="w-200">
                                            </td>
                                            <td>{{ $item->property->name }}</td>
                                            <td>${{ $item->property->price }}</td>
                                            <td>
                                                <a href="{{ route('property_detail', $item->property->slug) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <!-- <a href="{{ route('wishlist_delete', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">
                                                    <i class="fas fa-trash"></i>
                                                </a> -->
                                                <!-- Trigger link -->
                                                <a href="#confirmModal{{ $item->id }}" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                                <!-- Modal -->
                                                <div id="confirmModal{{ $item->id }}" class="modall">
                                                    <div class="modall-content">
                                                        <h3>Are you sure?</h3>
                                                        <p>This action cannot be undone.</p>
                                                        <div class="buttons">
                                                            <a href="{{ route('wishlist_delete', $item->id) }}" class="btn btn-danger">Yes, Delete</a>
                                                            <a href="#" class="btn btn-secondary">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection