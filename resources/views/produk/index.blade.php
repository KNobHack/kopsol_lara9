@extends('dashboard.layout')

@section('title')
  Kopsol - Data Produk
@endsection

@section('css')
  <link href="{{ url('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection


@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Produk</h1>
      <a href="{{ route('produk.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
          class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Baru</a>
    </div>

    @include('devutility.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="tabel_produk" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama prduk</th>
                <th>Harga</th>
                <th>Keterangan</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($produk as $prodk)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $prodk->nama_produk }}</td>
                  <td>{{ $prodk->harga }}</td>
                  <td>{{ $prodk->keterangan ?? '-' }}</td>
                  <td>
                    <form action="{{ route('produk.destroy', $prodk->id) }}">
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
      $('#tabel_produk').DataTable();
    });
  </script>
@endsection
