@if (session('alert'))
  @foreach (session('alert') as $alert)
    <div class="alert alert-{{ $alert['mode'] }} alert-dismissible fade show" role="alert">
      {{ $alert['message'] }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endforeach
@endif
