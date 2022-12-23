@extends('auth.layout')

@section('title')
  Pre-Launch - Kopsol
@endsection

@section('body')
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-5 col-lg-6 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
              <div class="text-center mb-4">
                <h1 class="h4 text-gray-900 mb-4"><b>K O P S O L</b> Pre-Launch</h1>
                <small>Selamat anda mendapatkan kesempatan untuk registrasi pre-launch kopsol</small><br>
                <small>Silahkan registrasi untuk mendapatkan secret rewardnya</small><br>
                <small>Nantikan Launcing utama kami di bulan April 2023</small>
              </div>

              @if (session()->has('alert'))
                @foreach (session('alert') as $alert)
                  <div class="card bg-{{ $alert['mode'] }} text-white shadow my-4">
                    <div class="card-body">
                      {{ $alert['message'] }}
                      <!-- <div class="text-white-50 small">#4e73df</div> -->
                    </div>
                  </div>
                @endforeach
              @endisset

              @if (session('status'))
                <div class="card bg-success text-white shadow my-4">
                  <div class="card-body py-3">
                    {{ session('status') }}
                  </div>
                </div>
              @endif

              <form class="user" method="POST" action="{{ route('prelaunch.register') }}">
                @csrf
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-user" id="email"
                    aria-describedby="emailHelp" placeholder="Masukkan Email..." value="{{ old('email') }}">
                  @error('email')
                    <small class="pl-3 text-sm text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-user" id="password"
                    placeholder="Masukkan Password...">
                  @error('password')
                    <small class="pl-3 text-sm text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="password" name="password_confirmation" class="form-control form-control-user"
                    id="password_confirmation" placeholder="Ulangi Password">
                  @error('password_confirmation')
                    <small class="pl-3 text-sm text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="text" name="nama" class="form-control form-control-user" id="nama"
                    aria-describedby="nama" placeholder="Masukkan Nama Anda..." value="{{ old('nama') }}">
                  @error('nama')
                    <small class="pl-3 text-sm text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-group text-center">
                  <div class="form-check form-check-inline">
                    <input type="radio" value="L" name="jenis_kelamin" class="form-check-input"
                      @checked(old('jenis_kelamin') == 'L')>
                    <label for="" class="form-check-label"> Laki-laki</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input type="radio" value="P" name="jenis_kelamin" class="form-check-input"
                      @checked(old('jenis_kelamin') == 'P')>
                    <label for="" class="form-check-label"> Perempuan</label>
                  </div>
                  @error('jenis_kelamin')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Registrasi
                </button>
                <hr>
              </form>

              {{-- <div class="text-center">
                <a class="small" href="{{ route('login') }}">Sudah punya akun</a>
              </div> --}}
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection
