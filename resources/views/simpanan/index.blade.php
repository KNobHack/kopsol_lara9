@extends('dashboard.layout')

@section('title')
  Kopsol - Data Simpanan
@endsection

@section('css')
  <link href="{{ url('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection


@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ $heading ?? 'Simpanan' }}</h1>
    </div>

    @include('devutility.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $card_header ?? 'Data Simpanan' }}</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_simpanan" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Anggota</th>
                <th>Nama</th>
                @isset($with_jenis)
                  <th>Jenis simpanan</th>
                @endisset
                <th>Nominal</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($simpanan as $simp)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $simp->anggota_id }}</td>
                  <td>{{ $simp->anggota->nama_lengkap }}</td>
                  @isset($with_jenis)
                    <td>{{ $simp->jenis }}</td>
                  @endisset
                  <td>{{ $simp->nominal }}</td>
                  <td>{{ $simp->status }}</td>
                  <td>
                    <a href="#" class="btn btn-sm btn-info">Detail</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
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
      $('#tabel_simpanan').DataTable();
    });
  </script>
@endsection
