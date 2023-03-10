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
        $response = Http::get("104.131.12.58/api/get_devices?user_api_hash=".session('user_api_hash'));
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        return view("pages.green-driving", compact('devices'));
    }
    public function performance()
    {
        $response = Http::get('104.131.12.58/api/get_devices?user_api_hash='.session('user_api_hash'));
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        return view("pages.performance", compact('devices'));
    }
    public function temperature()
    {
        $response = Http::get('104.131.12.58/api/get_devices?user_api_hash='.session('user_api_hash'));
        $jsonData = $response->json();
        $devices = $jsonData[0]['items'];
        return view("pages.temperature", compact('devices'));
    }
}
