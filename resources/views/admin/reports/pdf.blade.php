<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $title }}</title>
<style>
  @page { margin: 18mm 12mm; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 10pt; color:#222; }
  h1 { font-size: 14pt; margin: 0 0 6pt 0; }
  .meta { color:#666; margin-bottom: 12pt; }
  table { border-collapse: collapse; width: 100%; }
  th, td { border: 1px solid #aaa; padding: 4pt 6pt; text-align: left; vertical-align: top; }
  thead th { background: #f1f3f5; }
  tr:nth-child(even) td { background: #fafafa; }
</style>
</head>
<body>
<h1>{{ $title }}</h1>
<div class="meta">{{ __('admin.generated_at') }}: {{ now()->format('Y-m-d H:i') }}</div>
<table>
  <thead>
    <tr>
      @foreach($columns as $c)<th>{{ $c }}</th>@endforeach
    </tr>
  </thead>
  <tbody>
    @foreach($rows as $r)
      @php $r = (array) $r; @endphp
      <tr>
        @foreach($columns as $c)
          <td>{{ is_array($r[$c] ?? null) ? json_encode($r[$c]) : ($r[$c] ?? '') }}</td>
        @endforeach
      </tr>
    @endforeach
  </tbody>
</table>
</body>
</html>
