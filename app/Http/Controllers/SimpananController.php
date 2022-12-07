<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function index(Builder $simpanan)
    {
        $simpanan->with('anggota')->get();
        return view('simpanan.index', ['simpanan' => $simpanan]);
    }

    public function simpananWajib()
    {
        $simpanan = Simpanan::where([
            'jenis' => Simpanan::JENIS['wajib'],
        ]);

        return $this->index($simpanan);
    }

    public function simpananSukarela()
    {
        $simpanan = Simpanan::where([
            'jenis' => Simpanan::JENIS['sukarela'],
        ]);

        return $this->index($simpanan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('simpanan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Simpanan::create($request->all());
        return redirect('/simpanan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Simpanan $simpanan)
    {
        return view('simpanan.show', ['simpanan', $simpanan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Simpanan $simpanan)
    {
        return view('simpanan.edit', ['simpanan' => $simpanan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Simpanan $simpanan)
    {
        $simpanan->update($request->all());
        return redirect('/simpanan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Simpanan $simpanan)
    {
        $simpanan->delete();
        return redirect('/simpanan');
    }
}
