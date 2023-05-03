@extends('template.home')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DETAIL DATA BANTUAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>bantuan</td>
                        <td>:</td>
                        <td>{{$data_bantuan->nama_bantuan}}</td>
                    </tr>

                    @php
                    $bulan = date('m');
                    $tahun = date('Y');
                    @endphp
                    <tr>
                    <tr>
                        <td>Tahun</td>
                        <td>:</td>
                        <td>
                            @if ($bulan > 6)
                            {{ $tahun }}/{{ $tahun+1 }}
                            @else
                            {{ $tahun-1 }}/{{ $tahun }}
                            @endif
                        </td>
                    </tr>

                </table>
                <table class="table table-hover table-head-fixed" id='tabelAgendaMasuk'>
                    <hr>
                    <p> {!! $data_bantuan->deskripsi !!}</p>
                </table>

                @if ($data_bantuan->video == true)
                <center>
                    <p>Cek Video na</p>
                </center>
                <video src="{{asset($data_bantuan->video)}}" controls width="100%"></video>
                @else
                @endif
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

@endsection