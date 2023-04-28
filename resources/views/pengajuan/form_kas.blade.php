<center>
    <img src="https://media.tenor.com/LAkobF0eiDwAAAAC/assalamu-alaikum-salam.gif" alt="" width="50%">
    <h5 class="text-bold card-header bg-light p-0"> BAYAR KAS</h5>
</center>
@if ($cek_pemasukan_terakhir_total == 0)
<center>
    <h5>Teu acan aya kas nu masuk</h5>
</center>
@else
<table id="" class="table table-bordered ">
    <tbody>
        @foreach ($cek_pemasukan_terakhir as $data)
        <tr>
            <td>Pembayaran terakhir <b> {{$data->anggota->name}} </b> di Bulan <b> {{date('M-y',strtotime($data->tanggal)) }} </b></td>
        </tr>
        <tr>
            <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>
        </tr>
        <tr>
            <td>Tanggal pengajuan {{$data->tanggal}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="">
    <h6 class=" text-center">Keterangan</h6>
    {!!$data->keterangan!!}
</div>
@endif
<hr>

<div class="">
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
            <input type="hidden" name="pengaju_id" id="pengaju_id" value="{{Auth::id()}}">
            <input type="hidden" name="kategori" id="kategori" value="Kas">
            <input type="text" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="Cont : 50000    jangan pake titik ataupun koma" class="form-control col-12 @error('jumlah') is-invalid @enderror">
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
        <button onclick="tombol_kas()" id="myBtn_k" type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> YUUU BAYAR</button>
        <div id="tombol_proses"></div>
    </form>
</div>