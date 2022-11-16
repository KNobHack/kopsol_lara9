<?php

namespace App\Http\Controllers;

use App\Models\Simpanan as SimpananModel;
use Illuminate\Http\Request;

class Simpanan extends Controller
{
    protected $viewFolder = 'simpanan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $simpanan = SimpananModel::all();
        return $this->view('index', ['simpanan' => $simpanan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SimpananModel::create($request->all());
        return redirect('/simpanan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SimpananModel $simpanan)
    {
        return $this->view('show', ['simpanan', $simpanan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SimpananModel $simpanan)
    {
        return $this->view('edit', ['simpanan' => $simpanan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SimpananModel $simpanan)
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
    public function destroy(SimpananModel $simpanan)
    {
        $simpanan->delete();
        return redirect('/simpanan');
    }
}
