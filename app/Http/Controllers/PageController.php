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
    public function user_management(){
        return view("pages.user-management2");
    }
    public function greendriving()
    {
        $response = Http::get('104.131.12.58/api/get_devices?user_api_hash=$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O');
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        return view("pages.green-driving", compact('devices'));
    }
    public function performance()
    {
        $response = Http::get('104.131.12.58/api/get_devices?user_api_hash=$2y$10$lbsXqkJbyeu6WMfYNBhxa.r6qBLW1WJKBQy10gABW96PcFTlC7Q/O');
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        return view("pages.performance", compact('devices'));
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
            $curTemp1 = $curTemp2 = $curTemp3 = $curTemp4 = "-";
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
