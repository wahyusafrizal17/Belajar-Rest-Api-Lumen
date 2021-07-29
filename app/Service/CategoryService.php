<?php

namespace App\Service;

use Illuminate\Support\Str;

class CategoryService
{
    public function store(object $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name, '-');
        if($request->hasFile('images')){
            $file = $request->file('images');
            $fileName = $file->getClientOriginalName();
            $file->move('category', $fileName);
            $data['images'] = $fileName;
        }

        return $data;
    }

    public function update(object $request)
    {
        $data = $request->all();
            $data['slug'] = Str::slug($request->name, '-');
            if($request->hasFile('images')){
                $file = $request->file('images');
                $fileName = $file->getClientOriginalName();
                $file->move('category', $fileName);
                $data['images'] = $fileName;
            }

        return $data;
    }
}