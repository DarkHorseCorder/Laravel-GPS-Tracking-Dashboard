@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Green Driving Result'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Driver Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Device Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Distance</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Speeding Count</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Speeding Duration</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Max Acceleration</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Max Braking</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Max Cornering</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Driver Score</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalOutputData as $outPutData)
                            <tr>
                                <td>{{$outPutData['driverName']}}</td>
                                <td>{{$outPutData['deviceName']}}</td>
                                <td>{{$outPutData['totalDistance']}}</td>
                                <td>Speed Count</td>
                                <td>Speed Duration</td>
                                <td>{{$outPutData['totalMaxAcceleration']}}</td>
                                <td>{{$outPutData['totalMaxBraking']}}</td>
                                <td>{{$outPutData['totalMaxCornering']}}</td>
                                <td>Driver Score</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- @include('layouts.footers.auth.footer') -->
    </div>
@endsection