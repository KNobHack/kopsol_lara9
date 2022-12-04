<script>
  @if (session('modal_show'))
    $("#{{ session('modal_show') }}").modal('show');
  @endif
</script>
