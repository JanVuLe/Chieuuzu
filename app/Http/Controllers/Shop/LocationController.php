<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LocationController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://provinces.open-api.vn/api/']);
    }

    // Lấy danh sách tỉnh/thành phố
    public function getProvinces()
    {
        $response = $this->client->get('p/');
        $provinces = json_decode($response->getBody(), true);
        return response()->json($provinces);
    }

    // Lấy danh sách quận/huyện theo tỉnh
    public function getDistricts(Request $request)
    {
        $provinceCode = $request->query('province_code');
        $response = $this->client->get("d/?province_code={$provinceCode}");
        $districts = json_decode($response->getBody(), true);
        return response()->json($districts);
    }

    // Lấy danh sách phường/xã theo quận/huyện
    public function getWards(Request $request)
    {
        $districtCode = $request->query('district_code');
        $response = $this->client->get("w/?district_code={$districtCode}");
        $wards = json_decode($response->getBody(), true);
        return response()->json($wards);
    }
}
