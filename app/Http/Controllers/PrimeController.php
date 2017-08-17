<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrimeController extends Controller
{
    public function execute() {
        $url = "https://graph.facebook.com/v2.10/me?fields=id%2Cname%2Cposts%7Blikes%2Cfull_picture%2Csharedposts%2Ccreated_time%2Cmessage%2Clink%7D&access_token=" . session('access_token') . "";
        $headers = array("Content-type: application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $st = curl_exec($ch);


        $result = json_decode($st, TRUE);
        dd($result);
        $posts = array_slice($result['posts']['data'],0,5);

        return view('page',['data' => $posts]);
    }
}
