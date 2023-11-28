<?php

namespace App\Http\Controllers\DetailTindakan;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RanapDokter extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    function RanapDokter(Request $request) {
        $actionCari = '/ranap-dokter';
        $penjab = $this->cacheService->getPenjab();
        $dokter = $this->cacheService->getDokter();

        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        $kdPenjamin = ($request->input('kdPenjamin') == null) ? "" : explode(',', $request->input('kdPenjamin'));
        $kdDokter = ($request->input('kdDokter')  == null) ? "" : explode(',', $request->input('kdDokter'));

        $ranapDokter = DB::table('pasien')
            ->select('rawat_inap_dr.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'rawat_inap_dr.kd_jenis_prw',
                'jns_perawatan_inap.nm_perawatan',
                'rawat_inap_dr.kd_dokter',
                'dokter.nm_dokter',
                'rawat_inap_dr.tgl_perawatan',
                'rawat_inap_dr.jam_rawat',
                'penjab.png_jawab',
                DB::raw("IFNULL((SELECT bangsal.nm_bangsal FROM kamar_inap INNER JOIN kamar INNER JOIN bangsal ON kamar_inap.kd_kamar = kamar.kd_kamar AND kamar.kd_bangsal = bangsal.kd_bangsal WHERE kamar_inap.no_rawat = rawat_inap_dr.no_rawat LIMIT 1), 'Ruang Terhapus') AS ruang"),
                'rawat_inap_dr.material',
                'rawat_inap_dr.bhp',
                'rawat_inap_dr.tarif_tindakandr',
                'rawat_inap_dr.kso',
                'rawat_inap_dr.menejemen',
                'rawat_inap_dr.biaya_rawat',
                'bayar_piutang.tgl_bayar'
            )
            ->join('reg_periksa', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('rawat_inap_dr', 'rawat_inap_dr.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('jns_perawatan_inap', 'rawat_inap_dr.kd_jenis_prw', '=', 'jns_perawatan_inap.kd_jenis_prw')
            ->join('dokter', 'rawat_inap_dr.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->join('bayar_piutang', 'reg_periksa.no_rawat', '=', 'bayar_piutang.no_rawat')
            ->whereBetween('bayar_piutang.tgl_bayar', [$tanggl1, $tanggl2])
            ->where(function ($query) use ($kdPenjamin, $kdDokter) {
                if ($kdPenjamin) {
                    $query->whereIn('penjab.kd_pj', $kdPenjamin);
                }
                if ($kdDokter) {
                    $query->whereIn('rawat_inap_dr.kd_dokter', $kdDokter);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderByDesc('rawat_inap_dr.no_rawat')
            ->get();

        return view('detail-tindakan.ranap-dokter', [
            'actionCari' => $actionCari,
            'penjab'=> $penjab,
            'dokter'=> $dokter,
            'ranapDokter'=> $ranapDokter,
        ]);
    }
}
