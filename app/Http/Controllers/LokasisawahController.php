<?php

namespace App\Http\Controllers;

use App\Models\Kegiatansawah;
use App\Models\Kspestisida;
use App\Models\Kspupuk;
use App\Models\Lokasisawah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class LokasisawahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $lokasisawahs = Lokasisawah::where('user_id', $user_id)
            ->join('kabupatens', 'kabupatens.id', '=', 'lokasisawahs.kabupaten_id')
            ->select('lokasisawahs.*', 'kabupatens.kabupaten_nama')
            ->where('lokasisawahs.lokasisawah_status', 0)
            ->get();

        // return dd($lokasisawahs);
        return view('/pages/lokasisawah/viewlokasisawah', compact('lokasisawahs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $kabupatens = DB::table('kabupatens')->orderBy('kabupaten_nama', 'ASC')->get();
        $data['kabupatens'] = $kabupatens;
        // return dd($data);
        return view('pages/lokasisawah/addlokasisawah', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // user id
        $user_id = auth()->user()->id;

        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id'
        ], [
            'kabupaten_id' => '*Field ini wajib diisi'
        ]);

        $lokasisawahs = Lokasisawah::create([
            'user_id' => $user_id,
            'iot_id' => $request->iot_id,
            'lokasisawah_latitude' => $request->lokasisawah_latitude,
            'lokasisawah_longitude' => $request->lokasisawah_longitude,
            'kabupaten_id' => $request->kabupaten_id,
            'lokasisawah_keterangan' => $request->lokasisawah_keterangan,
            'lokasisawah_status' => $request->lokasisawah_status
        ]);

        // Code Send API data sensor IoT
        
        // End Code Send data sensor IoT

        return redirect('/viewlokasisawah')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = auth()->user()->id;

        $lokasisawahs = Lokasisawah::where('user_id', $user_id)
            ->find($id);
    
        if (!$lokasisawahs) {
            return redirect('/viewlokasisawah')->with('error', 'Data tidak ditemukan');
        }
    
        $kabupatens = DB::table('kabupatens')->orderBy('kabupaten_nama', 'ASC')->get();
        $data['kabupatens'] = $kabupatens;
        $data['lokasisawahs'] = $lokasisawahs;
        
        // return dd($data);
        return view('pages/lokasisawah/editlokasisawah', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lokasisawahs = Lokasisawah::where('id', $id)->where('user_id', auth()->user()->id)->first();

        if (!$lokasisawahs) {
            return redirect('/viewlokasisawah')->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'kabupaten_id' => 'required|exists:kabupatens,id'
        ], [
            'kabupaten_id' => '*Field ini wajib diisi'
        ]);

        $lokasisawahs->update([
            'iot_id' => $request->iot_id,
            'lokasisawah_latitude' => $request->lokasisawah_latitude,
            'lokasisawah_longitude' => $request->lokasisawah_longitude,
            'kabupaten_id' => $request->kabupaten_id,
            'lokasisawah_keterangan' => $request->lokasisawah_keterangan,
        ]);

        return redirect('/viewlokasisawah')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lokasisawahs = Lokasisawah::find($id);
        if (!$lokasisawahs) {
            return redirect('/viewlokasisawah')->with('error', 'Data tidak ditemukan');
        }
        $lokasisawahs->delete();
        return redirect('/viewlokasisawah')->with('success', 'Data berhasil dihapus');
        
        // jika menghapus data lokasi sawah, maka data kegiatan penanaman bawang, kegiatan pestisida, kegiatan pupuk juga akan ikut terhapus
        // $user_id = auth()->user()->id;

        // $lokasisawahs = Lokasisawah::find($id);
        // $kegiatansawahs = Kegiatansawah::where('id', $id)->where('user_id', auth()->user()->id)->first();
        // $kspupuks = Kspupuk::where('id', $id)->where('user_id', auth()->user()->id)->first();
        // $kspestisidas = Kspestisida::where('id', $id)->where('user_id', auth()->user()->id)->first();
        
        // // lokasi sawah
        // if (!$lokasisawahs) {
        //     return redirect('/viewlokasisawah')->with('error', 'Data tidak ditemukan');
        // }

        // $lokasisawahs->delete();

        // // kegiatan penanaman bawang
        // if (!$kegiatansawahs) {
        //     return redirect('/viewlokasisawah')->with('success', 'Data berhasil dihapus');
        // }

        // $kegiatansawahs->delete();

        // // kegiatan pupuk
        // if (!$kspupuks) {
        //     return redirect('/viewlokasisawah')->with('success', 'Data berhasil dihapus');
        // }

        // $kspupuks->delete();

        // // kegiatan pestisida
        // if (!$kspestisidas) {
        //     return redirect('/viewlokasisawah')->with('success', 'Data berhasil dihapus');
        // }

        // $kspestisidas->delete();

        // return redirect('/viewlokasisawah')->with('success', 'Data berhasil dihapus');
    }
}
