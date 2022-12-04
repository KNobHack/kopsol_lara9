<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiAddProdukRequest;
use App\Models\Anggota;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiMerchant;
use App\Models\Tunggakan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::with(['pelayan', 'pelaku'])->get();
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

    /**
     * Create draft for Anggota
     */
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

        return view(
            'transaksi.create',
            [
                'daftar_anggota' => $daftar_anggota,
                'daftar_tagihan' => $daftar_tagihan,
                'daftar_produk' => $daftar_produk,
                'pelaku' => $anggota, // Yang akan transaksi
                'draft_transaksi' => $draft_transaksi,
                'form_action_add_produk' => route('transaksi.add.produk.for.anggota', $anggota),
                'form_action_utang' => route('transaksi.utang.for.anggota', $anggota),
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

    public function utangAnggota(Request $request, Anggota $anggota)
    {
        if (!isset(session('draft_transaksi')['anggota'][$anggota->id])) {
            return redirect()->back()
                ->with('alert', [['mode' => 'danger', 'message' => 'Transaksi tidak boleh kosong']]);
        }

        // data draft transaksi
        $draft_transaksi = collect(session('draft_transaksi')['anggota'][$anggota->id]);

        $produk = collect();
        $total = 0;

        foreach ($draft_transaksi as  $transaksi) {

            if (!in_array($transaksi['tipe'], ['produk', 'tunggakan'])) {
                throw new Exception("Error getting transaksi tipe", 1);
            }

            if ($transaksi['tipe'] == 'produk') {
                $produk->push([
                    'produk_id' => $transaksi['transaksi']['produk_id'],
                    'jumlah_beli' => $transaksi['transaksi']['jumlah'],
                    'total_nominal' => $transaksi['transaksi']['nominal_total'],
                    'keterangan' => $transaksi['transaksi']['keterangan'],
                ]);

                $total += $transaksi['transaksi']['nominal_total'];

                continue;
            }

            // if tipe = tunggakan
            // Tudak boleh nunggak jika sedang bayar tunggakan
            return redirect()->back()
                ->with('alert', [[
                    'mode' => 'danger',
                    'message' => 'Tidak bisa menunggak ketika ingin bayar tunggakan :)'
                ]]);
        }

        $transaksi = [
            'pelayan_id' => auth()->id(),
            'pelaku_id' => $anggota->id,
            'pelaku_type' => $anggota::class,
            'nominal' => $total,
            'status' => Transaksi::STATUS['utang'],
            'keterangan' => NULL,
        ];

        DB::transaction(function () use ($transaksi, $produk) {
            $transaksi = Transaksi::create($transaksi);

            $produk = $produk->map(function ($value) use ($transaksi) {
                $value['transaksi_id'] = $transaksi->id;
                return $value;
            });

            $transaksi_merchant = TransaksiMerchant::insert($produk->toArray());
        });

        // Unset the succes transaction
        $new_session = session('draft_transaksi');
        unset($new_session['anggota'][$anggota->id]);
        session()->put('draft_transaksi', $new_session);

        return redirect()->route('transaksi.index')
            ->with('alert', [[
                'mode' => 'success',
                'message' => 'Data transaksi berhasil ditambahkan sebagai hutang'
            ]]);
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
