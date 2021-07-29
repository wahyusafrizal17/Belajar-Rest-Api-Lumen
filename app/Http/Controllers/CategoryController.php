<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepositoryEloquent;
use App\Http\Requests\CategoryRequest;
use App\Service\CategoryService;
use App\Http\Resources\CategoryResource;

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
    public function index(Request $request)
    {
        if($request->has('type'))
        {
            $model = CategoryResource::collection($this->categoryRepository->findWhere(['type' => $request->type]));
        }else{
            $model = CategoryResource::collection($this->categoryRepository->all());
        }

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
    public function store(CategoryRequest $request, CategoryService $categoryService)
    {
        $data = $categoryService->store($request);
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
        $model = new CategoryResource($this->categoryRepository->find($id));

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
    public function update(CategoryRequest $request, $id, CategoryService $categoryService)
    {
        $cek = $this->categoryRepository->where('id', $id)->first();

        if($cek){
            $data = $categoryService->update($request);
            $model = $this->categoryRepository->update($data, $id);

            if($model){
                $response['success'] = true;
                $response['message'] = "Data berhasil di ubah";
                $response['data']    = $model;
            }else{
                $response['success'] = false;
                $response['message'] = "Data gagal di ubah";
            }

        }else{
            $response['success'] = false;
            $response['message'] = "Data tidak di temukan";
        }

        return response()->json($response);
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
