<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiAddFromProdukRequest;
use App\Http\Requests\TransaksiAddFromSimpananRequest;
use App\Http\Requests\TransaksiAddFromSukarelaRequest;
use App\Models\Anggota;
use App\Models\Produk;
use App\Models\Simpanan;
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
    public function index(Request $request)
    {
        $transaksi = Transaksi::with(['pelayan', 'pelaku'])
            ->bulanFilter()->get();
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
        $daftar_tunggakan = $anggota->tunggakan->where('status', Tunggakan::STATUS['belum_lunas']);
        $daftar_produk = Produk::all();

        // data draft transaksi
        $draft_transaksi = collect();
        $draft_transaksi_session = session('draft_transaksi');
        if (isset($draft_transaksi_session['anggota'][$anggota->id])) {
            // for table view
            $draft_transaksi = collect($draft_transaksi_session['anggota'][$anggota->id]);

            // get only tunggakan
            $draft_transaksi_tunggakan = $draft_transaksi
                ->filter(function ($value) {
                    return $value['tipe'] === 'tunggakan';
                });

            // get only sukarela
            $draft_transaksi_sukarela = $draft_transaksi
                ->filter(function ($value) {
                    return $value['tipe'] === 'sukarela';
                });

            // daftar tunggakan filter added tunggakan
            $daftar_tunggakan = $daftar_tunggakan
                ->whereNotIn('id', $draft_transaksi_tunggakan->pluck('tunggakan_id'));
        }

        // Route Generating draft transaksi remove
        $draft_transaksi_remove_routes = [];
        foreach ($draft_transaksi as $key => $value) {
            $draft_transaksi_remove_routes[] = route('transaksi.remove.for.anggota', ['anggota' => $anggota, 'index' => $key]);
        }

        // Route generating daftar tunggakan
        $daftar_tunggakan_routes = [];
        foreach ($daftar_tunggakan as $tunggakan) {
            $daftar_tunggakan_routes[] = route(
                'transaksi.add.from.tunggakan.for.anggota',
                ['anggota' => $anggota, 'tunggakan' => $tunggakan]
            );
        }

        $can_utang = (isset($draft_transaksi_tunggakan))
            ? $draft_transaksi_tunggakan->isEmpty()
            : true;

        $can_utang = (isset($draft_transaksi_sukarela))
            ? $draft_transaksi_sukarela->isEmpty()
            : true;

        return view(
            'transaksi.create',
            [
                'daftar_anggota' => $daftar_anggota,
                'daftar_tunggakan' => $daftar_tunggakan,
                'daftar_produk' => $daftar_produk,
                'pelaku' => $anggota, // Yang akan transaksi
                'draft_transaksi' => $draft_transaksi,
                'form_action_add_produk' => route('transaksi.add.from.produk.for.anggota', $anggota),
                'form_action_add_tunggakan' => $daftar_tunggakan_routes,
                'form_action_add_sukarela' => route('transaksi.add.from.sukarela.for.anggota', $anggota),
                'form_action_removes' => $draft_transaksi_remove_routes,
                'form_action_utang' => route('transaksi.utang.for.anggota', $anggota),
                'form_action_lunas' => route('transaksi.lunas.for.anngota', $anggota),
                'can_utang' => $can_utang,
            ]
        );
    }

    public function anggotaAddFromProduk(TransaksiAddFromProdukRequest $request, Anggota $anggota)
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

    public function anggotaAddFromTunggakan(Anggota $anggota, Tunggakan $tunggakan)
    {
        session()->push(
            "draft_transaksi.anggota.{$anggota->id}",
            [
                'transaksi' => [
                    'nama' => $tunggakan->nama_tunggakan,
                    'keterangan' => '',
                    'nominal_satuan' => $tunggakan->nominal,
                    'jumlah' => 1,
                    'nominal_total' => $tunggakan->nominal,
                ],
                'tunggakan_id' => $tunggakan->id,
                'tipe' => 'tunggakan',
            ]
        );

        return redirect()->back();
    }

    public function anggotaAddFromSukarela(TransaksiAddFromSukarelaRequest $request, Anggota $anggota)
    {
        session()->push(
            "draft_transaksi.anggota.{$anggota->id}",
            [
                'transaksi' => [
                    'nama' => 'Simpanan Sukarela',
                    'keterangan' => '',
                    'nominal_satuan' => $request->validated('nominal'),
                    'jumlah' => 1,
                    'nominal_total' => $request->validated('nominal'),
                ],
                'tipe' => 'sukarela',
            ]
        );

        return redirect()->back();
    }

    /**
     * Remove draft for Anggota
     */
    public function anggotaRemove(Anggota $anggota, int $index)
    {
        $draft_transaksi = session('draft_transaksi');
        if (!isset($draft_transaksi['anggota'][$anggota->id][$index])) {
            return redirect()->back();
        }

        unset($draft_transaksi['anggota'][$anggota->id][$index]);
        session()->put('draft_transaksi', $draft_transaksi);

        return redirect()->route('transaksi.create.for.anggota', ['anggota' => $anggota]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function store(string $pelaku_type, mixed $pelaku_model, bool $is_nunggak)
    {
        if (!isset(session('draft_transaksi')[$pelaku_type][$pelaku_model->id])) {
            return redirect()->back()
                ->with('alert', [['mode' => 'danger', 'message' => 'Transaksi tidak boleh kosong']]);
        }

        // data draft transaksi
        $draft_transaksi = collect(session('draft_transaksi')[$pelaku_type][$pelaku_model->id]);

        $produk = collect();
        $tunggakan_ids = collect();
        $sukarela = collect();
        $total = 0;

        foreach ($draft_transaksi as $transaksi) {

            if (!in_array($transaksi['tipe'], ['produk', 'tunggakan', 'sukarela'])) {
                throw new Exception("Error getting transaksi tipe", 1);
            }

            if (in_array($transaksi['tipe'], ['sukarela', 'tunggakan']) && $is_nunggak == true) {
                // Tudak boleh nunggak jika sedang bayar tunggakan atau simpanan sukarela
                $message = ($transaksi['tipe'] == 'tunggakan')
                    ? 'Tidak bisa menunggak ketika ingin membayar tunggakan'
                    : 'Tidak bisa menunggak ketika ingin menyimpan';

                return redirect()->back()
                    ->with('alert', [['mode' => 'danger', 'message' => $message]]);
            }

            $total += $transaksi['transaksi']['nominal_total'];

            if ($transaksi['tipe'] == 'produk') {
                $produk->push([
                    'produk_id' => $transaksi['transaksi']['produk_id'],
                    'jumlah_beli' => $transaksi['transaksi']['jumlah'],
                    'total_nominal' => $transaksi['transaksi']['nominal_total'],
                    'keterangan' => $transaksi['transaksi']['keterangan'],
                ]);
                continue;
            }

            if ($transaksi['tipe'] == 'sukarela' && is_a($pelaku_model, \App\Models\Anggota::class)) {
                $sukarela->push([
                    'anggota_id' => $pelaku_model->id,
                    'jenis' => Simpanan::JENIS['sukarela'],
                    'nominal' => $transaksi['transaksi']['nominal_total'],
                    'status' => Simpanan::STATUS['dibayar'],
                ]);
                continue;
            }

            if ($transaksi['tipe'] == 'tunggakan') {
                $tunggakan_ids->push($transaksi['tunggakan_id']);
                continue;
            }
        }

        $transaksi = [
            'pelayan_id' => auth()->id(),
            'pelaku_id' => $pelaku_model->id,
            'pelaku_type' => $pelaku_model::class,
            'nominal' => $total,
            'status' => ($is_nunggak) ? Transaksi::STATUS['utang'] : Transaksi::STATUS['lunas'],
            'keterangan' => NULL,
        ];

        DB::transaction(function () use ($transaksi, $produk, $pelaku_model, $is_nunggak, $tunggakan_ids, $sukarela) {
            $transaksi = Transaksi::create($transaksi);

            // Insert transaksi for product START
            if ($produk->isNotEmpty()) {
                $produk = $produk->map(function ($value) use ($transaksi) {
                    $value['transaksi_id'] = $transaksi->id;
                    return $value;
                });

                TransaksiMerchant::insert($produk->toArray());
            }
            // Insert transaksi for product END

            // Insert transaksi for sukarela START
            if ($sukarela->isNotEmpty()) {
                $sukarela = $sukarela->map(function ($value) use ($transaksi) {
                    $value['transaksi_id'] = $transaksi->id;
                    return $value;
                });

                Simpanan::insert($sukarela->toArray());
            }
            // Insert transaksi for sukarela END

            if ($is_nunggak) {

                // Tunggakan for produk START
                $transaksi_merchant = TransaksiMerchant::where(['transaksi_id' => $transaksi->id])->get();

                $tunggakan = [];
                foreach ($transaksi_merchant as $t_merchant) {
                    $tunggakan[] = [
                        'nama_tunggakan' => "Utang {$t_merchant->jumlah_beli} {$t_merchant->produk->nama_produk}",
                        'nominal' => $t_merchant->total_nominal,
                        'keterangan' => null,
                        'status' => Tunggakan::STATUS['belum_lunas'],
                        'penunggak_id' => $pelaku_model->id,
                        'penunggak_type' => $pelaku_model::class,
                        'tertunggak_id' => $t_merchant->id,
                        'tertunggak_type' => $t_merchant::class,
                    ];
                }
                // Tunggakan for produk END

                Tunggakan::insert($tunggakan);
            } else { // bayar lunas tunggakan
                $tunggakan = Tunggakan
                    ::whereIn('id', $tunggakan_ids->toArray())
                    ->update(['status' => Tunggakan::STATUS['lunas']]);
            }
        });

        // Unset the succes transaction
        $new_session = session('draft_transaksi');
        unset($new_session[$pelaku_type][$pelaku_model->id]);
        session()->put('draft_transaksi', $new_session);

        return redirect()->route('transaksi.index')
            ->with('alert', [[
                'mode' => 'success',
                'message' => 'Data transaksi berhasil ditambahkan'
            ]]);
    }

    public function utangAnggota(Anggota $anggota)
    {
        return $this->store(
            pelaku_type: 'anggota',
            pelaku_model: $anggota,
            is_nunggak: true
        );
    }

    public function lunasAnggota(Anggota $anggota)
    {
        return $this->store(
            pelaku_type: 'anggota',
            pelaku_model: $anggota,
            is_nunggak: false
        );
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
