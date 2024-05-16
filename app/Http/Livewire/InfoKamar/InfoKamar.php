<?php

namespace App\Http\Livewire\InfoKamar;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class InfoKamar extends Component
{
    public function mount()
    {
        $this->loadData();
    }
    public function render()
    {
        $this->loadData();
        return view('livewire.info-kamar.info-kamar');
    }
    public $getRuangan;
    public function loadData()
    {
        try {
            $this->getRuangan = DB::connection('db_con2')->table('bw_display_bad')
                ->select('bw_display_bad.id', 'bw_display_bad.ruangan')
                ->groupBy('bw_display_bad.ruangan')
                ->get();
            $this->getRuangan->map(function ($item) {
                $item->getKamar = DB::connection('db_con2')->table('bw_display_bad')
                    ->select('bw_display_bad.kamar', 'bw_display_bad.kelas', 'bw_display_bad.kelas')
                    ->where('bw_display_bad.ruangan', $item->ruangan)
                    ->groupBy('bw_display_bad.kamar')
                    ->get();
                $item->getKamar->map(function ($item) {
                    $item->getBed = DB::connection('db_con2')->table('bw_display_bad')
                        ->select('bw_display_bad.ruangan', 'bw_display_bad.kamar', 'bw_display_bad.bad', 'bw_display_bad.status', 'bw_display_bad.kelas')
                        ->where('bw_display_bad.kamar', $item->kamar)
                        ->get();
                });
            });
        } catch (\Throwable $th) {
        }
    }
}
