<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\CursorPaginator;

class DashboardController extends Controller
{
    public function index(){
        return view('Admin.dashboard');
    }

    public function load_task(){
        $output = array(
			'success' => false
		);
        $data = DB::table('task_mart')
        ->whereBetween('tick',['2022-03-23 00:00:00' , '2022-03-23 23:59:59'])
        ->orderBy('id')->cursorPaginate(23);
        $list = array();

        foreach($data as $r01) {
            $date = substr($r01->tick, 0, 10);
            $time = substr($r01->tick, 11, 8);

            $list[$date][$time] = array(
                'tick' => $r01->tick,
                'whitelist' => $r01->whitelist,
                'blacklist' => $r01->blacklist,
                'token_1_success' => $r01->token_1_success,
                'token_1_failed' => $r01->token_1_failed,
                'nd_success_nossa' => $r01->nd_success_nossa,
                'nd_failed_nossa' => $r01->nd_failed_nossa,
                'nd_success_sonic' => $r01->nd_success_sonic,
                'nd_failed_sonic' => $r01->nd_failed_sonic,
                'ip_success' => $r01->ip_success,
                'ip_failed' => $r01->ip_failed,
                'validasi_success_passed_1' => $r01->validasi_success_passed_1,
                'validasi_success_passed_0' => $r01->validasi_success_passed_0,
                'validasi_failed' => $r01->validasi_failed,
                'redaman_success_spec' => $r01->redaman_success_spec,
                'redaman_success_unspec' => $r01->redaman_success_unspec,
                'redaman_failed' => $r01->redaman_failed,
                'pcrf_success' => $r01->pcrf_success,
                'pcrf_failed' => $r01->pcrf_failed,
                'speedtest_success_passed_1' => $r01->speedtest_success_passed_1,
                'speedtest_success_passed_0' => $r01->speedtest_success_passed_0,
                'speedtest_failed' => $r01->speedtest_failed,
                'close_1' => $r01->close_1,
                'close_0' => $r01->close_0
            );
            
        }
        $output['success'] = true;
				$output['data'] = array(
                'list' => $list,
					// 'chart' => $chart
				);
        echo json_encode($output);

    }

    public function jSearchTicket(Request $request ){
      
        $data = DB::table('task_archive')
        ->select('ts','ticket','nd','bearer', 'framed_ip_address','ip_addr','ip_passed','onu_rx_pwr','redaman_passed','package_name','quota_used','speedtest_download','speedtest_upload','speed_passed','close','uid')
        ->where('ticket','=', $request->ticket)
        ->orderBy('id')->get();
        $output['success'] = true;
        $output['data'] = array(
            'detail' => $data
        );
       
        echo json_encode($output);
        // var_dump($v0ticket);

    }
}
