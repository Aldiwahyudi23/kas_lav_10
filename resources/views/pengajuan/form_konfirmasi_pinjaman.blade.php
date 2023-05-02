@extends('template.home')

@section('content')
<!-- Hanya Akses Admin, bendahara, dan Sekertaris -->
@if(Auth::user()->role == "Admin" || Auth::user()->role == "Sekertaris" || Auth::user()->role == "Bendahara")
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <b><i class="fas fa-info"></i> INFO !!!</b> <br>
    Data anu di handap nyaeta data pemasukan ti anggota anu atos bayar. Supados data lebet kana pendataan kas Punten ka bendahara <b>KONFIRMASI PEMABAYARAN </b> ieu sesuai keterangan anu atos anggota input
    <br> <br> Tombol<b> KONFORMASI</b> nu di handap Fungsina kanggo ngakomfirmasi bahwa pembayaran eta bener.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<!-- Kanggo pengeditan Hanya Akses Admin, dan Sekertaris -->
@if(Auth::user()->role == "Admin" | Auth::user()->role == "Sekertaris")
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Data nu di handap atos leres ?
    <br> Klik <a href="{{Route('pengajuan.edit',Crypt::encrypt($data_pengajuan->id))}}" type="" class="btn btn-primary btn-sm" onclick="return confirm('Leres bade ngedit data ieu ? , Pengeditan kedah sepengetahuan nu sanes !')">Edit</a> kanggo ngedit data,Jangkauan terbatas .
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<!-- Akses all -->
@else
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <b><i class="fas fa-info"></i> INFO !!!</b> <br>
    Data masih di proses nuju di cek ku pengurus, nuju di<b>KONFIRMASI </b> heula. @if($data_pengajuan->kategori == Auth::user()->id)
    <br> <br> mangga<b> Cek deui</b>bilih aya nu lepat, pami bade ngedit mangga klik wae tombol <a href="{{Route('pengajuan.edit',Crypt::encrypt($data_pengajuan->id))}}" type="" class="btn btn-primary btn-sm" onclick="return confirm('Leres bade ngedit data ieu ? , Pengeditan kedah sepengetahuan nu sanes !')">Gentos data</a> @endif
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <center>
                        <h5 class="text-bold card-header bg-light p-0"> {{$data_pengajuan->status}}</h5>
                    </center>
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td width="150px">Pengajuan</td>
                                    <td width="10px">:</td>
                                    <td>{{ $data_pengajuan->kategori }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Anggoota</td>
                                    <td>:</td>
                                    <td>{{ $data_pengajuan->anggota->name }}</td>
                                </tr>
                                <tr>
                                    <td>Nominal</td>
                                    <td>:</td>
                                    <td>{{ "Rp " . number_format($data_pengajuan->jumlah,2,',','.') }}</td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td>:</td>
                                    <td>{{ $data_pengajuan->pembayaran }}</td>
                                </tr>
                                <tr>
                                    <td>Tangaal Pengajuan</td>
                                    <td>:</td>
                                    <td>{{$data_pengajuan->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="">
                            <h5 class=" text-center">Keterangan</h5>
                            {!!$data_pengajuan->keterangan!!}
                            @if($data_pengajuan->foto)
                            <hr>
                            <div class="product-img">
                                <a href="{{asset($data_pengajuan->foto)}}" data-toggle="lightbox" data-title="Tanda Bukti" data-gallery="gallery">
                                    <img src="{{asset($data_pengajuan->foto)}}" alt="Product Image" width="50%" class=" brand-image elevation-3" style="display:block; margin:auto">
                                </a>
                            </div>
                            @endif
                        </div>
                        <hr>
                        <!-- Hanya Akses Admin, bendahara, dan Sekertaris -->
                        @if(Auth::user()->role == "Admin" || Auth::user()->role == "Sekertaris" || Auth::user()->role == "Bendahara" || Auth::user()->role == "Ketua")
                        <!-- Jika data Tabungan DAN kas -->
                        @if($data_pengajuan->kategori == 'Pinjaman')

                        <form action="{{Route('kirim_pengajuan.laporan',Crypt::encrypt($data_pengajuan->id))}}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('post')
                            {{csrf_field()}}
                            <input type="hidden" id="pengajuan_id" name="pengajuan_id" value="{{ $data_pengajuan->id }}">
                            <input type="hidden" id="anggota_id" name="anggota_id" value="{{ $data_pengajuan->anggota_id }}">
                            <input type="hidden" id="jumlah" name="jumlah" value=" {{ $data_pengajuan->jumlah }}">
                            <input type="hidden" id="keterangan" name="keterangan" value="{{ $data_pengajuan->keterangan }}">
                            <input type="hidden" id="tanggal" name="tanggal" value="{{ $data_pengajuan->created_at }}">
                            <input type="hidden" id="kategori" name="kategori" value="{{ $data_pengajuan->kategori }}">
                            <input type="hidden" id="pembayaran" name="pembayaran" value="{{ $data_pengajuan->pembayaran }}">
                            <input type="hidden" id="foto1" name="foto1" value="{{ $data_pengajuan->foto }}">
                            <!-- Form kanggo bendahara -->
                            @if(Auth::user()->role == "Bendahara")
                            <div class="form-group">
                                <label for="bendahara">Laporan Bendahara</label>
                                <textarea name="bendahara" class="textarea form-control bg-light @error('bendahara') is-invalid @enderror" id="summernote" rows="6" value="{{ old('bendahara') }}">{{ old('bendahara',$data_pengajuan->bendahara) }}</textarea>
                                @error('bendahara')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <!-- form kanggo sekertaris -->
                            @elseif(Auth::user()->role == "Sekertaris")
                            <div class="form-group">
                                <label for="sekertaris">Laporan Sekertaris</label>
                                <textarea name="sekertaris" class="textarea form-control bg-light @error('sekertaris') is-invalid @enderror" id="summernote" rows="6" value="{{ old('sekertaris') }}">{{ old('sekertaris',$data_pengajuan->sekertaris) }}</textarea>
                                @error('sekertaris')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <!-- Laporan kanggo ketua -->
                            @elseif( Auth::user()->role == "Ketua" || Auth::user()->role == "Admin")
                            <hr>
                            <div class="card">
                                <center>
                                    <h5 class="text-bold card-header bg-light p-0"> LAPORAN SEKERTARIS</h5>
                                </center>
                                <div class="card-body">
                                    <input type="hidden" id="sekertaris" name="sekertaris" value="{{ $data_pengajuan->sekertaris }}">
                                    <div>{!!$data_pengajuan->sekertaris!!}</div>
                                </div>
                            </div>

                            <hr>
                            <div class="card">
                                <center>
                                    <input type="hidden" id="bendahara" name="bendahara" value="{{ $data_pengajuan->pembayaran }}">
                                    <h5 class="text-bold card-header bg-light p-0"> LAPORAN BENDAHARA</h5>
                                </center>
                                <div class="card-body">
                                    <div>{!!$data_pengajuan->bendahara!!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ketua">Ketua</label>
                                <textarea name="ketua" class="textarea form-control bg-light @error('ketua') is-invalid @enderror" id="summernote" rows="6" value="{{ old('ketua') }}">{{ old('sekertaris',$data_pengajuan->ketua) }}</textarea>
                                @error('ketua')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="status">Konfirmasi</label>
                                <select name="status" id="status" class="form-control select2bs4 @error('status') is-invalid @enderror" required>

                                    <option value="">--Pilih status--</option>
                                    <option value="Nunggak">Setujui</option>
                                    <option value="Tunda">Tunda</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            @else
                            @endif
                            <button onclick="tombol()" id="myBtn" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-send"></i>LAPORKAN</button>
                            <div id="tombol_proses"></div>

                        </form>
                        @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection