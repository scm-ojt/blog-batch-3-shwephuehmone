<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CategoryRequest;

//use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            return Category::where('name', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')->get();
        } else {
            return Category::orderBy('id', 'DESC')->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $categories= Category::create([
            'name'=> $request->name
        ]);
        return response([
            "results" => "1",
            "message" =>"Created successfully",
            "data" => $categories
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response([
            "results" => "1",
            "message" =>"success",
            "data" => $category
        ]);
        if ($category->isEmpty()) {
            return response(['error' => 'Record not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();
        return response([
            "category"=>$category,
            "message" =>"Category has been Updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(
            ["category"=>$category,
            "message"=> 'Category has been deleted successfully'],
            200
        );
    }

    public function export(Request $request)
    {
        return Excel::download(new CategoryExport($request->keyword), 'categories.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new CategoryImport(), $request->file('file'));
        return response(200);
    }
}