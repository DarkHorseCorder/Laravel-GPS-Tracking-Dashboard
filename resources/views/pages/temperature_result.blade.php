@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Temperature Result'])
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Device Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Record Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Temp1 &deg;C</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Temp2 &deg;C</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Temp3 &deg;C</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Temp4 &deg;C</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalOutputData as $outPutData)
                            <tr>
                                <td>{{$outPutData['deviceName']}}</td>
                                <td>{{$outPutData['recordDate']}}</td>
                                <td>{{$outPutData['temp1']}}</td>
                                <td>{{$outPutData['temp2']}}</td>
                                <td>{{$outPutData['temp3']}}</td>
                                <td>{{$outPutData['temp4']}}</td>
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