<?php

namespace App\Http\Controllers;

use App\Models\NonAnggota;
use App\Http\Requests\StoreNonAnggotaRequest;
use App\Http\Requests\UpdateNonAnggotaRequest;

class NonAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $non_anggota = NonAnggota::all();
        return view('non-anggota.index', ['non_anggota' => $non_anggota]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('non-anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNonAnggotaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNonAnggotaRequest $request)
    {
        NonAnggota::create($request->validated());

        return redirect()->route('non-anggota.index')
            ->with('alert', [[
                'mode' => 'success',
                'message' => 'Data Non-Anggota berhasil ditambahkan'
            ]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NonAnggota  $nonAnggota
     * @return \Illuminate\Http\Response
     */
    public function show(NonAnggota $nonAnggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NonAnggota  $nonAnggota
     * @return \Illuminate\Http\Response
     */
    public function edit(NonAnggota $nonAnggota)
    {
        return view('non-anggota.edit', ['non_anggota' => $nonAnggota]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNonAnggotaRequest  $request
     * @param  \App\Models\NonAnggota  $nonAnggota
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNonAnggotaRequest $request, NonAnggota $nonAnggota)
    {
        $nonAnggota->update($request->validated());

        return redirect()->route('non-anggota.index')
            ->with('alert', [[
                'mode' => 'success',
                'message' => 'Data Non-Anggota berhasil diedit'
            ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NonAnggota  $nonAnggota
     * @return \Illuminate\Http\Response
     */
    public function destroy(NonAnggota $nonAnggota)
    {
        $nonAnggota->delete();

        return redirect()->route('non-anggota.index')
            ->with('alert', [[
                'mode' => 'success',
                'message' => 'Data Non-Anggota berhasil dihapu'
            ]]);
    }
}
