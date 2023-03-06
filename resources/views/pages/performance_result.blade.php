@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Green Driving'])
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
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gallon Consumption</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Performance</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kilometer Cost</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Route Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalOutputData as $outPutData)
                            <tr>
                                <td>{{$outPutData['driverName']}}</td>
                                <td>{{$outPutData['deviceName']}}</td>
                                <td>{{$outPutData['totalDistance']}}</td>
                                <td>{{$outPutData['totalFuelUsed']}}</td>
                                <td>{{$outPutData['unitPerformance']}}</td>
                                <td>{{$outPutData['kilometerCost']}}</td>
                                <td>{{$outPutData['totalRouteCost']}}</td>
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