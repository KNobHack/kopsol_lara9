@extends('dashboard.layout')

@section('title')
  Kopsol - Profile
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
          <div class="card-footer">
            <a href="#" class="btn btn-block btn-success">Ganti Foto</a>
          </div>
        </div>
      </div>
      <div class="col-md-7 col-lg-8">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Profile Anda</h6>
            <div class="dropdown no-arrow">
              <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <a href="{{ $edit_href ?? route('profile.edit') }}" class="dropdown-item">Edit profil</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control-plaintext" value="{{ $anggota->nik }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control-plaintext" value="{{ $anggota->nama_lengkap }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">No Telepon</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control-plaintext" value="{{ $anggota->nomor_telpon }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Tempat Lahir</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control-plaintext" value="{{ $anggota->tempat_lahir }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control-plaintext" value="{{ $anggota->tanggal_lahir }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Jenis Kelamin</label><br />
                <div class="col-sm-10">
                  <input type="text" class="form-control-plaintext" value="{{ $anggota->jenis_kelamin }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Agama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control-plaintext" value="{{ $anggota->agama }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Pekerjaan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control-plaintext" value="{{ $anggota->pekerjaan }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                <div class="col-sm-10">
                  <textarea cols="30" rows="3" class="form-control-plaintext" readonly>{{ $anggota->alamat }}</textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
