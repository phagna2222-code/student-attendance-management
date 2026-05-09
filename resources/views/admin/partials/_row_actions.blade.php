<div class="d-inline-flex gap-1">
  <a href="{{ $editUrl }}" class="btn btn-sm btn-light border" title="{{ __('admin.edit') }}">
    <i class="bi bi-pencil-square"></i>
  </a>
  <form action="{{ $deleteUrl }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-light border text-danger js-confirm-delete" title="{{ __('admin.delete') }}">
      <i class="bi bi-trash"></i>
    </button>
  </form>
</div>
