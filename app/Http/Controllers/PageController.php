<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);
    }

    public function vr()
    {
        return view("pages.virtual-reality");
    }

    public function profile()
    {
        return view("pages.profile-static");
    }

    public function signin()
    {
        return view("pages.sign-in-static");
    }

    public function signup()
    {
        return view("pages.sign-up-static");
    }
    public function greendriving()
    {
        $response = Http::get('104.131.12.58/api/get_devices?user_api_hash=$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O');
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        // dd($devices);
        return view("pages.green-driving", compact('devices'));
    }
    public function greendrivingReportGenerate(Request $request)
    {
        //input data
        $user_api_hash_value = '$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O';
        $encodedArray = $request->input('device_type');
        $devicesData = [];
        foreach($encodedArray as $serialized){
            $devicesData[] = unserialize(base64_decode($serialized));
        }
        // dd($devicesData);
        $fromDate = $request->input('periodDateFrom');
        $fromTime = $request->input('periodTimeFrom');
        $toDate = $request->input('periodDateTo');
        $toTime = $request->input('periodTimeTo');

        //output data
        $totalOutputData = [];
        foreach($devicesData as $dData){
            $totalDistance = 0;
            $totalMaxAcceleration = 0;
            $totalMaxBraking = 0;
            $totalMaxCornering = 0;
            $HistoryapiURL = "104.131.12.58/api/get_history?user_api_hash=".$user_api_hash_value."&device_id=".$dData["deviceID"]."&from_date=".$fromDate."&from_time=".$fromTime."&to_date=".$toDate."&to_time=".$toTime;
            $HistoryResponse = Http::timeout(180)->get($HistoryapiURL);
            $HistoryJsonData = $HistoryResponse->json();
            $totalDistance = $HistoryJsonData["distance_sum"];
            $apiURL = "104.131.12.58/api/get_events?user_api_hash=".$user_api_hash_value."&device_id=".$dData["deviceID"]."&date_from=".$fromDate."&date_to=".$toDate;
            $response = Http::timeout(180)->get($apiURL);
            $jsonData = $response->json();
            $total_page = $jsonData["items"]["last_page"];
            for($i = 1; $i <= $total_page; $i++){
                $EventApiURL = "104.131.12.58/api/get_events?page=".$i."&user_api_hash=".$user_api_hash_value."&device_id=".$dData["deviceID"]."&date_from=".$fromDate."&date_to=".$toDate;
                $EventResponse = Http::timeout(180)->get($EventApiURL);
                $EventJsonData = $EventResponse->json();
                $Events = $EventJsonData["items"]["data"];
                foreach($Events as $event){
                    if(strtolower($event["message"])== "maxacceleration")
                        $totalMaxAcceleration++;
                    if(strtolower($event["message"])== "maxbraking")
                        $totalMaxBraking++;
                    if(strtolower($event["message"])== "maxcornering")
                        $totalMaxCornering++;
                }
            }
            // $deviceHistory = $jsonData['items'];
            // foreach($deviceHistory as $HistoryItem){
            //     if(isset($HistoryItem["message"]))
            //     {
            //         if(strtolower($HistoryItem["message"])== "maxacceleration")
            //             $totalMaxAcceleration++;
            //         if(strtolower($HistoryItem["message"])== "maxbraking")
            //             $totalMaxBraking++;
            //     }
            //     $totalDistance += $HistoryItem["distance"];
            //     $HistoryItems = $HistoryItem["items"];
            //     foreach($HistoryItems as $HistoryItemsPart){
            //         $mainData = simplexml_load_string($HistoryItemsPart["other"]);
            //     }
            // }
            $eachDeviceData = [
                'deviceID' => $dData["deviceID"],
                'driverName' => $dData["driverName"],
                'deviceName' => $dData["deviceName"],
                'totalDistance' => $totalDistance,
                'totalMaxAcceleration' => $totalMaxAcceleration,
                'totalMaxBraking' => $totalMaxBraking,
                'totalMaxCornering' => $totalMaxCornering
            ];
            array_push($totalOutputData, $eachDeviceData);
        }
        // dd($totalOutputData);
        return view("pages.green_driving_result", compact('totalOutputData'));
    }
    public function performance()
    {
        $response = Http::get('104.131.12.58/api/get_devices?user_api_hash=$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O');
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        return view("pages.performance", compact('devices'));
    }
    public function performanceReportGenerate(Request $request)
    {
        //input data
        $user_api_hash_value = '$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O';
        $encodedArray = $request->input('device_type');
        $devicesData = [];
        foreach($encodedArray as $serialized){
            $devicesData[] = unserialize(base64_decode($serialized));
        }
        // dd($devicesData);
        $fromDate = $request->input('periodDateFrom');
        $fromTime = $request->input('periodTimeFrom');
        $toDate = $request->input('periodDateTo');
        $toTime = $request->input('periodTimeTo');
        $gallonPrice = $request->input('gallonPrice');

        //output data
        $totalOutputData = [];
        foreach($devicesData as $dData){
            $totalDistance = 0;
            $totalFuelUsed = 0;
            $unitPerformance = 0;
            $kilometerCost = 0;
            $totalRouteCost = 0;
            $HistoryapiURL = "104.131.12.58/api/get_history?user_api_hash=".$user_api_hash_value."&device_id=".$dData["deviceID"]."&from_date=".$fromDate."&from_time=".$fromTime."&to_date=".$toDate."&to_time=".$toTime;
            $HistoryResponse = Http::timeout(180)->get($HistoryapiURL);
            $HistoryJsonData = $HistoryResponse->json();
            $totalDistance = $HistoryJsonData["distance_sum"];
            $HistoryRecordItems = $HistoryJsonData["items"];
            $lastRecordXML = simplexml_load_string($HistoryRecordItems[0]['items'][0]['other']);
            if (property_exists($lastRecordXML, 'fuelused')){
                $lastFuelRecord = (int) $lastRecordXML->fuelused;
                $initRecord = end($HistoryRecordItems);
                $initRecordXML = simplexml_load_string($initRecord['items'][0]['other']);
                $initFuelRecord = (int) $initRecordXML->fuelused;
                $totalFuelUsed = round(($initFuelRecord - $lastFuelRecord) * 0.264172, 1);
                if($totalFuelUsed == 0){
                    $unitPerformance = "No data";
                    $kilometerCost = "No data";
                    $totalRouteCost = "No data";
                }
                else {
                    $distanceValue = filter_var($totalDistance, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $unitPerformance = round($totalFuelUsed / $distanceValue, 1);
                    $kilometerCost = round($totalFuelUsed * $gallonPrice/ $distanceValue, 1);
                    $totalRouteCost = round($totalFuelUsed * $gallonPrice, 1);
                }
            } else {
                $totalFuelUsed = "No data";
                $unitPerformance = "No data";
                $kilometerCost = "No data";
                $totalRouteCost = "No data";
            }
            $eachDeviceData = [
                'deviceID' => $dData["deviceID"],
                'driverName' => $dData["driverName"],
                'deviceName' => $dData["deviceName"],
                'totalDistance' => $totalDistance,
                'totalFuelUsed' => $totalFuelUsed,
                'unitPerformance' => $unitPerformance,
                'kilometerCost' => $kilometerCost,
                'totalRouteCost' => $totalRouteCost
            ];
            array_push($totalOutputData, $eachDeviceData);
        }
        // dd($totalOutputData);
        return view("pages.performance_result", compact('totalOutputData'));

    }
    public function temperature()
    {
        $response = Http::get('104.131.12.58/api/get_devices?user_api_hash=$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O');
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        return view("pages.temperature", compact('devices'));
    }
    public function temperatureReportGenerate(Request $request){
        //input data
        $user_api_hash_value = '$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O';
        $encodedArray = $request->input('device_type');
        $devicesData = [];
        foreach($encodedArray as $serialized){
            $devicesData[] = unserialize(base64_decode($serialized));
        }
        $fromDate = $request->input('periodDateFrom');
        $fromTime = $request->input('periodTimeFrom');
        $toDate = $request->input('periodDateTo');
        $toTime = $request->input('periodTimeTo');

        //output data
        $totalOutputData = [];
        foreach($devicesData as $dData){
            $HistoryapiURL = "104.131.12.58/api/get_history?user_api_hash=".$user_api_hash_value."&device_id=".$dData["deviceID"]."&from_date=".$fromDate."&from_time=".$fromTime."&to_date=".$toDate."&to_time=".$toTime;
            $HistoryResponse = Http::timeout(180)->get($HistoryapiURL);
            $HistoryJsonData = $HistoryResponse->json();
            $prevTemp1 = $prevTemp2 = $prevTemp3 = $prevTemp4 = 0;
            $curTemp1 = $curTemp2 = $curTemp3 = $curTemp4 = "No data";
            $recordDate = 0;
            $device_name = $HistoryJsonData["device"]["name"];
            foreach($HistoryJsonData["items"] as $HistoryItems){
                foreach($HistoryItems["items"] as $HistoryItem){
                    if(array_key_exists("other", $HistoryItem) && $HistoryItem["other"] != ""){
                        $xml = simplexml_load_string($HistoryItem["other"]);
                        if (property_exists($xml, 'temp1'))
                        $curTemp1 = (float) $xml->temp1;
                        if (property_exists($xml, 'temp5'))
                        $curTemp1 = (float) $xml->temp5;
                        if (property_exists($xml, 'temp2'))
                        $curTemp2 = (float) $xml->temp2;
                        if (property_exists($xml, 'temp6'))
                        $curTemp2 = (float) $xml->temp6;
                        if (property_exists($xml, 'temp3'))
                        $curTemp3 = (float) $xml->temp3;
                        if (property_exists($xml, 'temp7'))
                        $curTemp3 = (float) $xml->temp7;
                        if (property_exists($xml, 'temp4'))
                        $curTemp4 = (float) $xml->temp4;
                        if (property_exists($xml, 'temp8'))
                        $curTemp4 = (float) $xml->temp8;
                        if($prevTemp1 != $curTemp1 || $prevTemp2 != $curTemp2 || $prevTemp3 != $curTemp3 || $prevTemp4 != $curTemp4){
                            $prevTemp1 = $curTemp1;
                            $prevTemp2 = $curTemp2;
                            $prevTemp3 = $curTemp3;
                            $prevTemp4 = $curTemp4;
                            $recordDate = $HistoryItem["raw_time"];
                            $data = [
                                'deviceName' => $device_name,
                                'recordDate' => $recordDate,
                                'temp1' => $prevTemp1,
                                'temp2' => $prevTemp2,
                                'temp3' => $prevTemp3,
                                'temp4' => $prevTemp4,
                            ];
                            array_push($totalOutputData, $data);
                        }
                    }
                }
            }
        }
        // dd($totalOutputData);
        return view("pages.temperature_result", compact('totalOutputData'));
    }
}
