<?php

use Carbon\Carbon;

$tanggal = Carbon::now();
?>
<center>
    <img src="https://media.tenor.com/LAkobF0eiDwAAAAC/assalamu-alaikum-salam.gif" alt="" width="50%">
    <h5 class="text-bold card-header bg-light p-0"> BAYAR KAS</h5>
</center>
<div class="">
    <form action="{{Route('pemasukan.store')}}" method="POST" enctype="multipart/form-data" novalidate>
        {{csrf_field()}}
        <div class="form-group row">
            <label for="anggota_id">Anggota Keluarga</label>
            <select id="anggota_id" name="anggota_id" class="select2 form-control @error('anggota_id') is-invalid @enderror">
                @if (old('anggota_id') == true)
                <option value="{{old('anggota_id')}}">{{old('nama')}}</option>
                @endif
                <option value="">-- Pilih Nama --</option>
                @foreach ($data_anggota as $data)
                <option value="{{$data->id}}"> {{$data->name}}</option>
                @endforeach
            </select>
            @error('anggota_id')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <input type="hidden" name="pengaju_id" id="pengaju_id" value="{{Auth::user()->id}}">
        @if(Auth::user()->role == "Admin")
        <div class="form-group row">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control select2 @error('kategori') is-invalid @enderror" required>

                <option value="">--Pilih kategori--</option>
                <option value="Kas">KAS</option>
                <option value="Tabungan">TABUNGAN</option>
                <option disabled value="Bayar_Pinjaman">Bayar Pinjaman</option>
            </select>
            @error('kategori')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <input type="hidden" name="tanggal" id="tanggal" value="{{$tanggal}}">
        @else
        <input type="hidden" name="tanggal" id="tanggal" value="{{$tanggal}}">
        <input type="hidden" name="kategori" id="kategori" value="Kas">
        @endif

        <div class="form-group row">
            <label for="pembayaran">Metode Pembayaran</label>
            <select name="pembayaran" id="pembayaran" class="form-control select2 @error('pembayaran') is-invalid @enderror" required>

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
            <input type="text" id="jumlah" name="jumlah" value="{{old('jumlah') }}" placeholder="Cont : 50000    jangan pake titik ataupun koma" class="number_format form-control col-12 @error('jumlah') is-invalid @enderror">
            @error('jumlah')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="textarea form-control bg-light @error('keterangan') is-invalid @enderror" id="summernote" rows="6" value="{{ old('keterangan') }}"></textarea>
            @error('keterangan')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <hr>
        <button onclick="tombol()" id="myBtn_k" type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> YUUU BAYAR</button>
        <div id="tombol_proses"></div>

    </form>
</div>