<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>
        Argon Dashboard 2 by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link id="pagestyle" href="assets/css/argon-dashboard.css" rel="stylesheet" />
    <link id="pagestyle" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.14/css/bootstrap-multiselect.css" rel="stylesheet" />
    <link href="./assets/css/custom.css" rel="stylesheet" />
</head>

<body class="<?php echo e($class ?? ''); ?>">
    <div id="loadingScreen">
        <div class="progressIndicator">
            <p style="text-align : center">Analyzing Data...</p>
            <div class="progress customProgress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
        </div>
    </div>
    <?php if(auth()->guard()->guest()): ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
        <?php if(in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register', 'recover-password', 'rtl', 'virtual-reality'])): ?>
            <?php echo $__env->yieldContent('content'); ?>
        <?php else: ?>
            <?php if(!in_array(request()->route()->getName(), ['profile', 'profile-static'])): ?>
                <div class="min-height-300 bg-primary position-absolute w-100"></div>
            <?php elseif(in_array(request()->route()->getName(), ['profile-static', 'profile'])): ?>
                <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                    <span class="mask bg-primary opacity-6"></span>
                </div>
            <?php endif; ?>
            <?php echo $__env->make('layouts.navbars.auth.sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <main class="main-content border-radius-lg" style="overflow : visible!important">
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
            <?php echo $__env->make('components.fixed-plugin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>

    <!--   Core JS Files   -->
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.14/js/bootstrap-multiselect.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script>
        function formatDate(date = new Date()) {
            const year = date.toLocaleString('default', {year: 'numeric'});
            const month = date.toLocaleString('default', {month: '2-digit'});
            const day = date.toLocaleString('default', {day: '2-digit'});

            return [year, month, day].join('-');
        }
        function formatTime(date = new Date()) {
            const hour = date.getHours()<10 ? '0'+ date.getHours() : date.getHours();
            const min = date.getMinutes()<10 ? '0'+ date.getMinutes() : date.getMinutes();
            return [hour, min].join(':');
        }
        $('#deviceType').multiselect({
            nonSelectedText: 'Select Devices',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
        });
        var currentDate = new Date();
        var yesterday = new Date(currentDate.getTime());
        yesterday.setDate(currentDate.getDate() - 1);
        document.getElementById('periodDateFrom').value = formatDate(yesterday);
        document.getElementById('periodTimeFrom').value = formatTime(yesterday);
        document.getElementById('periodDateTo').value = formatDate(currentDate);
        document.getElementById('periodTimeTo').value = formatTime(currentDate);
    </script>
    <script>
        $(document).ready(function(){
            $('#GreenDrivingGenrateSubmit').click(async function(event) {
                event.preventDefault();
                document.getElementById('loadingScreen').style.display = "flex";
                const form = document.getElementById('greenDrivingForm');
                const formData = new FormData(form);
                //input data
                const title = formData.get('title');
                const outputFormat = formData.get('output_format');
                const user_api_hash_value = '$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O';
                const devicesData = formData.getAll('device_type[]');
                const fromDate = formData.get('periodDateFrom');
                const fromTime = formData.get('periodTimeFrom');
                const toDate = formData.get('periodDateTo');
                const toTime = formData.get('periodTimeTo');
                let totalOutputData = [];

                for (let i = 0; i < devicesData.length; i++) {
                    const dData = JSON.parse(devicesData[i]);
                    let totalDistance = 0;
                    let totalMaxAcceleration = 0;
                    let totalMaxBraking = 0;
                    let totalMaxCornering = 0;

                    const historyApiURL = `http://104.131.12.58/api/get_history?user_api_hash=${user_api_hash_value}&device_id=${dData.deviceID}&from_date=${fromDate}&from_time=${fromTime}&to_date=${toDate}&to_time=${toTime}`;
                    const historyResponse = await fetch(historyApiURL);
                    const historyData = await historyResponse.json();
                    totalDistance = historyData.distance_sum;

                    const apiURL = `http://104.131.12.58/api/get_events?user_api_hash=${user_api_hash_value}&device_id=${dData.deviceID}&from_date=${fromDate}&to_date=${toDate}`;
                    const response = await fetch(apiURL);
                    const data = await response.json();
                    const totalPage = data.items.last_page;

                    for (let j = 1; j <= totalPage; j++) {
                        const EventApiURL = `http://104.131.12.58/api/get_events?page=${j}&user_api_hash=${user_api_hash_value}&device_id=${dData.deviceID}&date_from=${fromDate}&date_to=${toDate}`;
                        const Eventresponse = await fetch(EventApiURL);
                        const Eventdata = await Eventresponse.json();
                        const Events = Eventdata.items.data;
                        if (Array.isArray(Events)) {
                            Events.forEach((event) => {
                                if (event["message"].toLowerCase() == "maxacceleration")
                                    totalMaxAcceleration++;
                                if (event["message"].toLowerCase() == "maxbraking")
                                    totalMaxBraking++;
                                if (event["message"].toLowerCase() == "maxcornering")
                                    totalMaxCornering++;
                            });
                        }
                    }

                    const eachDeviceData = {
                        deviceID: dData.deviceID,
                        driverName: dData.driverName,
                        deviceName: dData.deviceName,
                        totalDistance: totalDistance,
                        totalMaxAcceleration: totalMaxAcceleration,
                        totalMaxBraking: totalMaxBraking,
                        totalMaxCornering: totalMaxCornering,
                    };
                    totalOutputData.push(eachDeviceData);
                }
                if(outputFormat == "html")
                {
                    let tbodyOutputData = "";
                    for (let k = 0; k<totalOutputData.length; k++){
                        console.log(totalOutputData[k]);
                        tbodyOutputData += "<tr>";
                        tbodyOutputData += `<td>${totalOutputData[k].driverName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].deviceName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalDistance}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalMaxAcceleration}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalMaxBraking}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalMaxCornering}</td>`;
                        tbodyOutputData += "</tr>";
                    }
                    let tableOutput = `
                    <table>
                        <thead>
                            <tr>
                                <th>Driver Name</th>
                                <th>Device Name</th>
                                <th>Total Distance</th>
                                <th>Max Acceleration</th>
                                <th>Max Braking</th>
                                <th>Max Cornering</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${tbodyOutputData}
                        </tbody>
                    </table>
                    `
                    GenerateHTML(title, fromDate, fromTime, toDate, toTime, tableOutput);
                }
                if(outputFormat == "xml"){
                    let xmlOutput = "<root>";
                    for (let k = 0; k<totalOutputData.length; k++){
                        console.log(totalOutputData[k]);
                        xmlOutput += "<record>";
                        xmlOutput += `<driverName>${totalOutputData[k].driverName}</driverName>`;
                        xmlOutput += `<deviceName>${totalOutputData[k].deviceName}</deviceName>`;
                        xmlOutput += `<totalDistance>${totalOutputData[k].totalDistance}</totalDistance>`;
                        xmlOutput += `<totalMaxAcceleration>${totalOutputData[k].totalMaxAcceleration}</totalMaxAcceleration>`;
                        xmlOutput += `<totalMaxBraking>${totalOutputData[k].totalMaxBraking}</totalMaxBraking>`;
                        xmlOutput += `<totalMaxCornering>${totalOutputData[k].totalMaxCornering}</totalMaxCornering>`;
                        xmlOutput += "</record>";
                    }
                    xmlOutput += "</root>";
                    GenerateXML(title, fromDate, fromTime, toDate, toTime, xmlOutput)
                }
                if(outputFormat == "pdf"){
                    let tbodyOutputData = "";
                    for (let k = 0; k<totalOutputData.length; k++){
                        console.log(totalOutputData[k]);
                        tbodyOutputData += "<tr>";
                        tbodyOutputData += `<td>${totalOutputData[k].driverName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].deviceName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalDistance}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalMaxAcceleration}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalMaxBraking}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalMaxCornering}</td>`;
                        tbodyOutputData += "</tr>";
                    }
                    let tableOutput = `
                    <table>
                        <thead>
                            <tr>
                                <th>Driver Name</th>
                                <th>Device Name</th>
                                <th>Total Distance</th>
                                <th>Max Acceleration</th>
                                <th>Max Braking</th>
                                <th>Max Cornering</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${tbodyOutputData}
                        </tbody>
                    </table>
                    `
                    GeneratePDF(title, fromDate, fromTime, toDate, toTime, tableOutput)
                }
                if(outputFormat == "csv"){
                    GenerateCSV(title, fromDate, fromTime, toDate, toTime, totalOutputData)
                }
                document.getElementById('loadingScreen').style.display = "none";
            });
            $('#PerformanceGenerateSubmit').click(async function(event) {
                event.preventDefault();
                document.getElementById('loadingScreen').style.display = "flex";
                const form = document.getElementById('performanceForm');
                const formData = new FormData(form);
                //input data
                const title = formData.get('title');
                const outputFormat = formData.get('output_format');
                const user_api_hash_value = '$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O';
                const devicesData = formData.getAll('device_type[]');
                const fromDate = formData.get('periodDateFrom');
                const fromTime = formData.get('periodTimeFrom');
                const toDate = formData.get('periodDateTo');
                const toTime = formData.get('periodTimeTo');
                const gallonPrice = formData.get('gallonPrice');
                let totalOutputData = [];

                for (let i = 0; i < devicesData.length; i++) {
                    const dData = JSON.parse(devicesData[i]);
                    let totalDistance = 0;
                    let totalFuelUsed = 0;
                    let unitPerformance = 0;
                    let kilometerCost = 0;
                    let totalRouteCost = 0;
                    const historyApiURL = `http://104.131.12.58/api/get_history?user_api_hash=${user_api_hash_value}&device_id=${dData.deviceID}&from_date=${fromDate}&from_time=${fromTime}&to_date=${toDate}&to_time=${toTime}`;
                    const historyResponse = await fetch(historyApiURL);
                    const historyData = await historyResponse.json();
                    totalDistance = historyData.distance_sum;
                    const HistoryRecordItems = historyData.items;
                    let lastRecordXML = new DOMParser().parseFromString(HistoryRecordItems[0]['items'][0]['other'], "text/xml");
                    if (lastRecordXML.getElementsByTagName('fuelused').length > 0) {
                        let lastFuelRecord = parseInt(lastRecordXML.getElementsByTagName('fuelused')[0].textContent);
                        let initRecord = HistoryRecordItems[HistoryRecordItems.length - 1];
                        let initRecordXML = new DOMParser().parseFromString(initRecord['items'][0]['other'], "text/xml");
                        let initFuelRecord = parseInt(initRecordXML.getElementsByTagName('fuelused')[0].textContent);
                        totalFuelUsed = Math.round((initFuelRecord - lastFuelRecord) * 0.264172, 1);
                        if (totalFuelUsed === 0) {
                            unitPerformance = "No data";
                            kilometerCost = "No data";
                            totalRouteCost = "No data";
                        } else {
                            distanceValue = parseFloat(totalDistance.replace(/[^\d.]/g, ''));
                            unitPerformance = (totalFuelUsed / distanceValue).toFixed(1);
                            kilometerCost = (totalFuelUsed * gallonPrice / distanceValue).toFixed(1);
                            totalRouteCost = (totalFuelUsed * gallonPrice).toFixed(1);
                        }
                    } else {
                        totalFuelUsed = "No data";
                        unitPerformance = "No data";
                        kilometerCost = "No data";
                        totalRouteCost = "No data";
                    }
                    let eachDeviceData = {
                        deviceID: dData.deviceID,
                        driverName: dData.driverName,
                        deviceName: dData.deviceName,
                        totalDistance: totalDistance,
                        totalFuelUsed: totalFuelUsed,
                        unitPerformance: unitPerformance,
                        kilometerCost: kilometerCost,
                        totalRouteCost: totalRouteCost
                    };
                    totalOutputData.push(eachDeviceData);
                }
                if(outputFormat == "html")
                {
                    let tbodyOutputData = "";
                    for (let k = 0; k<totalOutputData.length; k++){
                        tbodyOutputData += "<tr>";
                        tbodyOutputData += `<td>${totalOutputData[k].driverName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].deviceName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalDistance}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalFuelUsed}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].unitPerformance}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].kilometerCost}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalRouteCost}</td>`;
                        tbodyOutputData += "</tr>";
                    }
                    let tableOutput = `
                    <table>
                        <thead>
                            <tr>
                                <th>Driver Name</th>
                                <th>Device Name</th>
                                <th>Total Distance</th>
                                <th>Total Fuel Used</th>
                                <th>Unit Performance</th>
                                <th>Cost per Kilometer</th>
                                <th>Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${tbodyOutputData}
                        </tbody>
                    </table>
                    `
                    GenerateHTML(title, fromDate, fromTime, toDate, toTime, tableOutput);
                }
                if(outputFormat == "xml"){
                    let xmlOutput = "<root>";
                    for (let k = 0; k<totalOutputData.length; k++){
                        xmlOutput += "<record>";
                        xmlOutput += `<driverName>${totalOutputData[k].driverName}</driverName>`;
                        xmlOutput += `<deviceName>${totalOutputData[k].deviceName}</deviceName>`;
                        xmlOutput += `<totalDistance>${totalOutputData[k].totalDistance}</totalDistance>`;
                        xmlOutput += `<totalFuelUsed>${totalOutputData[k].totalFuelUsed}</totalFuelUsed>`;
                        xmlOutput += `<unitPerformance>${totalOutputData[k].unitPerformance}</unitPerformance>`;
                        xmlOutput += `<kilometerCost>${totalOutputData[k].kilometerCost}</kilometerCost>`;
                        xmlOutput += `<totalRouteCost>${totalOutputData[k].totalRouteCost}</totalRouteCost>`;
                        xmlOutput += "</record>";
                    }
                    xmlOutput += "</root>";
                    GenerateXML(title, fromDate, fromTime, toDate, toTime, xmlOutput)
                }
                if(outputFormat == "pdf"){
                    let tbodyOutputData = "";
                    for (let k = 0; k<totalOutputData.length; k++){
                        tbodyOutputData += "<tr>";
                        tbodyOutputData += `<td>${totalOutputData[k].driverName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].deviceName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalDistance}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalFuelUsed}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].unitPerformance}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].kilometerCost}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].totalRouteCost}</td>`;
                        tbodyOutputData += "</tr>";
                    }
                    let tableOutput = `
                    <table>
                        <thead>
                            <tr>
                                <th>Driver Name</th>
                                <th>Device Name</th>
                                <th>Total Distance</th>
                                <th>Total Fuel Used</th>
                                <th>Unit Performance</th>
                                <th>Cost per Kilometer</th>
                                <th>Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${tbodyOutputData}
                        </tbody>
                    </table>
                    `
                    GeneratePDF(title, fromDate, fromTime, toDate, toTime, tableOutput)
                }
                if(outputFormat == "csv"){
                    GenerateCSV(title, fromDate, fromTime, toDate, toTime, totalOutputData)
                }
                document.getElementById('loadingScreen').style.display = "none";
            });
            $('#TemperatureGenerateSubmit').click(async function(event) {
                event.preventDefault();
                document.getElementById('loadingScreen').style.display = "flex";
                const form = document.getElementById('temperatureForm');
                const formData = new FormData(form);
                //input data
                const title = formData.get('title');
                const outputFormat = formData.get('output_format');
                const user_api_hash_value = '$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O';
                const devicesData = formData.getAll('device_type[]');
                const fromDate = formData.get('periodDateFrom');
                const fromTime = formData.get('periodTimeFrom');
                const toDate = formData.get('periodDateTo');
                const toTime = formData.get('periodTimeTo');
                let totalOutputData = [];
                for (let i = 0; i < devicesData.length; i++) {
                    const dData = JSON.parse(devicesData[i]);
                    let HistoryapiURL = `http://104.131.12.58/api/get_history?user_api_hash=${user_api_hash_value}&device_id=${dData.deviceID}&from_date=${fromDate}&from_time=${fromTime}&to_date=${toDate}&to_time=${toTime}`;
                    let HistoryResponse = await fetch(HistoryapiURL, { timeout: 180000 });
                    let HistoryJsonData = await HistoryResponse.json();
                    let prevTemp1 = prevTemp2 = prevTemp3 = prevTemp4 = 0;
                    let curTemp1 = curTemp2 = curTemp3 = curTemp4 = "-";
                    let recordDate = 0;
                    let device_name = HistoryJsonData.device.name;

                    for (let j = 0; j < HistoryJsonData.items.length; j++) {
                        let HistoryItems = HistoryJsonData.items[j];

                        for (let k = 0; k < HistoryItems.items.length; k++) {
                            let HistoryItem = HistoryItems.items[k];

                            if (HistoryItem.other && HistoryItem.other !== "") 
                            {
                                let parser = new DOMParser();
                                let xml = parser.parseFromString(HistoryItem.other, "text/xml");

                                if (xml.getElementsByTagName("temp1")[0]) {
                                    curTemp1 = parseFloat(xml.getElementsByTagName("temp1")[0].textContent);
                                }
                                if (xml.getElementsByTagName("temp5")[0]) {
                                    curTemp1 = parseFloat(xml.getElementsByTagName("temp5")[0].textContent);
                                }
                                if (xml.getElementsByTagName("temp2")[0]) {
                                    curTemp2 = parseFloat(xml.getElementsByTagName("temp2")[0].textContent);
                                }
                                if (xml.getElementsByTagName("temp6")[0]) {
                                    curTemp2 = parseFloat(xml.getElementsByTagName("temp6")[0].textContent);
                                }
                                if (xml.getElementsByTagName("temp3")[0]) {
                                    curTemp3 = parseFloat(xml.getElementsByTagName("temp3")[0].textContent);
                                }
                                if (xml.getElementsByTagName("temp7")[0]) {
                                    curTemp3 = parseFloat(xml.getElementsByTagName("temp7")[0].textContent);
                                }
                                if (xml.getElementsByTagName("temp4")[0]) {
                                    curTemp4 = parseFloat(xml.getElementsByTagName("temp4")[0].textContent);
                                }
                                if (xml.getElementsByTagName("temp8")[0]) {
                                    curTemp4 = parseFloat(xml.getElementsByTagName("temp8")[0].textContent);
                                }
                                if (prevTemp1 !== curTemp1 || prevTemp2 !== curTemp2 || prevTemp3 !== curTemp3 || prevTemp4 !== curTemp4) 
                                {
                                    prevTemp1 = curTemp1;
                                    prevTemp2 = curTemp2;
                                    prevTemp3 = curTemp3;
                                    prevTemp4 = curTemp4;
                                    recordDate = HistoryItem.raw_time;
                                    let data = {
                                    deviceName: device_name,
                                    recordDate: recordDate,
                                    temp1: prevTemp1,
                                    temp2: prevTemp2,
                                    temp3: prevTemp3,
                                    temp4: prevTemp4,
                                    };
                                    totalOutputData.push(data);
                                }
                            }
                        }
                    }
                }
                if(outputFormat == "html")
                {
                    let tbodyOutputData = "";
                    for (let k = 0; k<totalOutputData.length; k++){
                        tbodyOutputData += "<tr>";
                        tbodyOutputData += `<td>${totalOutputData[k].deviceName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].recordDate}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp1}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp2}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp3}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp4}</td>`;
                        tbodyOutputData += "</tr>";
                    }
                    let tableOutput = `
                    <table>
                        <thead>
                            <tr>
                                <th>Device Name</th>
                                <th>Record Date</th>
                                <th>Temp1</th>
                                <th>Temp2</th>
                                <th>Temp3</th>
                                <th>Temp4</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${tbodyOutputData}
                        </tbody>
                    </table>
                    `
                    GenerateHTML(title, fromDate, fromTime, toDate, toTime, tableOutput);
                }
                if(outputFormat == "xml"){
                    let xmlOutput = "<root>";
                    for (let k = 0; k<totalOutputData.length; k++){
                        xmlOutput += "<record>";
                        xmlOutput += `<deviceName>${totalOutputData[k].deviceName}</deviceName>`;
                        xmlOutput += `<recordDate>${totalOutputData[k].recordDate}</recordDate>`;
                        xmlOutput += `<temp1>${totalOutputData[k].temp1}</temp1>`;
                        xmlOutput += `<temp2>${totalOutputData[k].temp2}</temp2>`;
                        xmlOutput += `<temp3>${totalOutputData[k].temp3}</temp3>`;
                        xmlOutput += `<temp4>${totalOutputData[k].temp4}</temp4>`;
                        xmlOutput += "</record>";
                    }
                    xmlOutput += "</root>";
                    GenerateXML(title, fromDate, fromTime, toDate, toTime, xmlOutput)
                }
                if(outputFormat == "pdf"){
                    let tbodyOutputData = "";
                    for (let k = 0; k<totalOutputData.length; k++){
                        tbodyOutputData += "<tr>";
                        tbodyOutputData += `<td>${totalOutputData[k].deviceName}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].recordDate}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp1}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp2}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp3}</td>`;
                        tbodyOutputData += `<td>${totalOutputData[k].temp4}</td>`;
                        tbodyOutputData += "</tr>";
                    }
                    let tableOutput = `
                    <table>
                        <thead>
                            <tr>
                                <th>Device Name</th>
                                <th>Record Date</th>
                                <th>Temp1</th>
                                <th>Temp2</th>
                                <th>Temp3</th>
                                <th>Temp4</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${tbodyOutputData}
                        </tbody>
                    </table>
                    `
                    GeneratePDF(title, fromDate, fromTime, toDate, toTime, tableOutput)
                }
                if(outputFormat == "csv"){
                    GenerateCSV(title, fromDate, fromTime, toDate, toTime, totalOutputData)
                }
                document.getElementById('loadingScreen').style.display = "none";
            });
        });

        function GenerateHTML(title, fromDate, fromTime, toDate, toTime, tableOutput){
            const htmlString = `
            <html>
                <head>
                    <title>${title}</title>
                </head>
                <body>
                    <h1>${title}</h1>
                    <p>${fromDate}${fromTime}-${toDate}${toTime}</p>
                    ${tableOutput}
                </body>
            </html>
            `;
            
            // Convert the HTML string to a Blob
            const htmlBlob = new Blob([htmlString], {type: 'text/html'});
            // Create a URL for the Blob
            const url = URL.createObjectURL(htmlBlob);
            // Create a link element to download the HTML file
            const link = document.createElement('a');
            link.href = url;
            link.download = `${title}${fromDate}${fromTime}-${toDate}${toTime}.html`;
            // Append the link to the document
            document.body.appendChild(link);
            // Click the link to download the file
            link.click();
            // Clean up the URL object
            URL.revokeObjectURL(url);
        }
        function GenerateXML(title, fromDate, fromTime, toDate, toTime, xmlOutput){
            const xmlVersion = <?php echo json_encode('<?xml version="1.0" encoding="UTF-8"?>'); ?>;
            const xmlString = `${xmlVersion}
            ${xmlOutput}
            `;
            // Convert the XML string to a Blob
            const blob = new Blob([xmlString], { type: 'text/xml' });
            // Create a URL for the Blob
            const url = URL.createObjectURL(blob);
            // Create a link element to download the HTML file
            const link = document.createElement('a');
            link.href = url;
            link.download = `${title}${fromDate}${fromTime}-${toDate}${toTime}.xml`;
            // Append the link to the document
            document.body.appendChild(link);
            // Click the link to download the file
            link.click();
            // Clean up the URL object
            URL.revokeObjectURL(url);
        }
        function GeneratePDF(title, fromDate, fromTime, toDate, toTime, htmlOutput){
            var opt = {
                margin: 1,
                filename: `${title}${fromDate}${fromTime}-${toDate}${toTime}.pdf`,
                image: {
                type: 'jpeg',
                quality: 0.98
                },
                html2canvas: {
                scale: 2
                },
                jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
                }
            };
            // Convert the HTML to PDF using the html2pdf library
            html2pdf().set(opt).from(htmlOutput).save();
        }
        function GenerateCSV(title, fromDate, fromTime, toDate, toTime, data){
            const titleKeys = Object.keys(data[0]);
            const refinedData = [];
            refinedData.push(titleKeys);
            console.log(data)
            data.forEach(item => {
                refinedData.push(Object.values(item));
            })
            let csvContent = ''
            refinedData.forEach(row => {
            csvContent += row.join(',') + '\n'
            })
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8,' })
            const objUrl = URL.createObjectURL(blob)
            const link = document.createElement('a')
            link.href = objUrl;
            link.download = `${title}${fromDate}${fromTime}-${toDate}${toTime}.csv`;
            // Append the link to the document
            document.body.appendChild(link);
            // Click the link to download the file
            link.click();
            // Clean up the URL object
            URL.revokeObjectURL(objUrl);
        }
        </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/argon-dashboard.js"></script>
    <?php echo $__env->yieldPushContent('js'); ?>;
</body>

</html>
<?php /**PATH F:\Laravel\Laravel-GPS-Tracking-Dashboard\resources\views/layouts/app.blade.php ENDPATH**/ ?>