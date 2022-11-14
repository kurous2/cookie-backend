<?php

namespace App\Http\Controllers;

use App\Community;
use App\Report;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UsignController extends Controller
{
    public function getToken(){
        $url = 'https://api.usign.kr:18443/PDFsign/auth/createToken';
        $headers = ["Authorization: Bearer ". env('USIGN_TOKEN')];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $resp = curl_exec($ch);

        if(curl_error($ch)){
            return response()->json([
                'error' => curl_error($ch)
            ]);
        } else {
            $decoded = json_decode($resp);
            return $decoded->token;
        }
        curl_close($ch);
    }

    public function signDocument($id){
        try {
            $report = Report::findOrFail($id);
            $community = Community::findOrFail($report->community_id);
            $signList = [array(
                'signType' => 'Digital',
                'signOption' => 'Stamp',
                'signPage' => '1',
                'stampX' => '10',
                'stampY' => '20',
            )];
            $imageList = [array(
                'type' => 'URL',
                'path' => $community->stamp,
                'x' => '100',
                'y' => '20',
                'width' => '400',
                'height' => '268',
                'page' => '1'
            )];
        
            $url = 'https://api.usign.kr:18443/PDFsign/sign';
            $headers = ['Content-Type: text/plain'];
            $data = [
                'apiKey' => env('USIGN_TOKEN'),
                'token' => $this->getToken(),
                'fileType' => 'URL',
                'filePath' => $report->docs,
                'isLtv' => 'N',
                'signList' => $signList,
                'imageList' => $imageList
            ];

            $ch = curl_init();   
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            
            $resp = curl_exec($ch);
    
            if(curl_error($ch)){
                return response()->json([
                    'error' => curl_error($ch)
                ]);
            } else {
                $decoded = json_decode($resp);
                return response()->json([$decoded],200);
            }
            curl_close($ch);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found',
                'description' => 'Report ' . $id . ' not found.'
            ], 404);
        }
    }
}
