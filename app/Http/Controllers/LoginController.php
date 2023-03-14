<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        try{
            $client = new Client(['timeout' => 180]);
            $response = $client->post('http://104.131.12.58/api/login', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                ],
            ]);
            $responseData = json_decode($response->getBody()->getContents(), true);
            //User have to status = 1 and have to have permission to view reports
            if($responseData["status"]==1 && $responseData["permissions"]["reports"]["view"] == true ){
                Auth::attempt(['email' => "admin@argon.com", 'password' => "secret"]);
                session(['user_api_hash' => $responseData["user_api_hash"]]);
                return redirect()->intended('usermanagement');
            }
            else{
                return back()->withErrors([
                    'permission' => "You don't have permission to access to this service",
                ]);
            }
        }
        catch(ClientException $e)
        {
            if ($e->getResponse()->getStatusCode() === 401) {
                // handle the 401 Unauthorized response here
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            } else {
                // handle other 4xx errors here
                return view('error')->with('message', 'An error occurred while processing your request');
            }
            
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
