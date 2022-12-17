@extends('central.dashboard.layout')

@section('title')
  Kopsol - Profile Update
@endsection

@section('content')
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Profile</h1>

    <div class="row">
      <div class="col-md-5 col-lg-4">

        @include('devutility.alert')

        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Photo Profile</h6>
          </div>
          <div class="card-body">
            <img src="{{ url('assets/img/undraw_profile.svg') }}" alt="" class="img-profile rounded-circle">
          </div>
          @if (Auth::user()->profileComplete())
            <div class="card-footer">
              <a href="#" class="btn btn-block btn-success">Ganti Foto</a>
            </div>
          @endif
        </div>
      </div>
      <div class="col-md-7 col-lg-8">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
          </div>
          <form action="{{ $form_action ?? route('profile') }}" method="POST">
            <div class="card-body">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="">NIK</label>
                <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK..."
                  value="{{ old('nik') ?? $anggota?->nik }}">
                @error('nik')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan Nama Lengkap..."
                  value="{{ old('nama_lengkap') ?? $anggota?->nama_lengkap }}">
                @error('nama_lengkap')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">No Telepon</label>
                <input type="number" class="form-control" name="nomor_telpon" placeholder="Masukkan Nomor Telepon..."
                  value="{{ old('nomor_telpon') ?? $anggota?->nomor_telpon }}">
                @error('nomor_telpon')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukkan Tempat Lahir..."
                  value="{{ old('tempat_lahir') ?? $anggota?->tempat_lahir }}">
                @error('tempat_lahir')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Tanggal Lahir</label>
                <input type="date" value="{{ old('tanggal_lahir') ?? $anggota?->tanggal_lahir }}" name="tanggal_lahir"
                  class="form-control">
                @error('tanggal_lahir')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Jenis Kelamin</label><br />
                <div class="form-check form-check-inline">
                  <input type="radio" value="L" name="jenis_kelamin" class="form-check-input"
                    @checked(old('jenis_kelamin') ? old('jenis_kelamin') == 'L' : $anggota?->jenis_kelamin == 'L')>
                  <label for="" class="form-check-label"> Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" value="P" name="jenis_kelamin" class="form-check-input"
                    @checked(old('jenis_kelamin') ? old('jenis_kelamin') == 'P' : $anggota?->jenis_kelamin == 'P')>
                  <label for="" class="form-check-label"> Perempuan</label>
                </div>
                @error('jenis_kelamin')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Agama</label>
                <select name="agama" id="" class="form-control">
                  @if (!old('agama') && !$anggota?->agama)
                    <option selected disabled>Agama anda</option>
                  @endif
                  <option value="Islam" @selected(old('agama') ? old('agama') == 'Islam' : $anggota?->agama == 'Islam')>Islam</option>
                  <option value="Kristen" @selected(old('agama') ? old('agama') == 'Kristen' : $anggota?->agama == 'Kristen')>Kristen</option>
                  <option value="Katholik" @selected(old('agama') ? old('agama') == 'Katholik' : $anggota?->agama == 'Katholik')>Katholik</option>
                  <option value="Hindu" @selected(old('agama') ? old('agama') == 'Hindu' : $anggota?->agama == 'Hindu')>Hindu</option>
                  <option value="Budha" @selected(old('agama') ? old('agama') == 'Budha' : $anggota?->agama == 'Budha')>Budha</option>
                  <option value="Konghucu" @selected(old('agama') ? old('agama') == 'Konghucu' : $anggota?->agama == 'Konghucu')>Konghucu</option>
                </select>
                @error('agama')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan..."
                  value="{{ old('pekerjaan') ?? $anggota?->pekerjaan }}">
                @error('pekerjaan')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Alamat Lengkap</label>
                <textarea name="alamat" id="" cols="30" rows="3" class="form-control">{{ old('alamat') ?? $anggota?->alamat }}</textarea>
                @error('alamat')
                  <small class="form-text text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
              @if (Auth::user()->profileComplete())
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
              @endif
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
@endsection
