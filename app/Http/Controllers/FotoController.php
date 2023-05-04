<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);
        $data_foto = Foto::find($id);

        $data_foto->delete();

        return redirect()->back()->with('kuning', 'Data Parantos di hapus tina disimpen dina sampah )');
    }
    public function trash()
    {
        $data_foto = Foto::onlyTrashed()->get();

        return view('admin.master_data.data_keluarga.profile.trash', compact('data_foto'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $data_foto = Foto::withTrashed()->findorfail($id);
        $data_foto->restore();
        return redirect()->back()->with('infoes', 'Data foto atos di kembalikeun deui tina sampah');
    }

    public function kill($id)
    {
        $id = Crypt::decrypt($id);
        $data_foto = Foto::withTrashed()->findorfail($id);

        $data_foto->forceDelete();
        return redirect()->back()->with('kuning', 'Data foto parantos di hapus dina sampah');
    }
}
