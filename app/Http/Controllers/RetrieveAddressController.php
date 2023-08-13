<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\JsonDecoder;

class RetrieveAddressController extends Controller
{
    public function retrieveAddress(Request $request)
    {
        $postcode = array('zipcode' => $request->postcode);
        $url = 'https://zipcloud.ibsnet.co.jp/api/search?' . http_build_query($postcode);

        $response = file_get_contents($url);
        $data = json_decode($response);

        if($data->status == 400) {
            return response()->json([
                'message' => "入力された郵便番号が、間違っています。",
            ], 400);
        };

        if($data->status == 500) {
            return response()->json([
                'message' => "現在使用することが出来ません。",
            ], 500);
            // Logを作成する
        }

        $address = [];
        for($i = 1; $i <= 3; $i++) {
            $address[] = $data->results[0]->{'address' . $i};
        };

        return response()->json([
            'address' => implode($address)
        ], 200);
    }


}
