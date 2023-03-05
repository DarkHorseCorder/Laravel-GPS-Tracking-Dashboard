@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title" class="form-control-label">Title</label>
                                        <input class="form-control" type="text" name="title" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="report_type" class="form-control-label">Type</label>
                                        <select class="form-select" name="report_type">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Format</label>
                                        <select class="form-select" name="report_type">
                                            <option value="volvo">HTML</option>
                                            <option value="saab">JSX</option>
                                            <option value="opel">CSV</option>
                                            <option value="audi">Pdf</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row pb-3">
                                        <div class="col-md-3">
                                            <label for="period" class="form-control-label">Period</label>
                                        </div>
                                        <div class="col-md-9">
                                            
                                            <select class="form-select" name="period">
                                                <option value="volvo">Today</option>
                                                <option value="saab">CSV</option>
                                                <option value="opel">Opel</option>
                                                <option value="audi">Audi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-md-3">
                                            <label for="period" class="form-control-label">Date from</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input class="form-control" type="date" value="2018-11-23" id="periodDateFrom">
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="time" value="10:30:00" id="periodTimeFrom">
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
                                                    <input class="form-control" type="date" value="2018-11-23" id="periodDateTo">
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="time" value="10:30:00" id="periodTimeTo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row pb-3">
                                        <div class="col-md-3">
                                            <label for="period" class="form-control-label">Devices</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="period">
                                                <option value="volvo">Today</option>
                                                <option value="saab">CSV</option>
                                                <option value="opel">Opel</option>
                                                <option value="audi">Audi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-md-3">
                                            <label for="period" class="form-control-label">Geofences</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="period">
                                                <option value="volvo">Today</option>
                                                <option value="saab">CSV</option>
                                                <option value="opel">Opel</option>
                                                <option value="audi">Audi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-control-label">Send to email</label>
                                        <input class="form-control" type="email" name="email" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="dailyCheckBox">
                                                    <label class="form-check-label" for="dailyCheckBox">
                                                        Daily
                                                    </label>
                                                </div>
                                                <div>
                                                    <input class="form-control" type="text" name="dailytime" placeholder="00:00">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="weeklyCheckBox">
                                                    <label class="form-check-label" for="weeklyCheckBox">
                                                        Weekly
                                                    </label>
                                                </div>
                                                <div>
                                                    <input class="form-control" type="text" name="weeklytime" placeholder="00:00">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="monthlyCheckBox">
                                                    <label class="form-check-label" for="monthlyCheckBox">
                                                        Monthly
                                                    </label>
                                                </div>
                                                <div>
                                                    <input class="form-control" type="text" name="monthlytime" placeholder="00:00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="speedlimit" class="form-control-label">Speed limit</label>
                                                <input class="form-control" type="text" name="speedlimit" placeholder="60">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Stops</label>
                                                <select class="form-select" name="period">
                                                    <option value="volvo">1min</option>
                                                    <option value="saab">CSV</option>
                                                    <option value="opel">Opel</option>
                                                    <option value="audi">Audi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="showAddress">
                                                <label class="form-check-label" for="showAddress">
                                                    Show addresses
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="skipBlankResults">
                                                <label class="form-check-label" for="skipBlankResults">
                                                    Skip blank results
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Zones insead of addresses
                                                </label>
                                            </div>
                                            <select class="form-select" name="period" placeholder="Nothing selected">
                                                <option value="volvo">Today</option>
                                                <option value="saab">CSV</option>
                                                <option value="opel">Opel</option>
                                                <option value="audi">Audi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <button type="submit" class="btn btn-primary btn-sm ms-auto me-3">Gemerate</button>
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
