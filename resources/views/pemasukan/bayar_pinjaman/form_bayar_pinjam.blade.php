@extends('template.home')

@section('content')
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <b><i class="fas fa-info"></i> INFO !!!</b> <br>
    Data nu handap sesuai sareng data pengeluaran anu tos di<b>KONFIRMASI</b> ku pengurus ,Mangga cek deui datana bilih lepat
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td width="150px">Anggaran</td>
                                    <td width="10px">:</td>
                                    <td>{{ $data_pinjaman->anggaran->nama_anggaran }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Anggota</td>
                                    <td>:</td>
                                    <td>{{ $data_pinjaman->anggota->name }}</td>
                                </tr>
                                <?php

                                use App\Models\Keluarga;

                                $keluarga = Keluarga::find($data_pinjaman->keluarga_id);
                                ?>
                                @if ($data_pinjaman->anggota_id == $data_pinjaman->keluarga_id)

                                @else
                                <tr>
                                    <td>Nama Keluarga</td>
                                    <td>:</td>
                                    <td>{{$keluarga->nama}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Nominal</td>
                                    <td>:</td>
                                    <td>{{ "Rp " . number_format($data_pinjaman->jumlah,2,',','.') }}</td>
                                </tr>
                                <tr>
                                    <td>Di Setujui Oleh</td>
                                    <td>:</td>
                                    <td>{{$data_pinjaman->pengurus->name}}</td>
                                </tr>
                                <tr>
                                    <td>Tangaal Pengajuan</td>
                                    <td>:</td>
                                    <td>{{$data_pinjaman->tanggal }}</td>
                                </tr>
                                <tr>
                                    <td>Tangaal diKonfirmasi</td>
                                    <td>:</td>
                                    <td>{{$data_pinjaman->created_at }}</td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="">
                            <h5 class=" text-center">Keterangan</h5>
                            {!!$data_pinjaman->alasan!!}

                        </div>
                        <hr>

                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <p class="lead">Catatan :</p>
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            - Pemabayaran pinjaman tiasa di cicil, salami 3 bulan lunas <br>
                            - Di usahakeun lunas salami 3 bulan sesuai ketentuan nu tos di tangtoskeun
                            - Bayar tiasa lewat transfer atawa langsung bayar tunai
                        </p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>
                                        <center>Pembayaran</center>
                                    </th>
                                </tr>
                                <?php
                                $no = 0;
                                ?>
                                @foreach($bayar_pinjam as $data)
                                <?php
                                $no++;
                                ?>
                                <tr>
                                    <th> <a href="{{Route('pinjaman.edit',Crypt::encrypt($data->id))}}"> bayar {{$no}}</a> </th>
                                    <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }} <br> <br>
                                        @if($data->jumlah_lebih == 0)
                                        @else
                                        Terhitung pembayaran aya lebihna <b> ({{ "Rp " . number_format($data->jumlah_lebih,2,',','.') }})</b> Masuk kana Dana KAS
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @if ($total_bayar_pinjam - $data_pinjaman->jumlah >= 1)
                                <tr>
                                    <th>Lebihna</th>
                                    <td>
                                        <b>{{ "Rp " . number_format($total_bayar_pinjam - $data_pinjaman->jumlah ,2,',','.') }}</b> (Masuk Kana Dana Kas)
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        @if ( $total_bayar_pinjam >= $data_pinjaman->jumlah )
                        <div class="callout callout-danger alert alert-success alert-dismissible fade show">
                            <h5><i class="fas fa-info"></i> LUNAS :</h5>
                            - Pelunasan salami {{$no}} kali ! <br>
                            - Hatur nuhun atos bertanggung jawab kana syarat & ketentuan anu tos di sepakati, hapunten bilih artos peminjaman ieu kurang mencukupi. soal na anggran ieu kedah di bagi rata sareng nu sanes !
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @else
                        <div class="callout callout-danger alert alert-warning alert-dismissible fade show">
                            <h5><i class="fas fa-info"></i> Nunggak :</h5>
                            - Pembayaran nembe ka {{$no}} ! <br>
                            - Jumlah Pemasukan bayar pinjaman nembe ka tampi <b>{{ "Rp " . number_format($total_bayar_pinjam,2,',','.') }}</b> ! <br>
                            - Sisa Tagihan <b>{{ "Rp " . number_format($total_bayar_pinjam - $data_pinjaman->jumlah ,2,',','.') }}</b> !
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @if ($data_pinjaman->anggota_id == Auth::user()->id)
                        @if ($cek_pengajuan == 0)
                        <center>
                            <h5 class="text-bold card-header bg-light p-0"> BAYAR TABUNGAN</h5>
                        </center>
                        <form id="basic-form" action="{{Route('pengajuan.store')}}" method="POST" enctype="multipart/form-data" novalidate>
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="pembayaran">Metode Pembayaran</label>
                                <select name="pembayaran" id="pembayaran" class="form-control select2bs4 @error('pembayaran') is-invalid @enderror" required>

                                    <option value="">--Pilih Pembayaran--</option>
                                    <option value="Cash">Uang Tunai</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                                @error('pembayaran')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row" id="noId"></div>
                            <div class="form-group row">
                                <label for="jumlah">Nominal</label>
                                <input type="hidden" name="anggota_id" id="anggota_id" value="{{Auth::id()}}">
                                <input type="hidden" name="kategori" id="kategori" value="Bayar_Pinjaman">
                                <input type="hidden" id="sekertaris" name="sekertaris" value="{{$total_bayar_pinjam}}">
                                <input type="hidden" id="lama" name="lama" value="{{$no}}">
                                <input type="hidden" id="pengeluaran_id" name="pengeluaran_id" value="{{ $data_pinjaman->id }}">
                                <input type="text" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="Cont : 50000    jangan pake titik ataupun koma" class="form-control col-12 @error('jumlah') is-invalid @enderror">
                                @error('jumlah')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="textarea form-control bg-light @error('keterangan') is-invalid @enderror" id="summernote" rows="6" value="{{ old('keterangan') }}">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <hr>
                            <button onclick="tombol()" id="myBtn" type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> YUUU BAYAR</button>
                            <div id="tombol_proses"></div>
                        </form>
                        @else

                        <body class="justify-content-center">
                            <center>
                                <h3><b> HALLOOOO.....</b></h3>
                                <h3>Pembayaran Pinjaman Nuju di Proses</h3>
                                <img src="https://c.tenor.com/Z8ezUHZzcLoAAAAC/love.gif" alt="" width="50%">
                                <h3>Hatur Nuhun Atas kerja Samana, Bismillah sukses</h3>
                                <h5>Harappp di antos dicek ka bendahara sareng sekertaris </h5>
                            </center>
                        </body>
                        @endif
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script>
    $("#bayar").addClass("active");
</script>
@endsection