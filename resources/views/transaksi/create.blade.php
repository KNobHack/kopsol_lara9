@extends('dashboard.layout')

@section('title')
  Kopsol - Data Anggota
@endsection

@section('css')
  <link href="{{ url('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection


@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>

    @include('devutility.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi</h6>
      </div>
      <div class="card-body">
        <h5 class="d-inline">Transaksi Untuk : </h5>

        <button type="button" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
          data-target="#modalCariAnggota">
          <span class="icon text-white-50">
            <i class="fas fa-search"></i>
          </span>
          <span class="text">Anggota</span>
        </button>

        <button type="button" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
          data-target="#modalCariNonAnggota">
          <span class="icon text-white-50">
            <i class="fas fa-search"></i>
          </span>
          <span class="text">Non-anggota</span>
        </button>

        <button type="button" class="btn btn-primary btn-icon-split btn-sm disabled">
          <span class="icon text-white-50">
            <i class="fas fa-mask"></i>
          </span>
          <span class="text">Anonim</span>
        </button>

        <hr>

        @if (isset($pelaku) && $pelaku->exists)
          <form>
            <div class="form-group row">
              <label for="" class="col-sm-2 col-form-label">Nama Lengkap</label>
              <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" value="{{ $pelaku->nama_lengkap ?? $pelaku->nama }}"
                  readonly>
              </div>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table" id="tabel_transaksi" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Transaksi</th>
                  <th>Keterangan</th>
                  <th>Nominal satuan</th>
                  <th>Jumlah</th>
                  <th>Nominal total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @php $total = 0 @endphp
                @foreach ($draft_transaksi->pluck('transaksi') as $key => $transaksi)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaksi['nama'] }}</td>
                    <td>{{ $transaksi['keterangan'] }}</td>
                    <td>{{ $transaksi['nominal_satuan'] }}</td>
                    <td>{{ $transaksi['jumlah'] }}</td>
                    <td>{{ $transaksi['nominal_total'] }}</td>
                    <td>
                      <form action="{{ $form_action_removes[$loop->index] }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                  @php $total += $transaksi['nominal_total'] @endphp
                @endforeach
                <tr>
                  <td colspan="5">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                      data-target="#modalTambahTransaksiProduk">
                      Beli Produk
                    </button>
                    @if (is_a($pelaku, \App\Models\Anggota::class) || is_a($pelaku, \App\Models\NonAnggota::class))
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                        data-target="#modalTambahTransaksiTunggakan">
                        Bayar Tunggakan
                      </button>
                    @endif
                    @if (is_a($pelaku, \App\Models\Anggota::class))
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#modalTambahTransaksiSukarela">
                        Simpanan Sukarela
                      </button>
                    @endif
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4"></th>
                  <th class="text-right"><strong>Total :</strong></th>
                  <th colspan="2">{{ $total }}</th>
                </tr>
              </tfoot>
            </table>
            @if ($draft_transaksi->isNotEmpty())
              @if ($can_utang)
                <form action="{{ $form_action_utang }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-secondary">Utang</button>
                </form>
              @endif
              <form action="{{ $form_action_lunas }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary">Lunas</button>
              </form>
            @endif
          </div>
        @endif
      </div>
    </div>

  </div>
@endsection

@section('modals')
  <!-- Modal -->
  <div class="modal fade" id="modalCariAnggota" data-backdrop="static" tabindex="-1"
    aria-labelledby="modalCariAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCariAnggotaLabel">Cari anggota</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="tabel_anggota" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>No Telpon</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($daftar_anggota as $agt)
                  <tr>
                    <td>{{ $agt->nik }}</td>
                    <td>{{ $agt->nama_lengkap }}</td>
                    <td>{{ $agt->jenis_kelamin }}</td>
                    <td>{{ $agt->nomor_telpon }}</td>
                    <td>
                      <a href="{{ route('transaksi.create.for.anggota', $agt->id) }}"
                        class="btn btn-sm btn-info">Pilih</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-secondary"
            onclick="event.preventDefault();$('#modalCariAnggota').modal('hide')">Batal</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modalCariNonAnggota" data-backdrop="static" tabindex="-1"
    aria-labelledby="modalCariNonAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCariNonAnggotaLabel">Cari non-anggota</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="tabel_nonanggota" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>No Telpon</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($daftar_non_anggota as $non_agt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $non_agt->nama }}</td>
                    <td>{{ $non_agt->jenis_kelamin }}</td>
                    <td>{{ $non_agt->nomor_telpon ?? '-' }}</td>
                    <td>
                      <a href="{{ route('transaksi.create.for.nonanggota', $non_agt->id) }}"
                        class="btn btn-sm btn-info">Pilih</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-secondary"
            onclick="event.preventDefault();$('#modalCariAnggota').modal('hide')">Batal</a>
        </div>
      </div>
    </div>
  </div>

  @if (isset($pelaku) && $pelaku->exists)
    <!-- Modal -->
    <div class="modal fade" id="modalTambahTransaksiProduk" data-backdrop="static" tabindex="-1"
      aria-labelledby="modalTambahTransaksiProdukLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahTransaksiProdukLabel">Isi data transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ $form_action_add_produk }}" method="POST">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="">Nama Produk</label>
                <select name="produk_id" id="" class="form-control">
                  @if (!old('produk_id'))
                    <option selected disabled>Pilih merchant</option>
                  @endif
                  @foreach ($daftar_produk as $prdk)
                    <option value="{{ $prdk->id }}" @selected(old('produk_id') == $prdk->id)>{{ $prdk->nama_produk }} &nbsp;
                      {{ $prdk->harga }}</option>
                  @endforeach
                </select>
                @error('produk_id')
                  <small class="form-text
      text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Jumlah</label>
                <input type="number" class="form-control" name="jumlah" value="{{ old('jumlah') }}">
                @error('jumlah')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}"
                  placeholder="Isi jika perlu">
                @error('keterangan')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Tambah</button>
              <a href="#" class="btn btn-secondary"
                onclick="event.preventDefault();$('#modalTambahTransaksiProduk').modal('hide')">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    @if (is_a($pelaku, \App\Models\Anggota::class) || is_a($pelaku, \App\Models\NonAnggota::class))
      <!-- Modal -->
      <div class="modal fade" id="modalTambahTransaksiTunggakan" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalTambahTransaksiTunggakanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTambahTransaksiTunggakanLabel">Tambah Transaksi dari Tunggakan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tabel_tunggakan" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Tunggakan</th>
                      <th>Nominal</th>
                      <th>Keterangan</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($daftar_tunggakan as $tunggakan)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tunggakan->nama_tunggakan }}</td>
                        <td>{{ $tunggakan->nominal }}</td>
                        <td>{{ $tunggakan->keterangan }}</td>
                        <td>
                          <form action="{{ $form_action_add_tunggakan[$loop->index] }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-info">Pilih</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-secondary"
                onclick="event.preventDefault();$('#modalTambahTransaksiTunggakan').modal('hide')">Batal</a>
            </div>
          </div>
        </div>
      </div>
    @endif

    @if (is_a($pelaku, \App\Models\Anggota::class))
      <!-- Modal -->
      <div class="modal fade" id="modalTambahTransaksiSukarela" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalTambahTransaksiSukarelaLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTambahTransaksiSukarelaLabel">Isi data transaksi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ $form_action_add_sukarela }}" method="POST">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="">Nominal</label>
                  <input type="number" class="form-control" name="nominal" value="{{ old('nominal') }}"
                    value="Masukkan nominal simpanan sukarela...">
                  @error('nominal')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="#" class="btn btn-secondary"
                  onclick="event.preventDefault();$('#modalTambahTransaksiSukarela').modal('hide')">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    @endif
  @endif
@endsection

@section('script')
  <script src="{{ url('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('#tabel_anggota').DataTable();
      $('#tabel_nonanggota').DataTable();
      $('#tabel_tunggakan').DataTable();
    });
  </script>
@endsection
