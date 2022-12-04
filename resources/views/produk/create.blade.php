@extends('dashboard.layout')

@section('title')
  Kopsol - Tambah Produk
@endsection

@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Produk</h1>

    <div class="row">
      <div class="col-md-8 col-lg-6">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Produk Baru</h6>
          </div>
          <form action="{{ route('produk.store') }}" method="POST">
            <div class="card-body">
              @csrf
              <div class="form-group">
                <label for="">Nama Produk</label>
                <input type="text" class="form-control" name="nama_produk" placeholder="Masukkan Nama Produk..."
                  value="{{ old('nama_produk') }}" autocomplete="off">
                @error('nama_produk')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Harga</label>
                <input type="number" class="form-control" name="harga" placeholder="Masukkan Harga..."
                  value="{{ old('harga') }}">
                @error('harga')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Keterangan</label>
                <textarea name="keterangan" id="" cols="30" rows="3" class="form-control">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
              <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
