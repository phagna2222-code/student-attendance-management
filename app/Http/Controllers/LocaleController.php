<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    private const SUPPORTED = ['en', 'km'];

    public function bundle(string $locale): JsonResponse
    {
        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = 'en';
        }

        $merged = [];

        // Load JSON file (lang/{locale}.json)
        $jsonPath = lang_path("$locale.json");
        if (is_file($jsonPath)) {
            $merged = array_merge($merged, json_decode(file_get_contents($jsonPath), true) ?? []);
        }

        // Load PHP arrays under lang/{locale}/* and namespace them
        $dir = lang_path($locale);
        if (is_dir($dir)) {
            foreach (scandir($dir) as $f) {
                if (! str_ends_with($f, '.php')) continue;
                $name = pathinfo($f, PATHINFO_FILENAME);
                /** @var array $messages */
                $messages = include "$dir/$f";
                $merged[$name] = $messages;
            }
        }

        // Standard DataTable language
        $merged['datatable'] = $locale === 'km' ? [
            'sProcessing' => 'កំពុងដំណើរការ...',
            'sLengthMenu' => '_MENU_ ធាតុ',
            'sZeroRecords' => 'មិនមានទិន្នន័យ',
            'sInfo' => 'បង្ហាញ _START_ ដល់ _END_ ក្នុងចំណោម _TOTAL_ ធាតុ',
            'sInfoEmpty' => 'បង្ហាញ 0 ដល់ 0 ក្នុងចំណោម 0 ធាតុ',
            'sInfoFiltered' => '(បានច្រោះចេញពី _MAX_ ធាតុសរុប)',
            'sSearch' => 'ស្វែងរក:',
            'sLoadingRecords' => 'កំពុងផ្ទុក...',
            'oPaginate' => [
                'sFirst' => 'ដំបូង',
                'sLast' => 'ចុងក្រោយ',
                'sNext' => 'បន្ទាប់',
                'sPrevious' => 'មុន',
            ],
        ] : [
            'sLengthMenu' => '_MENU_ entries per page',
            'sZeroRecords' => 'No matching records found',
            'sInfo' => 'Showing _START_ to _END_ of _TOTAL_ entries',
            'sSearch' => 'Search:',
        ];

        return response()->json($merged);
    }

    public function persist(Request $request, string $locale): JsonResponse
    {
        if (! in_array($locale, self::SUPPORTED, true)) {
            return response()->json(['ok' => false], 422);
        }
        $request->session()->put('app.locale', $locale);
        App::setLocale($locale);
        return response()->json(['ok' => true, 'locale' => $locale]);
    }
}
