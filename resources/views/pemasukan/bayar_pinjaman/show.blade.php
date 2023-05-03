@extends('template.home')

@section('content')
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <b><i class="fas fa-info"></i> INFO !!!</b> <br>
    Data nu handap sesuai sareng data pengajuan anau atos di <b>KONFIRMASI PEMBAYARAN </b>,Mangga cek deui datana bilih lepat
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td width="150px">Kategori</td>
                                    <td width="10px">:</td>
                                    <td>Bayar Pinjaman</td>
                                </tr>
                                <tr>
                                    <td>Nama Anggoota</td>
                                    <td>:</td>
                                    <td>{{ $data_bayar_pinjaman->anggota->name }}</td>
                                </tr>
                                <tr>
                                    <td>Di Input oleh</td>
                                    <td>:</td>
                                    <td>{{ $data_bayar_pinjaman->pengaju->name }}</td>
                                </tr>
                                <tr>
                                    <td>Nominal Bayar</td>
                                    <td>:</td>
                                    <td>{{ "Rp " . number_format($data_bayar_pinjaman->jumlah,2,',','.') }} <br>
                                        @if($data_bayar_pinjaman->jumlah_lebih == 0)
                                        @else
                                        Terhitung pembayaran aya lebihna ({{ "Rp " . number_format($data_bayar_pinjaman->jumlah_lebih,2,',','.') }})
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td>:</td>
                                    <td>{{ $data_bayar_pinjaman->pembayaran }}</td>
                                </tr>
                                <tr>
                                    <td>Tangaal Pengajuan</td>
                                    <td>:</td>
                                    <td>{{$data_bayar_pinjaman->tanggal }}</td>
                                </tr>
                                <tr>
                                    <td>Tangaal diKonfirmasi</td>
                                    <td>:</td>
                                    <td>{{$data_bayar_pinjaman->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Anu ngaKonfirmasi</td>
                                    <td>:</td>
                                    <td>{{$data_bayar_pinjaman->pengurus->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="">
                            <h5 class=" text-center">Keterangan</h5>
                            {!!$data_bayar_pinjaman->keterangan!!}
                            @if($data_bayar_pinjaman->foto)
                            <hr>
                            <div class="product-img">
                                <a href="{{asset($data_bayar_pinjaman->foto)}}" data-toggle="lightbox" data-title="Tanda Bukti" data-gallery="gallery">
                                    <img src="{{asset($data_bayar_pinjaman->foto)}}" alt="Product Image" width="50%" class=" brand-image elevation-3" style="display:block; margin:auto">
                                </a>
                            </div>
                            @endif
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
    $("#pinjam").addClass("active");
</script>
@endsection