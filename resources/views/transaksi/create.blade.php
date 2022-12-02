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
          <span class="text">Pilih
            anggota</span>
        </button>
        <hr>

        @if ($anggota->exists)
          <form>
            <div class="form-group row">
              <label for="" class="col-sm-2 col-form-label">Nama Lengkap</label>
              <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" value="{{ $anggota->nama_lengkap }}" readonly>
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
                  <th>Nominal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @php $total = 0 @endphp
                @foreach (session('draft_transaksi') ?? [] as $key => $transaksi)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->nama }}</td>
                    <td>{{ $transaksi->keterangan }}</td>
                    <td>{{ $transaksi->nominal }}</td>
                    <td>
                      <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  @php $total += $nominal @endphp
                @endforeach
                <tr>
                  <td colspan="5">
                    <button type="button" class="btn btn-success btn-sm disabled">
                      <!-- data-toggle="modal" data-target="#modalTambahTransaksiMerchant"-->
                      <i class="fas fa-plus"></i> Merchant
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                      data-target="#modalTambahTransaksiTunggakan">
                      <i class="fas fa-plus"></i> Tunggakan
                    </button>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2"></th>
                  <th class="text-right"><strong>Total:</strong></th>
                  <th colspan="2">{{ $total }}</th>
                </tr>
              </tfoot>
            </table>
            <a href="#" class="btn btn-secondary">Simpan</a>
            <a href="#" class="btn btn-primary">Lunas</a>
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
  <div class="modal fade" id="modalTambahTransaksiMerchant" data-backdrop="static" tabindex="-1"
    aria-labelledby="modalTambahTransaksiMerchantLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahTransaksiMerchantLabel">Isi data transaksi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('profile') }}" method="POST">
          <div class="modal-body">
            @csrf
            <div class="form-group">
              <label for="">Nama Merchant</label>
              <select name="merchant" id="" class="form-control">
                @if (!old('merchant'))
                  <option selected disabled>Pilih merchant</option>
                @endif
                <option value="1" @selected(old('merchant') == '1')>Keripik</option>
              </select>
              @error('merchant')
                <small class="form-text text-danger">{{ $message }}</small>
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
              <input type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}">
              @error('keterangan')
                <small class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="#" class="btn btn-secondary"
              onclick="event.preventDefault();$('#modalTambahTransaksiMerchant').modal('hide')">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>

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
                @foreach ($daftar_tagihan as $dft_tagihan)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dft_tagihan->nama_tunggakan }}</td>
                    <td>{{ $dft_tagihan->nominal }}</td>
                    <td>{{ $dft_tagihan->keterangan }}</td>
                    <td>
                      <a href="#" class="btn btn-sm btn-info">Pilih</a>
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
@endsection

@section('script')
  <script src="{{ url('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('#tabel_anggota').DataTable();
    });
    $(document).ready(function() {
      $('#tabel_tunggakan').DataTable();
    });
  </script>
@endsection
