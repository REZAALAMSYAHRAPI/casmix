<div>
    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('color') }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-{{ Session::get('icon') }}"></i> {{ Session::get('message') }}!
        </div>
    @endif
    <section class="content ">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group input-group-xs">
                        <input type="search" wire:model.lazy="cariNomor" class="form-control form-control-xs"
                            placeholder="Cari Nama / No.Rm / No.Rawat">
                        <div class="input-group-append">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div class="input-group input-group-xs">
                        <div class="input-group-append">
                            <button wire:click="getListCasemix()" class="btn btn-md btn-primary">
                                <span>
                                    <span wire:loading.remove wire:target="getListCasemix">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <span wire:loading wire:target="getListCasemix">
                                        <span class="spinner-grow spinner-grow-sm" role="status"
                                            aria-hidden="true"></span> Mencari...
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <table class="table table-sm table-bordered" style="white-space: nowrap;">
        <thead>
            <tr>
                <th>ID</th>
                <th>No. Rekam Medis</th>
                <th>No. Rawat</th>
                <th>Nama Pasien</th>
                <th>Jenis Berkas</th>
                <th>File</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($getDataListCasemix->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">Silahkan Cari Data</td>
                </tr>
            @else
                @foreach ($getDataListCasemix as $key => $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->no_rkm_medis }}</td>
                        <td>{{ $item->no_rawat }}</td>
                        <td>{{ $item->nama_pasein }}</td>
                        <td>{{ $item->jenis_berkas }}</td>
                        <td>{{ $item->file }}</td>
                        <td>
                            <div class="badge-group d-flex justify-content-around">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="deleteDataFile('{{ $item->id }}', '{{ $item->jenis_berkas }}', '{{ $item->file }}')"
                                    data-dismiss="modal">
                                    <i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
