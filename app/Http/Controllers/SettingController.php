<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function setdata()
    {
        if (auth()->user()->can('setting setdata')){
            $settings = Setting::get();
            return view('admin.setting.setting-setdata',compact('settings'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
    public function update(Request $request)
    {
        if (auth()->user()->can('setting setdata')) {
            foreach ($request->input() as $key => $row) {
                Setting::where('name', $key)->update(['value' => $row]);
            }
            return redirect()->route('setting.setdata')->with('success', 'اطلاعات با موفقیت ذخیره شد!');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }


    public function index()
    {
        $backups = collect(Storage::files('backup-database'))->map(function($file) {
            return [
                'name' => basename($file),
                'time' => Carbon::createFromTimestamp(explode('.', basename($file))[0]),
            ];
        })->sortByDesc('time');

        return view('admin.setting.setting-db', compact('backups'));
    }

    public function create()
    {
        $filename = Carbon::now()->timestamp . '.sql';
        $filepath = storage_path('app/backup-database/' . $filename);

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_DATABASE'),
            $filepath
        );

        exec($command);

        return redirect()->route('backup.index')->with('success', 'پشتیبان‌گیری موفقیت‌آمیز بود.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:sql,zip',
        ]);

        $file = $request->file('file');
        $filename = time() . '-' . $file->getClientOriginalName();
        Storage::putFileAs('backup-database', $file, $filename);

        return redirect()->route('backup.index')->with('success', 'فایل پشتیبان با موفقیت بارگذاری شد.');
    }

    public function download($filename)
    {
        return Storage::download('backup-database/' . $filename);
    }

    public function restore($filename)
    {
        $filepath = storage_path('app/backup-database/' . $filename);

        $command = sprintf(
            'mysql --user=%s --password=%s --host=%s %s < %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_DATABASE'),
            $filepath
        );

        exec($command);

        return redirect()->route('backup.index')->with('success', 'بازگردانی پشتیبان با موفقیت انجام شد.');
    }

    public function delete($filename)
    {
        Storage::delete('backup-database/' . $filename);
        return redirect()->route('backup.index')->with('success', 'فایل پشتیبان با موفقیت حذف شد.');
    }
}
