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
                    <form role="form" id="greenDrivingForm" method="POST" action={{ route('generateReport.green-driving') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title" class="form-control-label">Title</label>
                                        <input class="form-control" type="text" name="title" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="output_format" class="form-control-label">Format</label>
                                        <select class="form-select" name="output_format">
                                            <option value="html">HTML</option>
                                            <option value="xml">XML</option>
                                            <option value="csv">CSV</option>
                                            <option value="pdf">PDF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="device_type" class="form-control-label">Devices</label>
                                        <select class="form-select" name="device_type[]" multiple="true" id="deviceType" required>
                                            @foreach($devices as $device)
                                            <option value='{"deviceID" : {{$device["id"]}}, "deviceName" : "{{$device["name"]}}", "driverID" : "{{$device["driver_data"]["id"]}}", "driverName" : "{{$device["driver"]}}"}'>{{$device["name"]}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row pb-3">
                                        <div class="col-md-3">
                                            <label for="period" class="form-control-label">Period</label>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-md-3">
                                            <label for="period" class="form-control-label">Date from</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input class="form-control" type="date" id="periodDateFrom" name="periodDateFrom">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="time" id="periodTimeFrom" name="periodTimeFrom">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-md-3">
                                            <label for="period" class="form-control-label">Date to</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input class="form-control" type="date" id="periodDateTo" name="periodDateTo">
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="time" id="periodTimeTo" name="periodTimeTo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer p-0">
                            <button id="GreenDrivingGenrateSubmit" class="btn btn-primary btn-sm ms-auto me-3">Generate</button>
                            <button type="submit" class="btn btn-grey btn-sm ms-auto me-3">Save</button>
                            <button type="submit" class="btn btn-grey btn-sm ms-auto me-3">New</button>
                            <button type="submit" class="btn btn-grey btn-sm ms-auto me-3">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- @include('layouts.footers.auth.footer') -->
    </div>
@endsection