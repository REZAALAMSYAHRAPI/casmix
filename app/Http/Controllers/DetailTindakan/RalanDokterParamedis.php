<?php

namespace App\Http\Controllers\DetailTindakan;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RalanDokterParamedis extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    function RalanDokterParamedis(Request $request) {
        $penjab = $this->cacheService->getPenjab();
        $petugas = $this->cacheService->getPetugas();
        $dokter = $this->cacheService->getDokter();

        $kdPenjamin = ($request->input('kdPenjamin') == null) ? "" : explode(',', $request->input('kdPenjamin'));
        $kdPetugas = ($request->input('kdPetugas') == null) ? "" : explode(',', $request->input('kdPetugas'));
        $kdDokter = ($request->input('kdDokter')  == null) ? "" : explode(',', $request->input('kdDokter'));
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;

        $RalanDRParamedis = DB::table('pasien')
            ->select('rawat_jl_drpr.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'rawat_jl_drpr.kd_jenis_prw',
                'jns_perawatan.nm_perawatan',
                'rawat_jl_drpr.kd_dokter',
                'dokter.nm_dokter',
                'rawat_jl_drpr.nip',
                'petugas.nama',
                'rawat_jl_drpr.tgl_perawatan',
                'rawat_jl_drpr.jam_rawat',
                'penjab.png_jawab',
                'poliklinik.nm_poli',
                'rawat_jl_drpr.material',
                'rawat_jl_drpr.bhp',
                'rawat_jl_drpr.tarif_tindakandr',
                'rawat_jl_drpr.tarif_tindakanpr',
                'rawat_jl_drpr.kso',
                'rawat_jl_drpr.menejemen',
                'rawat_jl_drpr.biaya_rawat',
                'bayar_piutang.tgl_bayar')
            ->join('reg_periksa','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('rawat_jl_drpr','rawat_jl_drpr.no_rawat','=','reg_periksa.no_rawat')
            ->join('jns_perawatan','rawat_jl_drpr.kd_jenis_prw','=','jns_perawatan.kd_jenis_prw')
            ->join('dokter','rawat_jl_drpr.kd_dokter','=','dokter.kd_dokter')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
            ->join('petugas','rawat_jl_drpr.nip','=','petugas.nip')
            ->join('bayar_piutang','reg_periksa.no_rawat','=','bayar_piutang.no_rawat')
            ->whereBetween('bayar_piutang.tgl_bayar',[$tanggl1,$tanggl2])
            ->where(function ($query) use ($kdPenjamin, $kdPetugas, $kdDokter) {
                if ($kdPenjamin) {
                    $query->whereIn('penjab.kd_pj', $kdPenjamin);
                }
                if ($kdPetugas) {
                    $query->whereIn('petugas.nip', $kdPetugas);
                }
                if ($kdDokter) {
                    $query->whereIn('rawat_jl_drpr.kd_dokter', $kdDokter);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderBy('rawat_jl_drpr.no_rawat','desc')
            ->get();

        return view('detail-tindakan.ralan-dokter-paramedis',[
            'penjab'=>$penjab,
            'petugas'=>$petugas,
            'dokter'=>$dokter,
            'RalanDRParamedis'=>$RalanDRParamedis,
        ]);
    }
}
