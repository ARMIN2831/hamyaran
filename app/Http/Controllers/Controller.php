<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Throwable;
abstract class Controller
{

    function doFilter($data, $request, $arr)
    {
        if ($id = $request->id) {
            $data = $data->where('id', $id);
        } else {
            if ($request->search) {
                $search = $request->input('search');
                $data->where(function ($q) use ($arr, $search) {
                    foreach ($arr as $column) {
                        $q->orWhere($column, 'LIKE', "%{$search}%");
                    }
                });
            }

            //$data = $data->latest();

            if (!$request->pagesize) $request->pagesize = 10;

            $data = $data->paginate($request->pagesize);
        }
        try {
            $num = count($data->get());
            $data = $data->get();
        }catch (Throwable $exception){
            $num = count($data);
        }
        return [$data, $num];
    }
    public function loadSetting($data=[]): array
    {
        $settings = Setting::query();
        if ($data) foreach ($data as $name) $settings->orWhere('name',$name);
        $settings = $settings->get();
        $result = [];
        foreach ($settings as $setting) {
            if (str_contains($setting->value, "\r\n")) $lines = "\r\n";
            else $lines = "\n";
            $result [$setting->name] = explode($lines,$setting->value);
        }
        return $result;
    }
}
