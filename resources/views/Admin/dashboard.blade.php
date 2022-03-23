@extends('Admin.layouts.app')
@push('styles')
    <link href="{{ asset('assets/Admin/css/index.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark mb-2">
            <a class="navbar-brand" href="#">Smart Customer Close</a>
        </nav>
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-lg-2 bg-dark">
                  
                    <div class="card mt-3" >
                        <div class="card-header">
                            <h4 class="card-title">Search</h4>
                        </div>
                        <div class="input-group mb-3 mt-3">
                            <input type="text" class="form-control" name="ticket" id="ticket-search-ticket" placeholder="masukan no ticket">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="button" id="ticket-search-submit">Search Ticket</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 bg-danger">
                    <div class="card strpied-tabled-with-hover mt-3">
                        <div class="card-header ">
                            <h4 class="card-title">INTERVAL SUMMARY</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped table-dark " id="list-overview-1">
                                <thead>
                                    <tr>
										<th colspan="2" rowspan="4">INTERVAL</th>
										<th class="text-center" colspan="2" rowspan="3">TOKEN</th>
										<th colspan="4">ND</th>
										<th colspan="2" rowspan="3">IP</th>
										<th colspan="3" rowspan="2">MYIP</th>
										<th colspan="3" rowspan="2">REDAMAN</th>
										<th colspan="5">SPEEDTEST</th>
										<th colspan="2">PELANGGAN</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2">WEB</th>
										<th colspan="2" rowspan="2">SONIC</th>
										<th colspan="2" rowspan="2">PCRF</th>
										<th colspan="2">DOWNLOAD</th>
									</tr>
									<tr>
										<th colspan="2">SUCCESS</th>
										<th rowspan="2">FAILED</th>
										<th colspan="2">SUCCESS</th>
										<th rowspan="2">FAILED</th>
										<th colspan="2">SUCCESS</th>
										<th rowspan="2">FAILED</th>
									</tr>
                                    <tr>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>VALID</th>
										<th>INVALID</th>
										<th>SPEC</th>
										<th>UNSPEC</th>
										<th>SUCCESS</th>
										<th>FAILED</th>
										<th>LAYAK</th>
										<th>BELUM LAYAK</th>
										<th>Y</th>
										<th>N</th>
									</tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($data as $d)
                                    <tr>
                                        <td colspan="2">{{ $d->tick }}</td>
                                        <td><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="{{ $d->tick }}" data-detail-field="token_1_success">{{ $d->token_1_success }}</a></td>
                                        <td>{{ $d->token_1_failed }}</td>
                                        <td>{{ $d->nd_success_nossa }}</td>
                                        <td>{{ $d->nd_failed_nossa }}</td>
                                        <td>{{ $d->nd_success_sonic }}</td>
                                        <td>{{ $d->nd_failed_sonic }}</td>
                                        <td>{{ $d->ip_success }}</td>
                                        <td>{{ $d->ip_failed }}</td>
                                        <td>{{ $d->validasi_success_passed_1 }}</td>
                                        <td>{{ $d->validasi_success_passed_0 }}</td>
                                        <td>{{ $d->validasi_failed }}</td>
                                        <td>{{ $d->redaman_success_spec }}</td>
                                        <td>{{ $d->redaman_success_unspec }}</td>
                                        <td>{{ $d->redaman_failed }}</td>
                                        <td>{{ $d->pcrf_success }}</td>
                                        <td>{{ $d->pcrf_failed }}</td>
                                        <td>{{ $d->speedtest_success_passed_1 }}</td>
                                        <td>{{ $d->speedtest_success_passed_0 }}</td>
                                        <td>{{ $d->speedtest_failed }}</td>
                                        <td>{{ $d->close_1 }}</td>
                                        <td>{{ $d->close_0 }}</td>
                                    </tr>
                                    @endforeach --}}
                                </tbody>
                                <tfoot>
									<tr>
										<th colspan="2">TOTAL</th>
										<th class="n foot-token_1_success">0</th>
										<th class="n foot-token_1_failed">0</th>
										<th class="n foot-nd_success_nossa">0</th>
										<th class="n foot-nd_failed_nossa">0</th>
										<th class="n foot-nd_success_sonic">0</th>
										<th class="n foot-nd_failed_sonic">0</th>
										<th class="n foot-ip_success">0</th>
										<th class="n foot-ip_failed">0</th>
										<th class="n foot-validasi_success_passed_1">0</th>
										<th class="n foot-validasi_success_passed_0">0</th>
										<th class="n foot-validasi_failed">0</th>
										<th class="n foot-redaman_success_spec">0</th>
										<th class="n foot-redaman_success_unspec">0</th>
										<th class="n foot-redaman_failed">0</th>
										<th class="n foot-pcrf_success">0</th>
										<th class="n foot-pcrf_failed">0</th>
										<th class="n foot-speedtest_success_passed_1">0</th>
										<th class="n foot-speedtest_success_passed_0">0</th>
										<th class="n foot-speedtest_failed">0</th>
										<th class="n foot-close_1">0</th>
										<th class="n foot-close_0">0</th>
									</tr>
								</tfoot>
                            </table>
                            {{-- {{ $data->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="modal-ticket-search" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-table">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-striped" id="ticket-search-result">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><div style="width:120px">ts</div></th>
                                                    <th>ticket</th>
                                                    <th>nd</th>
                                                    <th>frame_ip</th>
                                                    <th>ip_addr</th>
                                                    <th>ip_passed</th>
                                                    <th>onu_rx_pwr</th>
                                                    <th>redaman_passed</th>
                                                    <th>package_name</th>
                                                    <th>quota_used</th>
                                                    <th>speedtest_download</th>
                                                    <th>speedtest_upload</th>
                                                    <th>speed_passed</th>
                                                    <th>close</th>
                                                    <th>uid</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/Dashboard/index.js')}}"></script>
@endpush

{{-- @push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();

            demo.showNotification();

        });
    </script>
@endpush --}}