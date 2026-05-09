{{--
  Reusable index card.
  $title       string
  $createUrl   string|null  (when given a Create button is shown)
  $datatableUrl string
  $columns     array  e.g. [['data'=>'id','title'=>'#'],['data'=>'name_en','title'=>'Name'], ...]
  $order       array|null
--}}
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h5 class="mb-0">{{ $title }}</h5>
    @if(!empty($createUrl))
      <a href="{{ $createUrl }}" class="btn btn-primary btn-sm ms-auto">
        <i class="bi bi-plus-lg me-1"></i> {{ __('admin.create_new') }}
      </a>
    @endif
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle js-datatable"
             data-source="{{ $datatableUrl }}"
             data-columns='@json($columns)'
             data-order='@json($order ?? [[0,"desc"]])'>
        <thead>
          <tr>
            @foreach($columns as $col)
              <th>{{ $col['title'] ?? $col['data'] }}</th>
            @endforeach
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
