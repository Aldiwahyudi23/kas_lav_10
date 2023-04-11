 <thead>
     <tr>
         <th>No</th>
         <th>Anggaran</th>
         <th>Nominal</th>
         <th>Bulan</th>
         <th>Aksi</th>
     </tr>
 </thead>
 <tbody>
     <?php $no = 0; ?>
     @php
     $total = 0;
     @endphp
     @foreach($dana_amal as $data)
     <?php $no++; ?>
     <tr>
         <td>{{$no}}</td>
         <td>{{$data->anggaran->nama_anggaran}}</td>
         <td>{{ "Rp " . number_format($data->jumlah,2,',','.') }}</td>
         <td>{{date('M-y',strtotime($data->tanggal)) }}</td>
         <td>
             <form action="{{route('pengeluaran.destroy',Crypt::encrypt($data->id))}}" method="POST">
                 @csrf
                 @method('delete')
                 <a href="{{route('pengeluaran.show',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-book"></i></a>
                 @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Sekertaris')
                 <a href="{{route('pengeluaran.edit',Crypt::encrypt($data->id))}}" class=""><i class="nav-icon fas fa-pencil-alt"></i></a>
                 @endif
                 @if (auth()->user()->role == 'Admin')
                 <button class="btn btn-link btn-sm mt-2"><i class="nav-icon fas fa-trash-alt" onclick="return confirm('Leres bade ngahapus data anu namina   ?')"></i> </button>
                 @endif
             </form>
         </td>

     </tr>

     @endforeach
 </tbody>