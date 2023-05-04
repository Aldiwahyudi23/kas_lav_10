 <thead>
     <tr class="bg-light">
         <th>Nama</th>
         <th>Kas</th>
         @if (Auth::user()->role == "Admin" || Auth::user()->role == "Bendahara" || Auth::user()->role == "Sekertaris")
         <th>Tabungan</th>
         @endif
     </tr>
 </thead>
 <tbody>
     <?php

        use Illuminate\Support\Facades\DB;

        $no = 0; ?>
     @foreach($data_anggota as $anggota)
     <?php $no++; ?>
     <tr>
         <td>{{$anggota->name}}</td>
         <?php
            $id = $anggota->id;

            $setor = DB::table('pemasukans')->where('pemasukans.kategori', '=', "Kas");
            $total_setor = $setor->where('pemasukans.anggota_id', '=', $id)
                ->sum('pemasukans.jumlah');

            $cek_pemasukan_terakhir_all = $setor->where('anggota_id', $id)->sum('jumlah');

            $tabungan = DB::table('pemasukans')->where('pemasukans.kategori', '=', "Tabungan");
            $total_tabungan = $tabungan->where('pemasukans.anggota_id', '=', $id)
                ->sum('pemasukans.jumlah');

            $jumlah = $total_setor;
            $jumlah_tabungan = $total_tabungan;
            // hitung sisa bayaran ==========================================
            $date = date("Y-m-d");
            $timeStart = strtotime("2022-5-01");
            $timeEnd = strtotime("$date");
            // Menambah bulan ini + semua bulan pada tahun sebelumnya
            $numBulan = 1 + (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
            // menghitung selisih bulan
            $numBulan += date("m", $timeEnd) - date("m", $timeStart);

            $all_kas = $numBulan * 50000;

            $sisa_kas = $all_kas - $cek_pemasukan_terakhir_all;
            $sisa_bulan = $sisa_kas / 50000;
            // =============================================================
            $user = DB::table('users')->find($id);
            ?>


         @if ( $user->program1 == "Kas")
         <td> <a href="{{route('detail.anggota.kas',Crypt::encrypt($anggota->id))}}"> {{ "Rp " . number_format( $jumlah,2,',','.') }} </a> <br>
             @if($sisa_kas <= 0) luarrr biasa TUNTAS <br>
                 @else Sisa <b>{{ "Rp " . number_format($sisa_kas,2,',','.') }}</b> atawa <b>{{$sisa_bulan}}</b> Bulanan
                 @endif
         </td>
         @else
         <td></td>
         @endif
         @if (Auth::user()->role == "Admin" || Auth::user()->role == "Bendahara" || Auth::user()->role == "Sekertaris")
         <td><a href="{{route('detail.anggota.tabungan',Crypt::encrypt($anggota->id))}}">{{ "Rp " . number_format( $jumlah_tabungan,2,',','.') }} </a></td>
         @endif
     </tr>

     @endforeach
 </tbody>