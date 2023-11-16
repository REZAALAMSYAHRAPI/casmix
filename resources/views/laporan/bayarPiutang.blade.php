@extends('..layout.layoutDashboard')
@section('title', 'Bayar Piutang')

@section('konten')
<div class="card">
    <div class="card-body">
        @include('laporan.component.search-bayarPiutang')
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
                    <th>Tanggal</th>
                    <th>No.Rawat</th>
                    <th>No.Nota</th>
                    <th>No.RM</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Bayar</th>
                    {{-- <th>Perujuk</th> --}}
                    <th>Registrasi</th>
                    <th>Obat+Emb+Tsl</th>
                    <th>Paket Tindakan</th>
                    <th>Operasi</th>
                    <th>Laborat</th>
                    <th>Radiologi</th>
                    <th>Tambahan</th>
                    <th>Potongan</th>
                    <th>Total</th>
                    <th>Ekses</th>
                    <th>Sudah Dibayar / Besar Cicilan</th>
                    <th>Diskon Bayar</th>
                    <th>Tidak Terbayar</th>
                    <th>Sisa</th>
                    <th>Dokter</th>
                </tr>
                @php
                    $no = 1;
                @endphp
                @foreach ($bayarPiutang as $item)
                    <tr>
                        <td>{{ $no++}}</td>
                        <td>{{ $item->tgl_registrasi }}</td>
                        <td>{{ $item->no_rawat }}</td>
                        <td>
                            @foreach ($item->getNomorNota as $detail)
                                {{ $detail->no_nota }}
                            @endforeach
                        </td>
                        <td>{{ $item->no_rkm_medis }}</td>
                        <td>{{ $item->nm_pasien }}</td>
                        <td>{{ $item->png_jawab }}</td>
                        {{-- <td>Perujuk</td> --}}

                        <td>
                            {{ $item->getRegistrasi->sum('totalbiaya') }}
                        </td>
                        <td>
                            {{ $item->getObat->sum('totalbiaya') }}
                        </td>
                        <td>
                            {{ $item->getRalanDokter->sum('totalbiaya') +
                                $item->getRalanParamedis->sum('totalbiaya') +
                                $item->getRalanDrParamedis->sum('totalbiaya') }}
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
                        <td>
                            {{-- TOTAL --}}
                            {{ $item->getRegistrasi->sum('totalbiaya') +
                                $item->getObat->sum('totalbiaya') +
                                $item->getRalanDokter->sum('totalbiaya') +
                                $item->getRalanParamedis->sum('totalbiaya') +
                                $item->getRalanDrParamedis->sum('totalbiaya') +
                                $item->getOprasi->sum('totalbiaya') +
                                $item->getLaborat->sum('totalbiaya') +
                                $item->getRadiologi->sum('totalbiaya') +
                                $item->getTambahan->sum('totalbiaya') +
                                $item->getPotongan->sum('totalbiaya') }}
                        </td>
                        <td>{{ $item->uangmuka }}</td>
                        <td> {{ $item->getSudahBayar->sum('besar_cicilan') }}</td>
                        <td> {{ $item->getSudahBayar->sum('diskon_piutang') }}</td>
                        <td> {{ $item->getSudahBayar->sum('tidak_terbayar') }}</td>
                        <td>
                            {{ $item->getRegistrasi->sum('totalbiaya') +
                                $item->getObat->sum('totalbiaya') +
                                $item->getRalanDokter->sum('totalbiaya') +
                                $item->getRalanParamedis->sum('totalbiaya') +
                                $item->getRalanDrParamedis->sum('totalbiaya') +
                                $item->getOprasi->sum('totalbiaya') +
                                $item->getLaborat->sum('totalbiaya') +
                                $item->getRadiologi->sum('totalbiaya') +
                                $item->getTambahan->sum('totalbiaya') +
                                $item->getPotongan->sum('totalbiaya')-
                                $item->uangmuka -
                                $item->getSudahBayar->sum('besar_cicilan')-
                                $item->getSudahBayar->sum('diskon_piutang')-
                                $item->getSudahBayar->sum('tidak_terbayar')
                                }}
                        </td>
                        <td>{{ $item->nm_dokter }}</td>
                    </tr>
                @endforeach
                <tr class="font-weight-bold">
                    <td colspan="7">Total :</td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getRegistrasi->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getObat->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getRalanDokter->sum('totalbiaya') +
                                $item->getRalanParamedis->sum('totalbiaya') +
                                $item->getRalanDrParamedis->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getOprasi->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getLaborat->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getRadiologi->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getTambahan->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getPotongan->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getRegistrasi->sum('totalbiaya') +
                                $item->getObat->sum('totalbiaya') +
                                $item->getRalanDokter->sum('totalbiaya') +
                                $item->getRalanParamedis->sum('totalbiaya') +
                                $item->getRalanDrParamedis->sum('totalbiaya') +
                                $item->getOprasi->sum('totalbiaya') +
                                $item->getLaborat->sum('totalbiaya') +
                                $item->getRadiologi->sum('totalbiaya') +
                                $item->getTambahan->sum('totalbiaya') +
                                $item->getPotongan->sum('totalbiaya');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->uangmuka;
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getSudahBayar->sum('besar_cicilan');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getSudahBayar->sum('diskon_piutang');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getSudahBayar->sum('tidak_terbayar');
                        }) }}
                    </td>
                    <td>
                        {{ $bayarPiutang->sum(function ($item) {
                            return $item->getRegistrasi->sum('totalbiaya') +
                                $item->getObat->sum('totalbiaya') +
                                $item->getRalanDokter->sum('totalbiaya') +
                                $item->getRalanParamedis->sum('totalbiaya') +
                                $item->getRalanDrParamedis->sum('totalbiaya') +
                                $item->getOprasi->sum('totalbiaya') +
                                $item->getLaborat->sum('totalbiaya') +
                                $item->getRadiologi->sum('totalbiaya') +
                                $item->getTambahan->sum('totalbiaya') +
                                $item->getPotongan->sum('totalbiaya')-
                                $item->uangmuka -
                                $item->getSudahBayar->sum('besar_cicilan')-
                                $item->getSudahBayar->sum('diskon_piutang')-
                                $item->getSudahBayar->sum('tidak_terbayar');
                        }) }}
                    </td>
                    <td></td>
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
