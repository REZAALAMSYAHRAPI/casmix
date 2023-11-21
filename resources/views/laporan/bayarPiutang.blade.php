@extends('..layout.layoutDashboard')
@section('title', 'Bayar Piutang')

@section('konten')
    <div class="card">
        <div class="card-body">
            @include('laporan.component.search-bayarPiutang')
            Jumlah Data : {{ count($bayarPiutang) }}
            <div class="row no-print">
                <div class="col-12">
                    <button type="button" class="btn btn-default float-right" id="copyButton">
                        <i class="fas fa-copy"></i> Copy table
                    </button>
                </div>
            </div>
            <table class="table table-sm table-bordered table-striped table-responsive text-xs" style="white-space: nowrap;"
                id="tableToCopy">
                <tbody>
                    <tr>
                        <th>No</th>
                        <th>Tgl.Bayar</th>
                        <th>No.RM</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Bayar</th>
                        <th>No. Nota</th>
                        <th>Registrasi</th>
                        <th>Obat+Emb+Tsl</th>
                        <th>Paket Tindakan</th>
                        <th>Operasi</th>
                        <th>Laborat</th>
                        <th>Radiologi</th>
                        <th>Tambahan</th>
                        <th>Potongan</th>
                        <th>Ekses / Uang Muka</th>
                        <th>Cicilan(Rp)</th>
                        <th>Diskon Bayar(Rp)</th>
                        <th>Tidak Terbayar(Rp)</th>
                        <th>Catatan</th>
                        <th>No.Rawat/No.Tagihan</th>
                        <th>Status</th>
                    </tr>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($bayarPiutang as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->tgl_bayar }}</td>
                            <td>{{ $item->no_rkm_medis }}</td>
                            <td>{{ $item->nm_pasien }}</td>
                            <td>{{ $item->png_jawab }}</td>
                            <td>
                                @foreach ($item->getNomorNota as $detail)
                                {{ str_replace(':', '', $detail->nm_perawatan) }}
                                @endforeach
                            </td>


                            <td>
                                {{ $item->getRegistrasi->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getObat->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getRalanDokter->sum('totalbiaya') +
                                    $item->getRalanParamedis->sum('totalbiaya') +
                                    $item->getRalanDrParamedis->sum('totalbiaya') +
                                    $item->getRanapDokter->sum('totalbiaya')+
                                    $item->getRanapDrParamedis->sum('totalbiaya')+
                                    $item->getRanapParamedis->sum('totalbiaya')}}
                            </td>
                            <td>
                                {{ $item->getOprasi->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getLaborat->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getRadiologi->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getTambahan->sum('totalbiaya') }}
                            </td>
                            <td>
                                {{ $item->getPotongan->sum('totalbiaya') }}
                            </td>
                            <td>{{ $item->uangmuka }}</td>




                            <td>{{ $item->besar_cicilan }}</td>
                            <td>{{ $item->diskon_piutang }}</td>
                            <td>{{ $item->tidak_terbayar }}</td>
                            <td>{{ $item->catatan }}</td>
                            <td>{{ $item->no_rawat }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="6">Total</th>

                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getRegistrasi->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getObat->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getRalanDokter->sum('totalbiaya') +
                                    $item->getRalanParamedis->sum('totalbiaya') +
                                    $item->getRalanDrParamedis->sum('totalbiaya')+
                                    $item->getRanapDokter->sum('totalbiaya')+
                                    $item->getRanapDrParamedis->sum('totalbiaya')+
                                    $item->getRanapParamedis->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getOprasi->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getLaborat->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getRadiologi->sum('totalbiaya');
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getTambahan->sum('totalbiaya');
                            }) }}
                        </th>
                        <td>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->getPotongan->sum('totalbiaya');
                            }) }}
                        </td>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->uangmuka;
                            }) }}
                        </th>



                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->besar_cicilan;
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->diskon_piutang;
                            }) }}
                        </th>
                        <th>
                            {{ $bayarPiutang->sum(function ($item) {
                                return $item->tidak_terbayar;
                            }) }}
                        </th>
                        <th colspan="3"></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById("copyButton").addEventListener("click", function() {
            copyTableToClipboard("tableToCopy");
        });
        function copyTableToClipboard(tableId) {
            const table = document.getElementById(tableId);
            const range = document.createRange();
            range.selectNode(table);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            try {
                document.execCommand("copy");
                window.getSelection().removeAllRanges();
                alert("Tabel telah berhasil disalin ke clipboard.");
            } catch (err) {
                console.error("Tidak dapat menyalin tabel:", err);
            }
        }
    </script>
@endsection
