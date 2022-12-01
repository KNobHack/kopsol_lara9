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
      <h1 class="h3 mb-0 text-gray-800">Anggota</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
          class="fas fa-plus fa-sm text-white-50"></i> Tambah Anggota Baru</a>
    </div>

    @include('devutility.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Anggota</h6>
      </div>
      <div class="card-body">
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
              @foreach ($anggota as $agt)
                <tr>
                  <td>{{ $agt->nik }}</td>
                  <td>{{ $agt->nama_lengkap }}</td>
                  <td>{{ $agt->jenis_kelamin }}</td>
                  <td>{{ $agt->nomor_telpon }}</td>
                  <td>
                    <a href="{{ route('profile.specific', $agt->id) }}" class="btn btn-sm btn-info">Detail</a>
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
      $('#tabel_anggota').DataTable();
    });
  </script>
@endsection
