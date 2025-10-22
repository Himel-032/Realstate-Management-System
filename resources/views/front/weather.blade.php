@extends('front.layouts.master')

@section('main_content')

    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Weather Information</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content faq">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="accordion" id="accordionExample">
                        @foreach($locations as $index => $location)
                            @php
                                $data = $weatherData[$location->name] ?? null;
                            @endphp

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_{{ $index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_{{ $index }}" aria-expanded="false" aria-controls="collapse_{{ $index }}">
                                        {{ $location->name }}
                                    </button>
                                </h2>
                                <div id="collapse_{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $index }}"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body text-center">

                                        @if($data)
                                            <img src="https://openweathermap.org/img/wn/{{ $data['icon'] ?? '01d' }}@2x.png" alt="icon" width="80">
                                            <h4>{{ $data['description'] }}</h4>
                                            <p><strong>Temperature:</strong> {{ $data['temp'] }}°C</p>
                                            <p><strong>Humidity:</strong> {{ $data['humidity'] }}%</p>
                                        @else
                                            <p>Weather data not available.</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection