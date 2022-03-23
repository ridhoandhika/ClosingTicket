$(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
		}
	});
    loadOverviewList();

	$('#ticket-search-submit').click(function(e) {
		e.preventDefault();
		$('#ticket-search-result tbody').empty();
	
		if($('#ticket-search-ticket').val()){
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: '/Search',
			data: {
				'ticket': $('#ticket-search-ticket').val()
			},
			success: function(response) {
				if(typeof response['success'] != 'undefined' && response['success'] && typeof response['data'] != 'undefined' && typeof response['data']['detail'] != 'undefined') {
					i = 0;
					$.each(response['data']['detail'], function(a, b) {
						i++;
						$('#ticket-search-result tbody').append(
							'<tr>' +
								'<td>' + i + '</td>' +					
								
								'<td>' + b['ts'] + '</td>' +
								'<td>' + b['ticket'] + '</td>' +
								'<td>' + b['nd'] + '</td>' +
								'<td>' + b['ip_passed'] + '</td>' +
								'<td>' + b['close'] + '</td>' +
								'<td>' + b['onu_rx_pwr'] + '</td>' +
								'<td>' + b['redaman_passed'] + '</td>' +
								'<td>' + b['speedtest_download'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_upload'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speed_passed'] + '</td>' +
								'<td>' + b['package_name'] + '</td>' +
								'<td>' + b['quota_used'] + '</td>' +
								'<td>' + b['ip_addr'] + '</td>' +
								'<td>' + b['f_ip_address'] + '</td>'+
								'<td>' + b['uid'] + '</td>' +
							'</tr>'
						);
					});
					$('#modal-ticket-search').modal('show');
				}
			}
		});
	}
});
		
});
function loadOverviewList() {	
	$('#list-overview-1 tbody').empty();
	$('#list-overview-2 tbody').empty();
	// config01.data.datasets[0].data[0] = 0;
	// config01.data.datasets[0].data[1] = 0;
	// config02.data.datasets[0].data[0] = 0;
	// config02.data.datasets[0].data[1] = 0
	// config03.data.datasets[0].data[0] = 0;
	// config03.data.datasets[0].data[1] = 0;
	$.ajax({
		method: 'get',
		dataType: 'json',
		url: '/Load_task',
		data: {
			// 'filter-start': $('#selected-start').val(),
			// 'filter-finish': $('#selected-finish').val()
		},
		success: function(response) {
			if(
				typeof response['success'] != 'undefined' 
				&& response['success'] 
				// && typeof response['data'] != 'undefined' 
				// && typeof response['data']['list'] != 'undefined'
				// && typeof response['data']['chart'] != 'undefined'
				// && typeof response['data']['chart']['01'] != 'undefined'
				// && typeof response['data']['chart']['02'] != 'undefined'
				// && typeof response['data']['chart']['03'] != 'undefined'
			) {
					
				// config01.data.datasets[0].data[0] = response['data']['chart']['01']['close'];
				// config01.data.datasets[0].data[1] = response['data']['chart']['01']['reopen'];
				// config02.data.datasets[0].data[0] = response['data']['chart']['02']['success_redaman'];
				// config02.data.datasets[0].data[1] = response['data']['chart']['02']['fail_redaman'];
				// config03.data.datasets[0].data[0] = response['data']['chart']['03']['success_speedtest'];
				// config03.data.datasets[0].data[1] = response['data']['chart']['03']['fail_speedtest'];
				let total = {
					// whitelist: 0,
					// blacklist: 0,
					token_1_success: 0,
					token_1_failed: 0,
					nd_success_nossa: 0,
					nd_failed_nossa: 0,
					nd_success_sonic: 0,
					nd_failed_sonic: 0,
					ip_success: 0,
					ip_failed: 0,
					validasi_success_passed_1: 0,
					validasi_success_passed_0: 0,
					validasi_failed: 0,
					redaman_success_spec: 0,
					redaman_success_unspec: 0,
					redaman_failed: 0,
					pcrf_success: 0,
					pcrf_failed: 0,
					speedtest_success_passed_1: 0,
					speedtest_success_passed_0: 0,
					speedtest_failed: 0,
					close_1: 0,
					close_0: 0
				};
				$.each(response['data']['list'], function(a, b) {
					bInc = 0;
					let dateTotal = {
						// whitelist: 0,
						// blacklist: 0,
						token_1_success: 0,
						token_1_failed: 0,
						nd_success_nossa: 0,
						nd_failed_nossa: 0,
						nd_success_sonic: 0,
						nd_failed_sonic: 0,
						ip_success: 0,
						ip_failed: 0,
						validasi_success_passed_1: 0,
						validasi_success_passed_0: 0,
						validasi_failed: 0,
						redaman_success_spec: 0,
						redaman_success_unspec: 0,
						redaman_failed: 0,
						pcrf_success: 0,
						pcrf_failed: 0,
						speedtest_success_passed_1: 0,
						speedtest_success_passed_0: 0,
						speedtest_failed: 0,
						close_1: 0,
						close_0: 0
					}
					$.each(b, function(c, d) {
						var htmlRowHour = '<tr>';
						if(bInc  == 0) {
							var splitDateLabel = a.split('-');
							htmlRowHour += '<td rowspan="24" class="rotate-date"><div class="rotate-out"><div class="rotate-in">' + splitDateLabel[0] + ' - ' + splitDateLabel[1] + ' - ' + splitDateLabel[2] + '</div></div></td>';
						}
						
						htmlRowHour += '<td>' + c + '</td>';
						// htmlRowHour += '<td class="n">' + d['whitelist'] + '</td>';
						// htmlRowHour += '<td class="n">' + d['blacklist'] + '</td>';
						
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="token_1_success">' + d['token_1_success'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="token_1_failed">' + d['token_1_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="nd_success_nossa">' + d['nd_success_nossa'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="nd_failed_nossa">' + d['nd_failed_nossa'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="nd_success_sonic">' + d['nd_success_sonic'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="nd_failed_sonic">' + d['nd_failed_sonic'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="ip_success">' + d['ip_success'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="ip_failed">' + d['ip_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="validasi_success_passed_1">' + d['validasi_success_passed_1'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="validasi_success_passed_0">' + d['validasi_success_passed_0'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="validasi_failed">' + d['validasi_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="redaman_success_spec">' + d['redaman_success_spec'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="redaman_success_unspec">' + d['redaman_success_unspec'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="redaman_failed">' + d['redaman_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="pcrf_success">' + d['pcrf_success'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="pcrf_failed">' + d['pcrf_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="speedtest_success_passed_1">' + d['speedtest_success_passed_1'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="speedtest_success_passed_0">' + d['speedtest_success_passed_0'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="speedtest_failed">' + d['speedtest_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="close_1">' + d['close_1'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="close_0">' + d['close_0'] + '</a></td>';
						$('#list-overview-1 tbody').append(htmlRowHour);
						
						// dateTotal['whitelist'] += Number(d['whitelist']);
						// dateTotal['blacklist'] += Number(d['blacklist']);
						dateTotal['token_1_success'] += Number(d['token_1_success']);
						dateTotal['token_1_failed'] += Number(d['token_1_failed']);
						dateTotal['nd_success_nossa'] += Number(d['nd_success_nossa']);
						dateTotal['nd_failed_nossa'] += Number(d['nd_failed_nossa']);
						dateTotal['nd_success_sonic'] += Number(d['nd_success_sonic']);
						dateTotal['nd_failed_sonic'] += Number(d['nd_failed_sonic']);
						dateTotal['ip_success'] += Number(d['ip_success']);
						dateTotal['ip_failed'] += Number(d['ip_failed']);
						dateTotal['validasi_success_passed_1'] += Number(d['validasi_success_passed_1']);
						dateTotal['validasi_success_passed_0'] += Number(d['validasi_success_passed_0']);
						dateTotal['validasi_failed'] += Number(d['validasi_failed']);
						dateTotal['redaman_success_spec'] += Number(d['redaman_success_spec']);
						dateTotal['redaman_success_unspec'] += Number(d['redaman_success_unspec']);
						dateTotal['redaman_failed'] += Number(d['redaman_failed']);
						dateTotal['pcrf_success'] += Number(d['pcrf_success']);
						dateTotal['pcrf_failed'] += Number(d['pcrf_failed']);
						dateTotal['speedtest_success_passed_1'] += Number(d['speedtest_success_passed_1']);
						dateTotal['speedtest_success_passed_0'] += Number(d['speedtest_success_passed_0']);
						dateTotal['speedtest_failed'] += Number(d['speedtest_failed']);
						dateTotal['close_1'] += Number(d['close_1']);
						dateTotal['close_0'] += Number(d['close_0']);
						
						// total['whitelist'] += Number(d['whitelist']);
						// total['blacklist'] += Number(d['blacklist']);
						total['nd_success_nossa'] += Number(d['nd_success_nossa']);
						total['nd_failed_nossa'] += Number(d['nd_failed_nossa']);
						total['nd_success_sonic'] += Number(d['nd_success_sonic']);
						total['nd_failed_sonic'] += Number(d['nd_failed_sonic']);
						total['token_1_success'] += Number(d['token_1_success']);
						total['token_1_failed'] += Number(d['token_1_failed']);
						total['ip_success'] += Number(d['ip_success']);
						total['ip_failed'] += Number(d['ip_failed']);
						total['validasi_success_passed_1'] += Number(d['validasi_success_passed_1']);
						total['validasi_success_passed_0'] += Number(d['validasi_success_passed_0']);
						total['validasi_failed'] += Number(d['validasi_failed']);
						total['redaman_success_spec'] += Number(d['redaman_success_spec']);
						total['redaman_success_unspec'] += Number(d['redaman_success_unspec']);
						total['redaman_failed'] += Number(d['redaman_failed']);
						total['pcrf_success'] += Number(d['pcrf_success']);
						total['pcrf_failed'] += Number(d['pcrf_failed']);
						total['speedtest_success_passed_1'] += Number(d['speedtest_success_passed_1']);
						total['speedtest_success_passed_0'] += Number(d['speedtest_success_passed_0']);
						total['speedtest_failed'] += Number(d['speedtest_failed']);
						total['close_1'] += Number(d['close_1']);
						total['close_0'] += Number(d['close_0']);
						bInc++;
					});
					
					htmlRowDate = '';
					htmlRowDate += '<td colspan="2">' + a + '</td>';
					htmlRowDate += '<td class="n">' + dateTotal['whitelist'] + '</td>';
					htmlRowDate += '<td class="n">' + dateTotal['blacklist'] + '</td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="token_1_success">' + dateTotal['token_1_success'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="token_1_failed">' + dateTotal['token_1_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="nd_success_nossa">' + dateTotal['nd_success_nossa'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="nd_failed_nossa">' + dateTotal['nd_failed_nossa'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="nd_success_sonic">' + dateTotal['nd_success_sonic'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="nd_failed_sonic">' + dateTotal['nd_failed_sonic'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="ip_success">' + dateTotal['ip_success'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="ip_failed">' + dateTotal['ip_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="validasi_success_passed_1">' + dateTotal['validasi_success_passed_1'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="validasi_success_passed_0">' + dateTotal['validasi_success_passed_0'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="validasi_failed">' + dateTotal['validasi_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="redaman_success_spec">' + dateTotal['redaman_success_spec'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="redaman_success_unspec">' + dateTotal['redaman_success_unspec'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="redaman_failed">' + dateTotal['redaman_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="pcrf_success">' + dateTotal['pcrf_success'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="pcrf_failed">' + dateTotal['pcrf_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="speedtest_success_passed_1">' + dateTotal['speedtest_success_passed_1'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="speedtest_success_passed_0">' + dateTotal['speedtest_success_passed_0'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="speedtest_failed">' + dateTotal['speedtest_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="close_1">' + dateTotal['close_1'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="close_0">' + dateTotal['close_0'] + '</a></td>';
					htmlRowDate = '<tr>'+htmlRowDate+'</tr>';
					$('#list-overview-2 tbody').append(htmlRowDate);
					
				});
				$('.foot-whitelist').html(total['whitelist']);
				$('.foot-blacklist').html(total['blacklist']);
				$('.foot-token_1_success').html(total['token_1_success']);
				$('.foot-token_1_failed').html(total['token_1_failed']);
				$('.foot-nd_success_nossa').html(total['nd_success_nossa']);
				$('.foot-nd_failed_nossa').html(total['nd_failed_nossa']);
				$('.foot-nd_success_sonic').html(total['nd_success_sonic']);
				$('.foot-nd_failed_sonic').html(total['nd_failed_sonic']);
				$('.foot-ip_success').html(total['ip_success']);
				$('.foot-ip_failed').html(total['ip_failed']);
				$('.foot-validasi_success_passed_1').html(total['validasi_success_passed_1']);
				$('.foot-validasi_success_passed_0').html(total['validasi_success_passed_0']);
				$('.foot-validasi_failed').html(total['validasi_failed']);
				$('.foot-redaman_success_spec').html(total['redaman_success_spec']);
				$('.foot-redaman_success_unspec').html(total['redaman_success_unspec']);
				$('.foot-redaman_failed').html(total['redaman_failed']);
				$('.foot-pcrf_success').html(total['pcrf_success']);
				$('.foot-pcrf_failed').html(total['pcrf_failed']);
				$('.foot-speedtest_success_passed_1').html(total['speedtest_success_passed_1']);
				$('.foot-speedtest_success_passed_0').html(total['speedtest_success_passed_0']);
				$('.foot-speedtest_failed').html(total['speedtest_failed']);
				$('.foot-close_1').html(total['close_1']);
				$('.foot-close_0').html(total['close_0']);
			}
		}
	});
}