@extends('dashboard.layout')

@section('title')
  Kopsol - Tambah Data Non-Anggota
@endsection

@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Non-Anggota</h1>

    <div class="row">
      <div class="col-md-8 col-lg-6">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Non-Anggota</h6>
          </div>
          <form action="{{ route('non-anggota.update', $non_anggota->id) }}" method="POST">
            <div class="card-body">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="">Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama..."
                  value="{{ old('nama') ? old('nama') : $non_anggota->nama }}" autocomplete="off">
                @error('nama')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Jenis Kelamin</label><br />
                <div class="form-check form-check-inline">
                  <input type="radio" value="L" name="jenis_kelamin" class="form-check-input"
                    @checked(old('jenis_kelamin') ? old('jenis_kelamin') == 'L' : $non_anggota->jenis_kelamin == 'L')>
                  <label for="" class="form-check-label"> Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" value="P" name="jenis_kelamin" class="form-check-input"
                    @checked(old('jenis_kelamin') ? old('jenis_kelamin') == 'P' : $non_anggota->jenis_kelamin == 'P')>
                  <label for="" class="form-check-label"> Perempuan</label>
                </div>
                @error('jenis_kelamin')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">No Telepon</label>
                <input type="number" class="form-control" name="nomor_telpon" placeholder="Masukkan Nomor Telepon..."
                  value="{{ old('nomor_telpon') ?? $non_anggota->nomor_telpon }}">
                @error('nomor_telpon')
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
