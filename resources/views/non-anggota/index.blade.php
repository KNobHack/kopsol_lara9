@extends('dashboard.layout')

@section('title')
  Kopsol - Data Non Anggota
@endsection

@section('css')
  <link href="{{ url('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection


@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Non Anggota</h1>
      <a href="{{ route('non-anggota.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
          class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Non-Anggota</a>
    </div>

    <div class="alert alert-info alert-dismissible fade show" role="alert" id="alert_info">
      Data non-anggta merupakan pihak yang melakukan transaksi di dalam koperasi tanpa menjadi anggota
      koperasi <br>(Contoh : pembeli di toko koperasi)
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    @include('devutility.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Non-anggota</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_non_anggota" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Nomor Telpon</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($non_anggota as $non_agt)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $non_agt->nama }}</td>
                  <td>{{ $non_agt->jenis_kelamin }}</td>
                  <td>{{ $non_agt->nomor_telpon }}</td>
                  <td>
                    <a href="{{ route('non-anggota.edit', $non_agt->id) }}" class="btn btn-sm btn-success"><i
                        class="fas fa-edit"></i></a>
                    <form action="{{ route('non-anggota.destroy', $non_agt->id) }}" class="d-inline" method="POST">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
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
      $('#tabel_non_anggota').DataTable();

      setTimeout(() => {
        $('#alert_info').alert('close')
      }, 8000);
    });
  </script>
@endsection