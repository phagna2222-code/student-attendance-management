<div class="btn-group btn-group-sm">
  <form method="POST" action="{{ $approve }}" class="d-inline js-confirm-action" data-confirm="{{ __('admin.confirm_approve') }}">
    @csrf
    <input type="hidden" name="approval_note" value="{{ __('admin.approved_inline') }}">
    <button class="btn btn-success" type="submit"><i class="bx bx-check"></i></button>
  </form>
  <button class="btn btn-danger js-reject-edit" data-url="{{ $reject }}" data-bs-toggle="modal" data-bs-target="#editRequestRejectModal" type="button"><i class="bx bx-x"></i></button>
</div>
