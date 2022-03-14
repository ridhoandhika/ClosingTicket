<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;

use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index(){
        return view('Check.index');
    }

    public function createTask(Request $request){
      
        $remote_addr = $_SERVER['REMOTE_ADDR'];
        $output = array(
			'success' => false
		);

        // $request->nd
        // var_dump($request);
        //$nd = $request->ndnumber .='@telkom.net';
        $uid = time().'.'.sha1(rand(111111,999999));
        DB::table('task_active')->insert([
            'uid' => $uid,
            'ticket' => $request->ticket,
            'nd_number' => $request->nd,
            'nd' => $request->nd
        ]);

       
        if($uid != null || $uid !=''){
            $output['success'] = true;
            $output['data'] = array(
            'uid' => $uid,
            'ticket' => $request->ticket,
            'remote' => $remote_addr,
            'nd' => $request->nd
            );
        } else{
            $output = array(
                'success' => false
            );
        }
        // $uid->withCookie(cookie($uid));

        echo json_encode($output);


    }

    public function retrieveToken(Request $request){
        $output = array(
			'success' => false
		);

       
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://apigw.telkom.co.id:7777/invoke/pub.apigateway.oauth2/getAccessToken', [
            'grant_type' => 'client_credentials',
            'client_id' => '916a4ea5-e308-4662-a387-7c7735799c16',
            'client_secret' => '73f1cf21-acc7-4aeb-9f27-143d49f32f66'
        ]);

        $tLog = time().'.'.rand(111111, 999999);
        Storage::put($tLog.'.txt', $response);
      

        DB::table('task_active')
            ->where('uid', $request->uid)
            ->update(['bearer' => $response['access_token']]);
        if($response['access_token'] != null){
            $output = array(
                'success' => true
            );
        }
        
        echo json_encode($output);

        
    }

    public function saveMyIP(Request $request){
        $output = array(
			'success' => false
		);


        $data = DB::table('task_active')
        ->select('nd','ticket')
        ->where('uid', $request->uid)
        ->first();


        DB::table('task_active')
        ->where('uid', $request->uid)
        ->update(['ip_addr' => $request->ip_addr]);
        
        $output = array(
			'success' => true,
            'ticket' => $data->ticket,
            'nd' => $data->nd
		);
        echo json_encode($output);
    }

    public function retrieveNDByIP(Request $request){
        $output = array(
			'success' => false
		);
        $data = DB::table('task_active')
        ->select('ip_addr','bearer','ticket')
        ->where('uid', $request->uid)
        ->first();

       
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$data->bearer.''
        ])->get('https://apigw.telkom.co.id:7777/gateway/telkom-radius-ip/1.0/getNDByIP?ip='.$data->ip_addr.'');
         $tLog = time().'.'.rand(111111, 999999);
        Storage::put($tLog.'.txt', $response);
    
        $nd = json_decode($response, true);
        $nd_number = $nd['data']['ND'];
        $nde = $nd['data']['ND'] .='@telkom.net';
        
        $task = DB::table('task_active')
        ->where('uid', $request->uid)
        ->update(['nd' => $nde, 'nd_number'=> $nd_number]);

        if($task > 0){
            $output['success'] = true;
            $output = array(
                   
                    'nd' =>  $nde,
                    'ticket' => $data->ticket
                    );
        }else{
            $output['error'] = 'error';
        }
       
        echo json_encode($output);
    }
    public function retrieveIPByND(Request $request){
        $output = array(
			'success' => false
		);
        $data = DB::table('task_active')
        ->select('nd_number','bearer')
        ->where('uid', $request->uid)
        ->first();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$data->bearer.''
        ])->post('https://apigw.telkom.co.id:7777/gateway/telkom-radius/1.0/getUsageOnline', [
            'username' => $data->nd_number,
            'realm' => 'telkom.net'
        ]);
        $tLog = time().'.'.rand(111111, 999999);
        Storage::put($tLog.'.txt', $response);


       $online = json_decode($response, true);
       $framed_ip_addr = $online['output']['Framed-IP-Address'];

       $output = array(
        'frame_ip' =>  $framed_ip_addr
        );
        $task = DB::table('task_active')
        ->where('uid', $request->uid)
        ->update(['framed_ip_address' => $framed_ip_addr]);

        echo json_encode($output); 
    }

    public function retrieveUkur(Request $request){
        $output = array(
			'success' => false
		);
        $data = DB::table('task_active')
        ->select('nd_number','bearer')
        ->where('uid', $request->uid)
        ->first();

        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$data->bearer.''
            ])->post('https://apigw.telkom.co.id:7777/gateway/telkom-ibooster-iboosterapi/1.0/iBooster/ukur_indikasi', [
                'input' => [
                    'nd' => $data->nd_number,
                    'realm' => 'telkom.net'
                ]
            ]);

            $tLog = time().'.'.rand(111111, 999999);
            Storage::put($tLog.'.txt', $response);
        
        $ukur = json_decode($response, true);
       
            if($ukur['onu_rx_pwr'] < -24 || $ukur['onu_rx_pwr'] > -13) {
                $passed = 0;
            }else if($ukur['onu_rx_pwr'] > -24 ||$ukur['onu_rx_pwr'] < -13) {
                $passed = 1;
            } else { 
                $passed = null; 
            }  

        $task = DB::table('task_active')
        ->where('uid', $request->uid)
        ->update(['onu_rx_pwr' => $ukur['onu_rx_pwr'], 'redaman_passed' => $passed]);


        $output['success'] = true;
        $output = array(
            'redaman_passed' => $passed
        );

                echo json_encode($output); 
    }

    public function retrievePCRF(Request $request){
        $output = array(
			'success' => false
		);
        $data = DB::table('task_active')
        ->select('nd_number','bearer')
        ->where('uid', $request->uid)
        ->first();

        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$data->bearer.''
            ])->post('https://apigw.telkom.co.id:7777/gateway/telkom-pcrf-usageDetail/1.0/getInfoUsageDetail', [
                'serviceNumber' =>  $data->nd_number
            ]);

            $tLog = time().'.'.rand(111111, 999999);
            Storage::put($tLog.'.txt', $response);
        
        $paket = json_decode($response, true);

        $pakage =  $paket['data']['getInfoUsageResponse']['package'];
        $quota_used =  $paket['data']['getInfoUsageResponse']['usage'];

        $task = DB::table('task_active')
        ->where('uid', $request->uid)
        ->update(['package_name' => $pakage, 'quota_used'=> $quota_used]);
        
        $output['success'] = true;
        $output = array(
                'paket' => $paket['data']['getInfoUsageResponse']['package']
                );

        echo json_encode($output); 

    }

    public function retrieveSpeed(Request $request){
        // dd( DB::select("select fn_varbintohexsubstring ( 1, '$password', 1, 0 ) AS result") );
     
 
        $payload = json_decode(file_get_contents('php://input'), true);
        
        $v01speedtest_download = $payload['data']['download'];
        $v01speedtest_upload =  $payload['data']['upload'];
        $v01speedtest_units =  $payload['data']['units'];
        $uid = $payload['uid'];
        $data = DB::table('task_active')
        ->select('nd','package_name','quota_used')
        ->where('uid', $uid)
        ->first();
       
        $speed = round($v01speedtest_download / 1.024) / 1000;
        $passed = DB::select("select speed_requirement ( '$data->package_name', '$data->quota_used',  $speed) AS result");
        
        $resultArray =  (array) $passed;
        // dd();
        // $object = array_shift($passed);
        // $result = json_decode($passed, true);
        // $obj = json_decode($passed);
        // $txt = $result['result']; // text
        
        // print_r($passed->[0]->result);
        $task = DB::table('task_active')
        ->where('uid',$uid)
        ->update([
            'speed_passed' => $resultArray[0]->result,//$passed['result'],
            'speedtest_download'=> $v01speedtest_download,
            'speedtest_upload'=>$v01speedtest_upload,
            'units' => $v01speedtest_units
        ]);

        $output = array(
            'speed_passed' => $resultArray[0]->result,//$passed['result'],
            'download'=> $v01speedtest_download
        );

        echo json_encode($output); 
    }

    public function retrieveCloseAuto(Request $request){
        $data = DB::table('task_active')
        ->select('redaman_passed','speed_passed')
        ->where('uid', $request->uid)
        ->first();

        if($data->redaman_passed == null || $data->speed_passed == null ){
            $passed = null;
        }else if($data->redaman_passed== 1 && $data->speed_passed  == 1){
            $passed = 1;
        } 
        else{
            $passed = 0;
        }

        $task = DB::table('task_active')
        ->where('uid', $request->uid)
        ->update(['close' => $passed]);

        $output = array(
            'close' => $passed
            );
        echo json_encode($output); 
    }
}
