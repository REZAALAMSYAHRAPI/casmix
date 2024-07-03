<table border="0px" width="1000px" class="mt-4">
    <tr>
        <th></th>
        <th></th>
        <th>Nama </th>
        <th>Jumlah Biaya</th>
        <th>No Kwit</th>
        <th>No Kartu</th>
        <th>No Klaim</th>
        <th>Rm</th>
        <th>Tanggal Rawat</th>
    </tr>
    @if ($getPasien)
        @foreach ($getPasien as $key => $item)
            <tr>
                <td width="50px"></td>
                <td width="15px">{{ $key + 1 }}. </td>
                <td>{{ $item->nm_pasien }}</td>
                <td><u>Rp. {{ number_format($item->total_biaya, 0, ',', '.') }}</u> ,</td>
                <td>
                    @foreach ($item->getNomorNota as $detail)
                    {{ substr(str_replace(':', '', $detail->nm_perawatan), -6) }}
                    @endforeach
                </td>
                <td>Kartu</td>
                <td>No Klaim</td>
                <td>{{ $item->no_rkm_medis }}</td>
                <td>
                    @if ($item->tgl_masuk == null && $item->tgl_keluar == null)
                        {{ $item->tgl_byr }}
                    @else
                        {{ date('d', strtotime($item->tgl_masuk)) . ' - ' . date('d', strtotime($item->tgl_keluar)) }}-{{ \App\Services\BulanRomawi::BulanIndo(date('m', strtotime($item->tgl_keluar))) }}-{{ date('Y', strtotime($item->tgl_keluar)) }}
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><b>Rp. {{ number_format($getPasien->sum('total_biaya'), 0, ',', '.') }}</b></td>
        </tr>
    @endif
</table>
