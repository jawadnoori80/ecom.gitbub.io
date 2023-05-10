<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Aisle;
use Illuminate\Http\Request;

class AisleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Aisle::all();
        return view('admin.aisle', $result);
    }

    public function manage_aisle()
    {
        return view('admin.manage_aisle');
    }

    public function manage_aisle_process(Request $request)
    {

        $request->validate([
            'aisle_name'=>'required',
            'aisle_slug'=>'required|unique:aisles',

        ]);

        $model=new Aisle();
        $model->aisle_name=$request->post('aisle_name');
        $model->aisle_slug=$request->post('aisle_slug');
        $model->save();
        $request->session()->flash('message', 'Aisle Inserted');
        return redirect('admin/aisle');

    }

    public function delete(Request $request, $id)
    {
        $model=Aisle::find($id);
        $model->delete();
        $request->session()->flash('message', 'Aisle Deleted');
        return redirect('admin/aisle');

    }

    
    public function edit(Request $request, $id)
    {
        $result['data']=Aisle::find($id);
        return view('admin.edit_aisle',$result);

    }

    public function update(Request $request, $id){
        $request->validate([
            'aisle_name'=>'required',
            'aisle_slug'=>'required|unique:aisles,aisle_slug,'.$id,

        ]);

        $model=Aisle::find($id);
        $model->aisle_name=$request->post('aisle_name');
        $model->aisle_slug=$request->post('aisle_slug');
        $model->save();
        $request->session()->flash('message', 'Aisle Updated');
        return redirect('admin/aisle');
    }
}
