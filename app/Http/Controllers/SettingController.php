<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $title = "Tampilan";
        $description = "Pengaturan Tampilan";
        $setting = Setting::find(1);
        return view('admin.tampilan.edit', compact('title', 'setting', 'description'));
    }

    public function update(Request $request)
    {
        $setting = Setting::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:255',
            'short_name' => 'nullable|max:255',
            'small_icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'large_icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'background_login' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'background_sidebar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $imageFields = ['small_icon', 'large_icon', 'background_login', 'background_sidebar'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field) && $setting->{$field}) {
                $pathToOldFile = storage_path('app/public/images/' . $setting->{$field});

                if (File::exists($pathToOldFile)) {
                    $newFileName = $this->moveAndRenameFile($pathToOldFile);
                    $setting->{$field} = $newFileName;
                }
            }
        }

        $setting->fill($request->all());

        foreach ($imageFields as $field) {
            if ($request->file($field)) {
                $filename = $this->saveFileToStorage($request->file($field), $field);
                $setting->{$field} = $filename;
            }
        }
        $setting->save();

        Alert::toast('Pengaturan Berhasil Ditambah', 'success');
        return redirect('/admin/settings')->with('status', 'Data Berhasil Diubah');
    }

    private function moveAndRenameFile($pathToOldFile)
    {
        $fileName = pathinfo($pathToOldFile, PATHINFO_FILENAME);
        $fileExtension = pathinfo($pathToOldFile, PATHINFO_EXTENSION);
        $newFileName = $fileName . '_' . time() . '.' . $fileExtension;

        Storage::put('public/images/' . $newFileName, File::get($pathToOldFile));
        File::delete($pathToOldFile);

        return $newFileName;
    }

    private function saveFileToStorage($file, $field)
    {
        $filename = time() . $field . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/images'), $filename);

        return $filename;
    }
}
