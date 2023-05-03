<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_bantuan = Bantuan::all();

        return view('admin.bantuan.index', compact('data_bantuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_bantuan' => 'Required|unique:bantuans',
                'deskripsi' => 'required',

            ],
            [
                'nama_bantuan.required'  => "bantuan Kedah di isian",
                'nama_bantuan.unique'  => "bantuan atos aya",
                'deskripsi.required'  => "Deskripsi kedah di isi sareng detail",
            ]
        );
        if ($request->video) {
            $file = $request->file('video');
            $nama = 'Video-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/video/bantuan'), $nama);
        }

        $data = new Bantuan();
        $data->nama_bantuan     = $request->nama_bantuan;
        $data->deskripsi        = $request->deskripsi;
        if ($request->video) {
            $data->video          = "/video/bantuan/$nama";
        }

        $data->save();
        return redirect()->back()->with('sukses', 'Data bantuan Parantos ka simpen');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data_bantuan = Bantuan::find($id);

        return view('admin.bantuan.show', compact('data_bantuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $bantuan = Bantuan::find($id);
        $data_bantuan = Bantuan::all();

        return view('admin.bantuan.edit', compact('bantuan', 'data_bantuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate(
            [
                'nama_bantuan' => 'Required',
                'deskripsi' => 'required',

            ],
            [
                'nama_bantuan.required'  => "bantuan Kedah di isian",
                'deskripsi.required'  => "Deskripsi kedah di isi sareng detail",
            ]
        );

        if ($request->video) {
            $file = $request->file('video');
            $nama = 'Video-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/video/bantuan'), $nama);
        }

        $data = Bantuan::find($id);
        $data->nama_bantuan     = $request->nama_bantuan;
        $data->deskripsi        = $request->deskripsi;
        if ($request->video) {
            $data->video          = "/video/bantuan/$nama";
        }

        $data->update();
        return redirect()->back()->with('infoes', 'Data bantuan Parantos ka geuntos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $data_bantuan = Bantuan::find($id);

        $data_bantuan->delete();

        return redirect()->back()->with('kuning', 'Data Parantos di hapus tina disimpen dina sampah )');
    }
    public function trash()
    {
        $data_bantuan = Bantuan::onlyTrashed()->get();

        return view('admin.bantuan.trash', compact('data_bantuan'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $data_bantuan = Bantuan::withTrashed()->findorfail($id);
        $data_bantuan->restore();
        return redirect()->back()->with('infoes', 'Data bantuan atos di kembalikeun deui tina sampah');
    }

    public function kill($id)
    {
        $id = Crypt::decrypt($id);
        $data_bantuan = Bantuan::withTrashed()->findorfail($id);

        $data_bantuan->forceDelete();
        return redirect()->back()->with('kuning', 'Data bantuan parantos di hapus dina sampah');
    }

    public function bantuan($id)
    {
        $id = Crypt::decrypt($id);
        $detail_bantuan = Bantuan::find($id);
        $data_bantuan = Bantuan::all();

        return view('peraturan.bantuan', compact('data_bantuan', 'detail_bantuan'));
    }
    public function login()
    {

        $detail_bantuan = Bantuan::find(1);
        $data_bantuan = Bantuan::all();

        return view('bantuan.index', compact('data_bantuan', 'detail_bantuan'));
    }
}
