@if ($getTriaseIGD)
    @foreach ($getTriaseIGD as $item)
        <div class="card-body">
            @php
                $triase = count($item->triasePrimer) > 0 ? 'TRIASE PRIMER' : 'TRIASE SEKUNDER';
                $value = count($item->triasePrimer) > 0 ? $item->triasePrimer->first() : $item->triaseSekender->first();

                $bgStyles = match ($value->plan) {
                    'Ruang Kritis' => 'rgb(255, 0, 0)',
                    'Ruang Resusitasi' => 'rgb(135, 1, 1)',
                    'Zona Hijau' => 'rgb(57, 202, 0)',
                    'Zona Kuning' => 'rgb(241, 217, 0)',
                    default => 'rgb(204, 204, 204)',
                };
                $catatan = $value->catatan;
                $keluhan_utama = $value->keluhan_utama;
                $nama = $value->nama;
                $nik = $value->nik;
                $tanggaltriase = $value->tanggaltriase;
            @endphp
            <table width="700px">
                <tr>
                    <td rowspan="4"> <img src="data:image/png;base64,{{ base64_encode($getSetting->logo) }}"
                            width="80" height="80"></td>
                </tr>
                <tr>
                    <td class="text-center">
                        <h2>{{ $getSetting->nama_instansi }} </h2>
                    </td>

                </tr>
                <tr class="text-center">
                    <td>{{ $getSetting->alamat_instansi }} , {{ $getSetting->kabupaten }},
                        {{ $getSetting->propinsi }}
                        {{ $getSetting->kontak }}</td>
                </tr>
                <tr class="text-center">
                    <td> E-mail : {{ $getSetting->email }}</td>
                </tr>
            </table>
            <table border="1px" width="700px" class="mt-1">
                <tr class="text-center">
                    <td style="background-color:{{ $bgStyles }};">
                        <h4 class="mt-0 mb-0"><b>TRIASE PASIEN GAWAT DARURAT</b></h4>
                    </td>
                </tr>
                <tr class="text-center">
                    <td>Triase dilakukan segera setelah pasien datang dan sebelum pasien/ keluarga mendaftar di TPP IGD
                    </td>
                </tr>
            </table>
            <table width="700px" class="mt-1">
                <tr style="vertical-align: top;">
                    <td width="115px">Nama Pasien</td>
                    <td width="300px">: {{ $item->nm_pasien }}</td>
                    <td width="110px">No. Rekam Medis</td>
                    <td width="160px">: {{ $item->no_rkm_medis }}</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>Tanggal Lahir</td>
                    <td>: {{ $item->tgl_lahir }}</td>
                    <td>Jenis Kelamin</td>
                    <td>: {{ $item->jk == 'P' ? 'Perempuan' : 'Laki-laki' }}</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>Tanggal Kunjungan</td>
                    <td>: {{ date('d-m-Y', strtotime($item->tgl_kunjungan)) }}</td>
                    <td>Pukul</td>
                    <td>: {{ date('H:i:s', strtotime($item->tgl_kunjungan)) }}</td>
                </tr>
            </table>
            <table border="1px" width="700px" class="mt-1">
                <tr style="vertical-align: top;">
                    <td width="150px">Cara Datang</td>
                    <td width="350px">: {{ $item->cara_masuk }}</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>Macam Kasus</td>
                    <td>: {{ $item->macam_kasus }}</td>
                </tr>
            </table>
            <table border="1px" width="700px" class="mt-1">
                <tr style="vertical-align: top;">
                    <td width="250px" class="text-center" style="background-color: rgb(255, 246, 163)">KETERANGAN</td>
                    <td class="text-center" style="background-color: rgb(255, 246, 163)">{{ $triase }}R</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td height="100px">ANAMNESA SINGKAT</td>
                    <td height="100px">{{ $keluhan_utama }}</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>TANDA VITAL</td>
                    <td>
                        Suhu (C) : {{ $item->suhu }},
                        Nyeri : {{ $item->nyeri }},
                        Tensi : {{ $item->tekanan_darah }},
                        Nadi(/menit) : {{ $item->nadi }},
                        Saturasi O²(%) : {{ $item->saturasi_o2 }},
                        Respirasi(/menit) : {{ $item->pernapasan }}
                    </td>
                </tr>
            </table>
            <table border="1px" width="700px" class="mt-1">
                <tr style="vertical-align: top;">
                    <td width="250px" class="text-center" style="background-color: rgb(255, 246, 163)">PEMERIKSAAN</td>
                    <td class="text-center" style="background-color: {{ $bgStyles }}">URGENSI</td>
                </tr>
                @foreach (['data_triase_igddetail_skala1', 'data_triase_igddetail_skala2', 'data_triase_igddetail_skala3', 'data_triase_igddetail_skala4', 'data_triase_igddetail_skala5'] as $index => $skalaKey)
                    @if (count($item->$skalaKey) > 1)
                        @foreach ($item->$skalaKey as $skala)
                            <tr style="vertical-align: top;">
                                <td>{{ $skala->nama_pemeriksaan }}</td>
                                <td style="background-color: {{ $bgStyles }}">
                                    {{ $skala->{'pengkajian_skala' . ($index + 1)} }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </table>
            <table width="700px" class="mt-1">
                <tr style="vertical-align: top;">
                    <td class="text-center" colspan="2" style="background-color: rgb(255, 246, 163)"><b>Petugas
                            Triase Sekunder</b></td>
                </tr>
                <tr style="vertical-align: top;">
                    <td width="125px">Tanggal & Jam</td>
                    <td>: {{ date('d-m-Y', strtotime($item->tgl_kunjungan)) }}
                        {{ date('H:i:s', strtotime($item->tgl_kunjungan)) }}</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>Catatan</td>
                    <td>: {{ $catatan }}</td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>Dokter / Petugas Jaga IGD</td>
                    <td>: {{ $nama }}</td>
                </tr>
            </table>
            <table width="700px" class="mt-1">
                <tr>
                    <td width="250px" class="text-center">

                    </td>
                    <td width="150px"></td>
                    <td width="250px" class="text-center">
                        Dokter / Petugas Jaga
                        <div class="barcode mt-1">
                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di ' . $getSetting->nama_instansi . ', Kabupaten/Kota ' . $getSetting->kabupaten . ' Ditandatangani secara elektronik oleh ' . $nama . ' ID ' . $nik . ' ' . $item->tgl_kunjungan, 'QRCODE') }}"
                                alt="barcode" width="80px" height="75px" />
                        </div>
                        {{ $nama }}
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
@endif
