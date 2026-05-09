<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::orderBy('group')->orderBy('key')->get();
        return view('admin.system-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $values = $request->input('settings', []);
        foreach ($values as $key => $value) {
            $row = SystemSetting::where('key', $key)->first();
            if (! $row) continue;
            if ($row->value_type === 'boolean') $value = (bool) $value;
            elseif ($row->value_type === 'number') $value = is_numeric($value) ? (int) $value : $value;
            $row->value = $value;
            $row->updated_by = auth()->id();
            $row->save();
        }
        flash()->success(__('admin.settings').' — '.__('Updated successfully'));
        return back();
    }
}
