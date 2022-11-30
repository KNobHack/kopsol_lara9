@extends('auth.layout')

@section('title')
  Kopsol - Lupa Password
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

              <div class="card bg-info text-white shadow my-4">
                <div class="card-body">
                  Link verifikasi email berhasil di kirim
                </div>
              </div>

              <form class="user" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Kirim ulang email
                </button>
                <hr>
              </form>

              <div class="text-center">
                <a class="small" href="{{ route('login') }}">Kembali ke halaman Login</a>
              </div>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection
