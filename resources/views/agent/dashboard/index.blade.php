@extends('front.layouts.master')
@section('main_content')

    <div class="page-top" style="background-image: url({{ asset('uploads/'. $global_setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Agent Dashboard</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content user-panel">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="card">
                        @include('agent.sidebar.index')
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <h3>Hello, {{ Auth::guard('agent')->user()->name }}</h3>
                    <p>See all the statistics at a glance:</p>

                    <div class="row box-items">
                        <div class="col-md-4">
                            <div class="box1">
                                <h4>{{ $total_active_properties }}</h4>
                                <p>Active Properties</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box2">
                                <h4>{{ $total_pending_properties }}</h4>
                                <p>Pending Properties</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box3">
                                <h4>{{ $total_featured_properties }}</h4>
                                <p>Featured Properties</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-5">Recent Properties</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Purpose</th>
                                    <th>Location</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                </tr>
                                @foreach($recent_properties as $property)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $property->name }}</td>
                                    <td>{{ $property->type->name }}</td>
                                    <td>{{ $property->purpose }}</td>
                                    <td>{{ $property->location->name }}</td>
                                    <td>${{ $property->price }}</td>
                                    <td>
                                        @if($property->status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $property->created_at->format('d M, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection