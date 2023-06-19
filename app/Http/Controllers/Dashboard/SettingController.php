<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Matcher\Type;
use \Illuminate\Support\Str;


class SettingController extends Controller
{
    public function update(Request $request , Setting $setting) 
    {
        Setting::create($request->all());
        $data = [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'favicon' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'facebook' =>  'nullable | string',
            'instagram' =>  'nullable | string',
            'phone' =>  'nullable | string',
            'email' =>  'nullable | email',
        ];

        foreach(config('app.languages') as $key => $value ){
            $data[$key.'*.title'] = 'nullable | string';
            $data[$key.'*content'] = 'nullable | string';
            $data[$key.'*address'] = 'nullable | string';
        }

        $validatedData = $request->validate($data);

        $setting->update($request->except('image','favicon','_token'));
        /*
        if ($request->has('logo')) {
            $name = $request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->store('public/images');
            $setting->update(['logo'=>$path]);
        }


        if ($request->has('favicon')) {
            $name = $request->file('favicon')->getClientOriginalName();
            $path = $request->file('favicon')->store('public/images');
            $setting->update(['favicon'=>$path.'/'.$name]);
        }
        */

        if($request->file('logo')){
            $file = $request->file('logo');
            $filename = Str::uuid().$file->getClientOriginalName();
            $file-> move(public_path('images'),$filename);
            $path = '/images/'.$filename;
            $setting->update(['logo'=>$path]);
        }
        
        if($request->file('favicon')){
            $file = $request->file('favicon');
            $filename = Str::uuid().$file->getClientOriginalName();
            $file-> move(public_path('images'),$filename);
            $path = '/images/'.$filename;
            $setting->update(['favicon'=>$path]);
        }



        return redirect()->route('dashboard.settings'); 
    }
}
