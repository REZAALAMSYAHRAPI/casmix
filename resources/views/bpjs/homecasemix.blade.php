@extends('..layout.layoutDashboard')
@section('title', 'Home BPJS')

@section('konten')
    <div class="row">
        <div class="col-md-12">
            <section class="content ">
                <form action="{{ url('/casemix-home-cari') }}" action="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-xs">
                                    <input type="search" name="cariNorawat" class="form-control form-control-xs"
                                        placeholder="Cari berdasarkan nomor rawat">
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group input-group-xs">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-md btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Pasien</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">RM</th>
                                <th>Nama</th>
                                <th>No_Rawat</th>
                                <th>No_SEP</th>
                                <th>Tanggl</th>
                                <th style="width: 40px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($getPasien)
                                @foreach ($getPasien as $item)
                                    <tr>
                                        <td>{{ $item->no_rkm_medis }}</td>
                                        <td>{{ $item->nm_pasien }}</td>
                                        <td>{{ $item->no_rawat }}</td>
                                        <td>{{ $item->no_sep }}</td>
                                        <td>{{ $item->tgl_registrasi }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @php
                                                    $color = isset($cekBerkas[$item->no_rawat]) ? 'bg-success' : 'bg-primary';
                                                @endphp
                                                <form action="{{ url('cariNorawat-ClaimBpjs') }}" method="">
                                                    @csrf
                                                    <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                                                    <button class="badge {{ $color }}">
                                                        <i class="fas fa-upload"> File Scan</i>
                                                    </button>
                                                </form>

                                                @php
                                                    $color2 = isset($cekBerkasKhanza[$item->no_rawat]) ? 'bg-success' : 'bg-primary';
                                                @endphp
                                                <form action="{{ url('carinorawat-casemix') }}" method=""
                                                    class="">
                                                    @csrf
                                                    <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                                                    <input name="cariNoSep" value="{{ $item->no_sep }}" hidden>
                                                    <button class="badge {{ $color2 }} mx-2">
                                                        <i class="fas fa-save"> Khanza</i>
                                                    </button>
                                                </form>

                                                @php
                                                    $color3 = isset($cekBerkasHasil[$item->no_rawat]) ? 'bg-success' : 'bg-primary';
                                                @endphp
                                                <form action="{{ url('gabung-berkas-casemix') }}" method="">
                                                    @csrf
                                                    <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                                                    <button class="badge {{ $color3 }}">
                                                        <i class="fas fa-save"> Gabung</i>
                                                    </button>
                                                </form>
                                                @if ($downloadFile)
                                                    <a href="{{ url('hasil_pdf/' . $downloadFile->file) }}" download
                                                        class="ml-2 text-success">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Silahkan cari berdasarkan No.Rawat /
                                        RM / No.Sep</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
