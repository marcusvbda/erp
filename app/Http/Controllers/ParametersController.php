<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Setting;
use Illuminate\Http\Request;
use Auth;
use DB;

class ParametersController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = $this->processSettings($user);
        return view("admin.parameters", compact('settings'));
    }

    private function processSettings($user)
    {
        $data = [];
        $settings = $user->getSettings();
        foreach ($settings as $key => $value) {
            $setting = Setting::where("slug", $key)->select("id", "slug", "name", "type", "default", "description")->firstOrFail()->setAppends([])->toArray();
            $setting["value"] = $value;
            $data[] = $setting;
        }
        return $data;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $tenant = Auth::user()->tenant;

        $values = array_map(function ($key) use ($data) {
            $value = $data[$key];
            if (is_bool($value)) $value = $value === true ? "true" : "false";
            return ["setting_id" => $key, "setting_value" =>  $value];
        }, array_keys($data));

        $tenant->settings()->detach();

        foreach ($values as $key => $value) {
            $values[$key] = array_map(function ($x) use ($key) {
                return ($key <= 1) ? json_encode($x) : $x;
            }, $value);
        }
        $tenant->settings()->attach($values);
        return ['success' => true];
    }
}
