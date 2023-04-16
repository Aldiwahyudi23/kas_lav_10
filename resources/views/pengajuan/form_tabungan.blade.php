<center>
    <img src="https://media.tenor.com/LAkobF0eiDwAAAAC/assalamu-alaikum-salam.gif" alt="" width="50%">
    <h5 class="text-bold card-header bg-light p-0"> NABUNG BIAR TERKUMPUL</h5>
</center>
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
        <div class="form-group row">
            <label for="kategori">Nabung / Narik</label>
            <select name="kategori" id="kategori" class="form-control select2bs4 @error('kategori') is-invalid @enderror" required>

                <option value="Tabungan">Nabung</option>
                <option value="Ambil_Tabungan">Tarik Tunai</option>
            </select>
            @error('kategori')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <input type="hidden" id="anggota_id" name="anggota_id" value="{{Auth::user()->id}}">
        <hr>
        <button onclick="tombol()" id="myBtn" type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> YUUU AJUKEUN</button>
        <div id="tombol_proses"></div>
    </form>
</div>