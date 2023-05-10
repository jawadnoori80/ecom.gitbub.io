<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Aisle;
use App\Models\Admin\Category;
use Illuminate\Database\Events\ModelsPruned;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Category::all();
        return view('admin.category', $result);
    }


    public function manage_category()
    {
        $result['aisle']=Aisle::all();
        return view('admin.manage_category',$result);
    }

    public function manage_category_process(Request $request)
    {

        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required|unique:category',
            'aisle_id'=>'required',

        ]);

        $model=new Category();
        $model->category_name=$request->post('category_name');
        $model->category_slug=$request->post('category_slug');
        $model->aisle_id=$request->post('aisle_id');
        $model->save();
        $request->session()->flash('message', 'Category Inserted');
        return redirect('admin/category');

    }

    public function delete(Request $request, $id)
    {
        $model=Category::find($id);
        $model->delete();
        $request->session()->flash('message', 'Category Deleted');
        return redirect('admin/category');

    }

    public function edit(Request $request, $id)
    {
        $result['aisle']=Aisle::all();
        $result['data']=Category::find($id);
        return view('admin.edit_category',$result);

    }

    public function update(Request $request, $id){
        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required|unique:category,category_slug,'.$id,
            'aisle_id'=>'required',
        ]);

        $model=Category::find($id);
        $model->category_name=$request->post('category_name');
        $model->category_slug=$request->post('category_slug');
        $model->aisle_id=$request->post('aisle_id');
        $model->save();
        $request->session()->flash('message', 'Category Updated');
        return redirect('admin/category');
    }
}
