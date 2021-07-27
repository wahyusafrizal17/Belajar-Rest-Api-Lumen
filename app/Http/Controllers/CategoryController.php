<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepositoryEloquent;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{

    protected $categoryRepository;

    public function __construct(CategoryRepositoryEloquent $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->categoryRepository->all();

        if(!empty($model)){
            $response['success'] = true;
            $response['message'] = "Data berhasil di tampilkan";
            $response['data']    = $model;
        }else{
            $response['success'] = false;
            $response['message'] = "Data kosong";
        }

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name, '-');
        if($request->hasFile('images')){
            $file = $request->file('images');
            $fileName = $file->getClientOriginalName();
            $file->move('category', $fileName);
            $data['images'] = $fileName;
        }

        $model = $this->categoryRepository->create($data);

        if($model){
            $response['success'] = true;
            $response['message'] = "Data berhasil di tambahkan";
            $response['data']    = $model;
        }else{
            $response['success'] = false;
            $response['message'] = "Data gagal di tambahkan";
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->categoryRepository->where('id', $id)->first();

        if(!empty($model)){
            $response['success'] = true;
            $response['message'] = "Data berhasil di tampilkan";
            $response['data']    = $model;
        }else{
            $response['success'] = false;
            $response['message'] = "Data kosong";
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $cek = $this->categoryRepository->where('id', $id)->first();

        if($cek){
            $data = $request->all();
            $data['slug'] = Str::slug($request->name, '-');
            if($request->hasFile('images')){
                $file = $request->file('images');
                $fileName = $file->getClientOriginalName();
                $file->move('category', $fileName);
                $data['images'] = $fileName;
            }

            $model = $this->categoryRepository->update($data, $id);

            if($model){
                $response['success'] = true;
                $response['message'] = "Data berhasil di ubah";
                $response['data']    = $model;
            }else{
                $response['success'] = false;
                $response['message'] = "Data gagal di ubah";
            }

            return response()->json($response);
        }else{
            $response['success'] = false;
            $response['message'] = "Data tidak di temukan";

            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cek = $this->categoryRepository->where('id', $id)->first();

        if($cek){
            $model = $this->categoryRepository->delete($id);

            $response['success'] = true;
            $response['message'] = "Data berhasil di hapus";
            $response['data']    = $cek;

            unlink('category/'.$cek->images);
            return response()->json($response);

        }else{
            $response['success'] = false;
            $response['message'] = "Data tidak di temukan";

            return response()->json($response);
        }
    }
}
