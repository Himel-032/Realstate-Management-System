@extends('front.layouts.master')

@section('main_content')
    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Agent Orders</h2>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Payment Id</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Order Date</th>
                                    <th>Expire Date</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>28937487</td>
                                    <td>Basic</td>
                                    <td>$19</td>
                                    <td>2022-08-12</td>
                                    <td>2022-08-27</td>
                                    <td>PayPal</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>92834744</td>
                                    <td>Standard</td>
                                    <td>$29</td>
                                    <td>2022-12-28</td>
                                    <td>2023-01-10</td>
                                    <td>Stripe</td>
                                    <td>
                                        <span class="badge bg-danger">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection