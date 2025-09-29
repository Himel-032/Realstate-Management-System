@extends('admin.layouts.master')
@section('main_content')

    @include('admin.layouts.nav')
    @include('admin.layouts.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Properties</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="example1">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Featured Photo</th>
                                                <th>Name</th>
                                                <th>Agent</th>
                                                <th>Location</th>
                                                <th>Type</th>
                                                <th>Purpose</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($properties as $property)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($property->featured_photo != '')
                                                            <img src="{{ asset('uploads/'.$property->featured_photo) }}" alt="Property Photo" class="w_100">
                                                        @endif
                                                    </td>
                                                    <td>{{ $property->name }}</td>
                                                    <td>{{ $property->agent->name }}</td>
                                                    <td>{{ $property->location->name }}</td>
                                                    <td>{{ $property->type->name }}</td>
                                                    <td>{{ $property->purpose }}</td>
                                                    <td>${{ $property->price }}</td>
                                                    <td>
                                                        @if($property->status == 'Pending')
                                                            <span class="badge bg-danger">{{ $property->status }}</span>
                                                        @else
                                                            <span class="badge bg-success">{{ $property->status }}</span>
                                                        @endif
                                                        <div><a href="{{ route('admin_property_change_status', $property->id) }}">Change</a></div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin_property_detail', $property->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('admin_property_delete', $property->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
                                     