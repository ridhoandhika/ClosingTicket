let flagRedaman = false;
let flagSpeed = false;
let okRedaman = false;
let okSpeed = false;
let loadRedaman;
let loadSpeed;
let timerWait0;
let timerWait1;
let timerWait2;
let timerWait3;
let timerWait4;
let timerWait5;
let timerWait7;


$(function() {
	if(window.addEventListener) {
		window.addEventListener('message', ooklaListener);
	} else if(window.attachEvent) {
		window.attachEvent('onmessage', ooklaListener);
	}
	$('#submit-ticket').click(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        doTask();
	});
	
	$('#submit-wait').click(function(e) {
		$('#tiket-error').modal('hide');
	});

	$('#input-ticket').focus(function() {
		$('#error-submit-ticket').addClass('invisible');
	});

	$('#submit-wait-error').click(function(e) {
		$('#error-ticket').modal('hide');
		
	});
  

	$('#retry, #retry-2').click(function(e) {
		e.preventDefault();
		window.location.href = window.location.href;
	});
	$('#submit-close-y').click(function(e) {
		$('#show-confirm').addClass('hide');
		$('#show-eligible-close-y').addClass('hide');
		$('#show-eligible').removeClass('hide');
		$('#show-eligible-thanks').removeClass('hide');
	});
	$('#submit-close-n').click(function(e) {
	});
	$('#submit-wait-0-y').click(function(e) {
		e.preventDefault();
		$('#ask-wait-0').modal('hide');
	});
	$('#submit-wait-0-n').click(function(e) {
		e.preventDefault();
		$('#ask-wait-0').modal('hide');
		window.location.href = window.location.href;
	});
	$('#submit-wait-1-y').click(function(e) {
		e.preventDefault();
		$('#ask-wait-1').modal('hide');
	});
	$('#submit-wait-1-n').click(function(e) {
		e.preventDefault();
		$('#ask-wait-1').modal('hide');
		window.location.href = window.location.href;
	});
	$('#submit-wait-2-y').click(function(e) {
		e.preventDefault();
		$('#ask-wait-2').modal('hide');
	});
	$('#btnhelp-home').click(function(e) {
		$('#ask-wait-2').modal('show'); //show-help-home
	});
	$('#submit-wait-2-n').click(function(e) {
		e.preventDefault();
		$('#ask-wait-2').modal('hide');
		window.location.href = window.location.href;
	});
	$('#submit-speed').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: '/retrieveSpeed',
			contentType: 'application/json',
			data: JSON.stringify({ 'uid': document.getElementById("uid").innerHTML,
            'data': $('#submit-speed').data()}),
            // data2: {'uid': document.getElementById("uid").innerHTML},
            // 'agedd_id='+ageddajax +'&agemm_id='+agemmajax +'&ageyyyy_id='+ageyyyyajax
              
            // JSON.stringify($('#submit-speed').data()),
                 
			success: function(response3) {
                // console.log(donwload);
				$('#ookla-test').modal('hide');
				$('#loader-speed').addClass('hide');
				if(response3.speed_passed > 0) {
                    $('#confirm-speed').val('Layak');
					flagSpeed = true;
					// retrievepassed();
				}else{
					finish('failed');
				}
                sendAutoClose();
			},
			error: function(err) {
				finish('failed');
			}
		});
	});
});


function ooklaListener(ev) {
	$('#submit-speed').data(ev.data);
	$('#submit-speed').removeClass('disabled');
    // console.log(ev.data);
}


function doTask() {
	$('#input-ticket').attr('disabled', 'disabled');
	$('#submit-ticket').addClass('hide');
	$('#loader-ticket').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: '/createTask',
		data: {
			'ticket': $('#input-ticket').val(),
			'nd': $('#input-ndnumber').val()
		},
		success: function(response1) {
			if(response1.success) {
				$('#uid').html(response1.data.uid);
				$('#uidookla').html(response1.data.uid);
				$('#uidooklaa').html(response1.data.uid);
				timerWait0 = setTimeout(function() {
					// alert('Output dari nossa tidak ditemukan');
					$('#ask-ticket').addClass('hide');
					$('#show-check').addClass('hide');
					finish('failed');
				}, 60000);
				doToken1();
				
			}
			else {
				alert('10002 pastikan no ticket anda sudah benar');
				finish('failed');
			}
		},
		error: function(err) {
			alert('10001');
			finish('failed');
		}
	});
}

function doToken1() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: 'retrieveToken',
		data: {
            'uid': document.getElementById("uid").innerHTML
        },
		success: function(response9){
			if(response9.success){
				clearTimeout(timerWait0);
				timerWait1 = setTimeout(function() {
					// finish('failed');
					$('#show-check').addClass('hide');
					$('#show-finish-nds').removeClass('hide');
					$('#ask-ticket').addClass('hide');
				}, 60000);
				// doNDByIN();
                doWho(1);
				
			}
			else {
				$('#ask-ticket').addClass('hide');
				alert('30001 tidak mendapatkan token');
				finish('failed');
			}
		},
		error: function(a) {
			clearTimeout(timerWait0);
			alert('30002 tidak mendapatkan output dari APIM');
			finish('failed');
		}
	});
}
function doNDByIN(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveNDByIN'),
		data: {},
		success: function(response9){
			if(response9.status == 200) {
				if(response9.success){
					clearTimeout(timerWait1);
					if(response9.data.nd != null){
						timerWait2 = setTimeout(function() {
							$('#show-finish-ipradius').removeClass('hide');
							$('#ask-ticket').addClass('hide');
							$('#show-check').addClass('hide');
						}, 60000);
						doIPRadius();
						// doWho(1);
						}
					else {
						$('#show-finish-nd').removeClass('hide');
						$('#ask-ticket').addClass('hide');
						$('#show-check').addClass('hide');
					}
				}else{
					$('#show-finish-nds').removeClass('hide');
					$('#ask-ticket').addClass('hide');
					$('#show-check').addClass('hide');
				}
			}
			else {
				$('#show-finish-nds').removeClass('hide');
				$('#ask-ticket').addClass('hide');
				$('#show-check').addClass('hide');
			}
		},
		error: function(a) {
			alert('Nossa failed');
			finish('failed');
		}
	});
}

function doIPRadius() {
	//$('#loader-redaman').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: '/retrieveIPByND',
		data: {
            'uid': document.getElementById("uid").innerHTML
        },
		success: function(response14) {
            if(response14.frame_ip != null) {			

            }
					
		},
		error: function(err) {
			clearTimeout(timerWait2);
			finish('failed');
		}
	});
}

function doWho(attempt) {
	if(attempt < 4) {
		$.ajax({
			method: 'get',
			dataType: 'json',
			url: 'https://myip.indihome.co.id',
			//url: 'https://test.indihome.co.id/CloseTicket.Internet/Test/myip/4',
			success: function(response1) {
				let ip_addr = null;
				if(typeof response1.ip_addr != 'undefined'){
					clearTimeout(timerWait3);
					ip_addr = response1.ip_addr;
					$.ajax({
						method: 'post',
						dataType: 'json',
						url: '/saveMyIP',
						data: {
							ip_addr: ip_addr,
                            'uid': document.getElementById("uid").innerHTML,
						},
						success: function(response3) {
						
                            // console.log(data);
                            if(response3.success) {
								$('#ask-wait-0').modal('hide');
								$('#ask-ticket').addClass('hide');
								$('#show-check').removeClass('hide');
								$('#confirm-ticket').val(response3.ticket);
								$('#confirm-nd').val(response3.nd);
                                // doNDByIP();
								// doIPRadius();
								doRedaman();
                               
                            }
						},
						error: function(a) {
							// clearTimeout(timerWait2);
							alert('20002 Please Clear cache from your Device OR Browser');
						}
					});
				}else {
					doWho(attempt + 1);
				}
			},
			error: function(a, b, c) {
				console.log(a.status, b, c);
				doWho(attempt + 1);
			}
		});
	}
	else {
		alert('20001 please test https://myip.indihome.co.id');
		// clearTimeout(timerWait2);
		$('#show-finish-myip').removeClass('hide');
		$('#ask-ticket').addClass('hide');
	}
}

function doNDByIP() {
    $.ajax({
        method: 'post',
        dataType: 'json',
        url: 'retrieveNDByIP',
        data: {
            'uid': document.getElementById("uid").innerHTML
        },
        success: function(response5) {
            clearTimeout(timerWait1);
                    if(response5.nd != null) {
                        $('#ask-wait-0').modal('hide');
                        $('#ask-ticket').addClass('hide');
                        $('#show-check').removeClass('hide');
                        $('#confirm-ticket').val(response5.ticket);
                        $('#confirm-nd').val(response5.nd);
                        // $('#confirm-ts').text(response5.data.ts + " WIB");
                        doIPRadius();
                        doRedaman();
                        timerWait2 = setTimeout(function() {
                            $('#show-finish-rdm').removeClass('hide');
                            $('#ask-ticket').addClass('hide');
                            $('#show-check').addClass('hide');
                            }, 60000);

                        
                        // doSpeed();
                        // doSpeedAcsis();
                                
                    }else {
                    
                        $('#show-finish-nd').removeClass('hide');
                        $('#ask-ticket').addClass('hide');
                        $('#show-check').addClass('hide');
                    }
                },
        error: function(err) {
            clearTimeout(timerWait1);
            $('#show-finish-nde').removeClass('hide');
            $('#ask-ticket').addClass('hide');
            $('#show-check').addClass('hide');
        }
    });	
}


function doOokla(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveSpeedOokla'),
		data: {},
		success: function(response11){
			if(response11.success){
				if(response11.data.speedtest == 1){
					document.getElementById('ookla').src = 'https://test-inf-1.speedtestcustom.com';

				} 
				else if(response11.data.speedtest == 2){
					document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';
				
				} 
				else{ 
					document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';
				} 
			}
			else {
				document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';			
			}
		},
		error: function(a) {
			document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';			
			// alert('40003 please Check your connection');
			// finish('failed');
		}
	});
}

function doSpeedAcsis() {
	$('#loader-speed-acsis').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveSpeedAcsis'),
		data: {},
		success: function(response3) {
			$('#loader-speed-acsis').addClass('hide');
			if(response3.success) {
				if(response3.data.speed != 0){
					$('#confirm-speed-acsis').val(response3.data.speed);
				}else{
					$('#confirm-speed-acsis').val('-');
				}
			}
			else {
				finish('failed');
			}
		},
		error: function(err) {
			finish('failed');
		}
	});
}

function doRedaman() {
	//console.log('redaman');
	$('#loader-redaman').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: '/retrieveUkur',
		data: {
            'uid': document.getElementById("uid").innerHTML
        },
		success: function(response1) {
			flagRedaman = true;
            clearTimeout(timerWait2);
			$('#loader-redaman').addClass('hide');
			doSpeed();
                if(response1.redaman_passed == 1) {
                    $('#confirm-redaman').val('Layak');
                    okRedaman = true;
                }
                else if(response1.data.redaman_passed == 0)  {
                    $('#confirm-redaman').val('Belum Layak');
                } 
                else if(response1.data.redaman_passed == null)  {
                    $('#confirm-redaman').val('Belum Layak');
                }
                timerWait5 = setTimeout(function() {
                    $('#show-finish-pcrf').removeClass('hide');
                    $('#show-check').addClass('hide');
                }, 60000);
					
					
	 				//doSpeedAcsis();
		},
		error: function(err) {
			clearTimeout(timerWait4);
			finish('failed');
		}
	});
}


function doSpeed() {
	$('#loader-speed').removeClass('hide');
        $.ajax({
            method: 'post',
            dataType: 'json',
            url: 'retrievePCRF',
            data: {
                'uid': document.getElementById("uid").innerHTML
            },
            success: function(response2) {
                clearTimeout(timerWait5);
                $('#loader-redaman').addClass('hide');
                    
                    if(response2.paket != null) {
                        let checkRedaman = setInterval(function() {
                            console.log('-');
                            if(flagRedaman) {
                                clearInterval(checkRedaman);
                                console.log('x');
                                $('#ookla-test').modal('show');
                            }
                        }, 500);
                    }
                    else {
                        $('#ookla-test').modal('show');
                    }							
                
            },
            error: function(err) {
                clearTimeout(timerWait5);
                $('#show-finish-pcrf').removeClass('hide');
                $('#show-check').addClass('hide');
            }
        });
}

function sendAutoClose(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: 'retrieveCloseAuto',
		data: {
            'uid': document.getElementById("uid").innerHTML
        },
		success: function(response1) {
            if((response1.close) > 0) {
                    $('#show-eligible-close-y').removeClass('hide');
            }
            else {
                $('#show-eligible-close-y').addClass('hide');
                $('#show-eligible-close-n').removeClass('hide');
            }
		},
		error: function(err) {
			finish('failed');
		}
	});
}

function finish(s) {
	clearTimeout(timerWait0);
	$('#ask-wait-0').modal('hide');
	clearTimeout(timerWait1);
	clearTimeout(timerWait2);
	clearTimeout(timerWait3);
	clearTimeout(timerWait4);
	clearTimeout(timerWait5);
	$('#ask-wait-1').modal('hide');
	$('#ask-wait-2').modal('hide');
	$('.wizard').addClass('hide');
	$('.show-finish-sub').addClass('hide');
	$('#show-finish').removeClass('hide');
	$('#show-finish-' + s).removeClass('hide');
}