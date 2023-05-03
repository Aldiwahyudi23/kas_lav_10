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
    Data masih di proses nuju di cek ku pengurus, nuju di<b>KONFIRMASI </b> heula.
    <br> <br> mangga<b> Cek deui</b>bilih aya nu lepat, pami bade ngedit mangga klik wae tombol <a href="{{Route('pengajuan.edit',Crypt::encrypt($data_pengajuan->id))}}" type="" class="btn btn-primary btn-sm" onclick="return confirm('Leres bade ngedit data ieu ? , Pengeditan kedah sepengetahuan nu sanes !')">Gentos data</a>
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
                                <tr>
                                    <td>Nama Anggoota</td>
                                    <td>:</td>
                                    <td>{{ $data_pengajuan->anggota->name }}</td>
                                </tr>
                                <?php

                                use App\Models\Keluarga;

                                $keluarga = Keluarga::find($data_pengajuan->pengaju_id);
                                ?>
                                @if ($data_pengajuan->anggota_id == $data_pengajuan->pengaju_id)
                                <tr>
                                    <td>Di Input Oleh</td>
                                    <td>:</td>
                                    <td>{{ $data_pengajuan->pengaju->name }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td>Nama Keluarga</td>
                                    <td>:</td>
                                    <td>{{$keluarga->nama}}</td>
                                </tr>
                                @endif

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
                        @if(Auth::user()->role == "Admin" || Auth::user()->role == "Sekertaris" || Auth::user()->role == "Bendahara")
                        <!-- Jika data Tabungan DAN kas -->
                        @if( $data_pengajuan->kategori == 'Tabungan' || $data_pengajuan->kategori == 'Kas' )
                        <form action="{{Route('pemasukan.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <button onclick="tombol()" id="myBtn" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-send"></i> KONFIRMASI</button>
                            <div id="tombol_proses"></div>

                            <input type="hidden" id="pengajuan_id" name="pengajuan_id" value="{{ $data_pengajuan->id }}">
                            <input type="hidden" id="anggota_id" name="anggota_id" value="{{ $data_pengajuan->anggota_id }}">
                            <input type="hidden" id="pengaju_id" name="pengaju_id" value="{{ $data_pengajuan->pengaju_id }}">
                            <input type="hidden" id="jumlah" name="jumlah" value=" {{ $data_pengajuan->jumlah }}">
                            <input type="hidden" id="keterangan" name="keterangan" value="{{ $data_pengajuan->keterangan }}">
                            <input type="hidden" id="tanggal" name="tanggal" value="{{ $data_pengajuan->created_at }}">
                            <input type="hidden" id="kategori" name="kategori" value="{{ $data_pengajuan->kategori }}">
                            <input type="hidden" id="pembayaran" name="pembayaran" value="{{ $data_pengajuan->pembayaran }}">
                            <input type="hidden" id="foto1" name="foto1" value="{{ $data_pengajuan->foto }}">

                        </form>
                        @endif
                        <!-- Jika data Tabungan DAN kas -->
                        @if( $data_pengajuan->kategori == 'Ambil_Tabungan')
                        <form action="{{Route('tarik_tabungan')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <b><i class="fas fa-info"></i> INFO !!!</b> <br>
                                Pami bade ngalaporkeun mangga Tanda Bukti Transferanna na cantumkeun di alasan pengaju
                                <br> <br> Tombol<b> SETUJUI</b> nu di handap Fungsina kanggo ngakomfirmasi bahwa pengambilan atau Tarik Tabungan Atos di Transfer atau di pasihkeun.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="keterangan">keterangan</label>
                                <textarea name="keterangan" class="textarea form-control bg-light @error('keterangan') is-invalid @enderror" id="summernote" rows="6" value="{{ old('keterangan') }}">{!!$data_pengajuan->keterangan!!}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <input type="hidden" id="pengajuan_id" name="pengajuan_id" value="{{ $data_pengajuan->id }}">
                            <input type="hidden" id="anggaran_id" name="anggaran_id" value="7">
                            <input type="hidden" id="anggota_id" name="anggota_id" value="{{ $data_pengajuan->anggota_id }}">
                            <input type="hidden" id="pengaju_id" name="pengaju_id" value="{{ $data_pengajuan->pengaju_id }}">
                            <input type="hidden" id="jumlah" name="jumlah" value=" {{ $data_pengajuan->jumlah }}">
                            <input type="hidden" id="tanggal" name="tanggal" value="{{ $data_pengajuan->created_at }}">
                            <input type="hidden" id="status" name="status" value="Sukses">
                            <input type="hidden" id="pembayaran" name="pembayaran" value="{{ $data_pengajuan->pembayaran }}">
                            <input type="hidden" id="foto1" name="foto1" value="{{ $data_pengajuan->foto }}">

                            <button onclick="tombol()" id="myBtn" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-send"></i> YUUU KASIH</button>
                            <div id="tombol_proses"></div>
                        </form>
                        @endif
                        <!-- Jika data Bayar Pinjaman di pisah karena beda tabel -->
                        @if( $data_pengajuan->kategori == 'Bayar_Pinjaman')
                        <form action="{{Route('pinjaman.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <button onclick="tombol()" id="myBtn" type="submit" class="btn btn-primary btn-sm"><i class="fas fa-send"></i> KONFIRMASI</button>
                            <div id="tombol_proses"></div>

                            <input type="hidden" id="pengajuan_id" name="pengajuan_id" value="{{ $data_pengajuan->id }}">
                            <input type="hidden" id="anggota_id" name="anggota_id" value="{{ $data_pengajuan->anggota_id }}">
                            <input type="hidden" id="pengaju_id" name="pengaju_id" value="{{ $data_pengajuan->pengaju_id }}">
                            <input type="hidden" id="jumlah" name="jumlah" value=" {{ $data_pengajuan->jumlah }}">
                            <input type="hidden" id="keterangan" name="keterangan" value="{{ $data_pengajuan->keterangan }}">
                            <input type="hidden" id="tanggal" name="tanggal" value="{{ $data_pengajuan->created_at }}">
                            <input type="hidden" id="kategori" name="kategori" value="{{ $data_pengajuan->kategori }}">
                            <input type="hidden" id="pembayaran" name="pembayaran" value="{{ $data_pengajuan->pembayaran }}">
                            <input type="hidden" id="foto1" name="foto1" value="{{ $data_pengajuan->foto }}">
                            <input type="hidden" id="lama" name="lama" value="{{ $data_pengajuan->lama }}">
                            <input type="hidden" id="sekertaris" name="sekertaris" value="{{ $data_pengajuan->sekertaris }}">
                            <input type="hidden" id="pengeluaran_id" name="pengeluaran_id" value="{{ $data_pengajuan->pengeluaran_id }}">

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