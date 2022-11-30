@extends('auth.layout')

@section('title')
  Kopsol - Login
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
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">K O P S O L</h1>
              </div>

              @if (session()->has('alert'))
                @foreach (session('alert') as $bg => $message)
                  <div class="card bg-{{ $bg }} text-white shadow my-4">
                    <div class="card-body">
                      {{ $message }}
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

              <form class="user" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-user" id="email"
                    aria-describedby="emailHelp" placeholder="Masukkan Email...">
                  @error('email')
                    <small class="pl-3 text-sm text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-user"
                    id="exampleInputPassword" placeholder="Masukkan Password...">
                  @error('password')
                    <small class="pl-3 text-sm text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-group">
                  <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" name="remember" id="customCheck">
                    <label class="custom-control-label" for="customCheck">Remember
                      Me</label>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Login
                </button>
                <hr>
              </form>

              <div class="text-center">
                <a class="small" href="{{ route('password.request') }}">Lupa Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="{{ route('register') }}">Buat Akun Baru</a>
              </div>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection
