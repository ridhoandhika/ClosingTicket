@extends('layouts.app')
@section('content')
<div id="wizard">
    <div class="_container">
        <div class="wizard" data-wizard="0" id="ask-ticket">
                <h5 class="wizard-label">Nomor Tiket Gangguan</h5>
                <div id="wrap-ticket">
                    <input type="text" maxlength="13" class="form-control" id="input-ticket" placeholder="masukkan nomor tiket gangguan">
                    <input type="text" maxlength="13" class="form-control" id="input-ndnumber" placeholder="masukkan nomor internet gangguan">
                    <button class="btn btn-sm" id="submit-ticket">submit</button>
                    <div class="loader hide" id="loader-ticket">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                    </div>
                    {{-- <iframe width="100%" height="650px"  frameborder="0" src="https://myip.indihome.co.id"></iframe> --}}
                    <small class="form-text text-muted invisible" id="error-submit-ticket">
                        Format Nomor Tiket tidak sesuai
                    </small>
                </div>
                <div id="disclaimer">
                    <ul>
                        <li>Pastikan ONT ON, tidak isolir dan jaringan fiber</li>
                        <li>Hasil speed test akan optimal jika tidak ada gadget yang terkoneksi ke ONT</li>
                    </ul>
                </div>
                <div class="center-btn"> 
                    <button class="btn btn-sm btn-light" id="btnhelp-home" data-toggle="modal" data-target="#ask-wait-2">Bantuan</button>
                </div>
        </div>
        <div class="wizard hide" data-wizard="1" id="show-check">
            <div id="show-confirm">
                <h5 class="wizard-label">Hasil Pengecekan Internet Anda</h5>
                <div class="date-ts">
                    <h6 class="wizard-label-ts"  id="confirm-ts"></h6>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nomor Tiket</span>
                    </div>
                    <input type="text" class="form-control" id="confirm-ticket" readonly>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nomor Internet Anda</span>
                    </div>
                    <input type="text" class="form-control" id="confirm-nd" readonly>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Kualitas Jaringan</span>
                    </div>
                    <div class="loader hide" id="loader-redaman">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                    </div>
                    <input type="text" class="form-control" id="confirm-redaman" readonly>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Kecepatan Internet</span>
                    </div>
                    <div class="loader hide" id="loader-speed">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                    </div>
                    <input type="text" class="form-control" id="confirm-speed" readonly>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Speed Test ONT</span>
                    </div>
                    <div class="loader hide" id="loader-speed-acsis">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                    </div>
                    <input type="text" class="form-control" id="confirm-speed-acsis" readonly>
                </div>
            </div>
            <div id="show-eligible">
                <div class="hide" id="show-eligible-close-y">
                    <hr />
                    Layanan internet anda dalam kondisi normal.<br />
                    <hr />
                    <button class="btn btn-sm btn-light" id="submit-close-y">Ok</button>
                </div>
                <div class="hide" id="show-eligible-close-n">
                    <br />
                    <div id="disclaimer">
                        Jika hasil Kecepatan Internet BELUM LAYAK, silakan melakukan pengetesan SCC Web dari Laptop/PC Pelanggan menggunakan media kabel LAN, untuk mendapatkan hasil yang mendekati ideal (khususnya pada Pelanggan Paket >= 50 Mbps)
                    </div>
                    <hr />
                    Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                    <hr />
                    <button class="btn btn-sm btn-light" id="retry-2">Ok</button>
                </div>
                <div class="hide" id="show-eligible-thanks">
                    <hr />
                    Terima kasih atas kepercayaan anda pada layanan IndiHome
                </div>
            </div>
        </div>
        <div class="wizard hide" data-wizard="1" id="show-finish">
            <div id="show-finish-failed" class="show-finish-sub">
                <hr />
                Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                <hr />
                <button class="btn btn-sm btn-light" id="retry">Ok</button>
            </div>
        </div>
        <div class="wizard hide" data-wizard="1" id="show-finish-myip">
            <div id="show-finish-failed" class="show-finish-sub">
                Output dari myip tidak ditemukan
                <hr />
                Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                <!-- Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147 -->
                <hr />
                <button class="btn btn-sm btn-light" id="retry">Ok</button>
                <button class="btn btn-sm btn-light" id="btnhelp-myip" data-toggle="modal" data-target="#ask-wait-2">Bantuan</button>
            </div>
        </div>

        <div class="wizard hide" data-wizard="1" id="show-finish-nd">
            <div id="show-finish-failed" class="show-finish-sub">
                Nomor internet tidak ditemukan
                <hr />
                Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                <!-- Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147 -->
                <hr />
                <button class="btn btn-sm btn-light" id="retry">Ok</button>
                <button class="btn btn-sm btn-light" id="btnhelp-nd" data-toggle="modal" data-target="#ask-wait-2">Bantuan</button>
            </div>
        </div>
        <div class="wizard hide" data-wizard="1" id="show-finish-nde">
            <div id="show-finish-failed" class="show-finish-sub">
                tidak mendapatkan output dari GetND Radius
                <hr />
                Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                <!-- Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147 -->
                <hr />
                <button class="btn btn-sm btn-light" id="retry">Ok</button>
                <button class="btn btn-sm btn-light" id="btnhelp-nde" data-toggle="modal" data-target="#ask-wait-2">Bantuan</button>
            </div>
        </div>
        <div class="wizard hide" data-wizard="1" id="show-finish-rdmn">
            <div id="show-finish-failed" class="show-finish-sub">
                Redaman tidak ditemukan
                <hr />
                Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                <!-- Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147 -->
                <hr />
                <button class="btn btn-sm btn-light" id="retry">Ok</button>
                <button class="btn btn-sm btn-light" id="btnhelp-rdmn" data-toggle="modal" data-target="#ask-wait-2">Bantuan</button>
            </div>
        </div>
        <div class="wizard hide" data-wizard="1" id="show-finish-rdm">
            <div id="show-finish-failed" class="show-finish-sub">
                tidak mendapatkan ouput dari redaman Ibooster 
                <hr />
                Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                <!-- Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147 -->
                <hr />
                <button class="btn btn-sm btn-light" id="retry">Ok</button>
                <button class="btn btn-sm btn-light" id="btnhelp-rdm" data-toggle="modal" data-target="#ask-wait-2">Bantuan</button>
            </div>
        </div>
        <div class="wizard hide" data-wizard="1" id="show-finish-pcrf">
            <div id="show-finish-failed" class="show-finish-sub">
                tidak mendapatkan ouput dari PCRF 
                <hr />
                Tiket tetap bisa dilakukan Tech Closed, namun akan melewati proses Mediacare/Saltik.
                <!-- Penutupan tiket pelaporan gangguan internet akan dilakukan melalui konfirmasi 147 -->
                <hr />
                <button class="btn btn-sm btn-light" id="retry">Ok</button>
                <button class="btn btn-sm btn-light" id="btnhelp-pcrf" data-toggle="modal" data-target="#ask-wait-2">Bantuan</button>
            </div>
        </div>
    </div>
</div>
<div id="uid">
</div>
<div class="modal fade" id="ask-wait-2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document" data-backdrop="static">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Panduan gagal SCC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="info-text">
                    <h6>1. Tidak dapat output dari myip </h6>
                    <ul>
                        <li>Buka url <a href="https://myip.indihome.co.id" target="_blank">myip.indihome.co.id</a></li>
                        <li>Jika tidak bisa meng-akses <a href="https://myip.indihome.co.id" target="_blank">myip.indihome.co.id</a>, lakukan clear cache pada browser/app mytech Sonic</li>
                        <li>Atau Lakukan ipconfig/flushdns bagi yang menggunakan PC/Laptop</li>
                        <li>Atau gunakan tab penyamaran pada browser anda (incognito)</li>
                        <li>Ulang kembali test <a href="https://myip.indihome.co.id" target="_blank">myip.indihome.co.id</a>, jika berhasil, lakukan test ulang SCC </li>
                    </ul>
                    <h6>2. Nomor internet tidak di temukan</h6>
                    <ul>
                        <li>Lakukan cek ip ke <a href="https://myip.indihome.co.id" target="_blank">myip indihome co id</a></li>
                        <li>Lakukan restart perangkat ont pelanggan</li>
                        <li>Gunakan tab penyamaran pada browser anda (incognito)</li>
                        <li>Ulang kembali test SCC</li>
                        <li>Jika masih belum berhasil hubungi kontak telegram <a href="tg://user?id=indihomeku_indihomemu">@indihomeku_indihomemu</a> (Sdr. Mumuh DSO) dengan melampirkan no tikcet gangguan, capture gagal SCC dan IP dari <a href="https://myip.indihome.co.id" target="_blank">myip.indihome.co.id</a></li>
                    </ul>
                    <h6>3. Speedtest Ookla tidak muncul / hanya tampilan putih </h6>
                    <ul>
                        <li>Test url : 
                            <ul>
                                <li> Ookla 1 : <a href="https://scc.telkom.co.id/CloseTicket.Internet/Test/ookla" target="_blank"> click disini</a></li>
                                <li> Ookla 2 : <a href="https://scc.telkom.co.id/CloseTicket.Internet/Test/ookla2" target="_blank"> click disini</a></li>
                            </ul>
                        </li>
                        <li>Jika berhasil speedtest, Ulang kembali test SCC</li>
                        <li>Jika tidak berhasil speedtest, Pastikan koneksi internet anda telah lancar</li>
                    </ul>
                </div>
                <hr />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ask-wait-0" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" data-backdrop="static">
        <div class="modal-content">
            <div class="modal-body">
                Belum mendapatkan nd. Bersedia menunggu?
                <hr />
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            <button class="btn btn-sm btn-danger" id="submit-wait-0-y">Ya</button>
                        </div>
                        <div class="col-6" style="text-align:left;">
                            <button class="btn btn-sm btn-danger" id="submit-close-0-n">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ask-wait-1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" data-backdrop="static">
        <div class="modal-content">
            <div class="modal-body">
                Belum mendapatkan hasil redaman. Bersedia menunggu?
                <hr />
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            <button class="btn btn-sm btn-danger" id="submit-wait-1-y">Ya</button>
                        </div>
                        <div class="col-6" style="text-align:left;">
                            <button class="btn btn-sm btn-danger" id="submit-close-1-n">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ookla-test" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                OOKLA
                <br />
                <div id="uidookla">
                </div>
                <hr />
                <div class="container-fluid">
                    <iframe width="100%" height="650px" id="ookla" frameborder="0" src="https://test-inf-1.speedtestcustom.com"></iframe>
                    {{-- //https://test.indihome.co.id/ookla.php --}}
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger disabled" id="submit-speed">continue</a>
            </div>
            <br />
            <div id="uidooklaa">
            </div>
        </div>
    </div>
</div>
@endsection