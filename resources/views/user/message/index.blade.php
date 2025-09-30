@extends('front.layouts.master')
@section('main_content')

    <div class="page-top" style="background-image: url('uploads/banner.jpg')">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Customer Messages</h2>
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
                    <a href="{{ route('message_create') }}" class="btn btn-primary btn-sm mb_10">Compose Message</a>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                    <tr>
                                        <th>SL</th>
                                        <th>Subject</th>
                                        <th>Agent</th>
                                        <th class="w-100">Action</th>
                                    </tr>
                                    @foreach($messages as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->subject }}</td>
                                            <td>
                                                {{ $item->agent->name }}
                                                <br>
                                                {{ $item->agent->company }}
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                         
                                                <a href="" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure ?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
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


@endsection