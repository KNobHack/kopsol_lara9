<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiAddProdukRequest;
use App\Models\Anggota;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::with('anggota')->get();
        return view('transaksi.index', ['transaksi' => $transaksi]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $daftar_anggota = Anggota::all();
        return view('transaksi.create', ['daftar_anggota' => $daftar_anggota,]);
    }

    public function createAnggota(Anggota $anggota)
    {
        // Data esensial
        $daftar_anggota = Anggota::all();
        $daftar_tagihan = [];
        $daftar_produk = Produk::all();

        // data draft transaksi
        $draft_transaksi = [];
        $draft_transaksi_session = session('draft_transaksi');
        if (isset($draft_transaksi_session['anggota'][$anggota->id])) {
            $draft_transaksi = collect($draft_transaksi_session['anggota'][$anggota->id]);
            $draft_transaksi = $draft_transaksi->pluck('transaksi');
        }

        // dd($draft_transaksi);

        return view(
            'transaksi.create',
            [
                'daftar_anggota' => $daftar_anggota,
                'daftar_tagihan' => $daftar_tagihan,
                'daftar_produk' => $daftar_produk,
                'pelaku' => $anggota, // anggota yang akan transaksi
                'draft_transaksi' => $draft_transaksi ?? [],
                'form_action_add_produk' => route('transaksi.create.for.anggota.add.produk', $anggota)
            ]
        );
    }

    public function anggotaAddProduk(TransaksiAddProdukRequest $request, Anggota $anggota)
    {
        $produk = Produk::findOrFail($request->validated('produk_id'));
        session()->push(
            "draft_transaksi.anggota.{$anggota->id}",
            [
                'transaksi' => [
                    ...$request->validated(),
                    'nama' => $produk->nama_produk,
                    'nominal_satuan' => $produk->harga,
                    'nominal_total' => $produk->harga * $request->validated('jumlah'),
                ],
                'tipe' => 'produk',
            ]
        );

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
