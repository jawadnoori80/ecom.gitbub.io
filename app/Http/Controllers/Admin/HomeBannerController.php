<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\HomeBanner;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HomeBannerController extends Controller
{
    public function index()
    {
        $result['data']=HomeBanner::all();
        return view('admin.HB', $result);
    }

    public function manage_HB()
    {
        return view('admin.manage_HB');
    }

    public function manage_HB_process(Request $request)
    {

        $request->validate([
            'hb_tag'=>'required',
            'hb_text'=>'required',
            'hb_link'=>'required',
            'image'=>'required|mimes:jpeg,jpg,png',
        ]);

        $model=new HomeBanner();
        $model->tag=$request->post('hb_tag');
        $model->text=$request->post('hb_text');
        $model->link=$request->post('hb_link');
        $model->status=1;

        if($request->hasfile('image')){
            $rand =rand('111111111','999999999');
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=$rand.'.'.$ext;
            $image->storeAs('/public/media/banners',$image_name);
            $model->image=$image_name;
        }


        $model->save();
        $request->session()->flash('message', 'Banner Inserted');
        return redirect('admin/HB');

    }

    public function delete(Request $request, $id)
    {
        $model=HomeBanner::find($id);

        $arrImage=[];
        $arrImage=DB::table('home_banners')->where(['id'=>$id])->get();
        if(Storage::exists('/public/media/banners/'.$arrImage[0]->image)){
            Storage::delete('/public/media/banners/'.$arrImage[0]->image);
        }

        $model->delete();
        $request->session()->flash('message', 'Banner Deleted');
        return redirect('admin/HB');

    }

    
    public function edit(Request $request, $id)
    {
        $result['data']=HomeBanner::find($id);
        return view('admin.edit_HB',$result);

    }

    public function update(Request $request, $id){
        $request->validate([
            'hb_tag'=>'required',
            'hb_text'=>'required',
            'hb_link'=>'required',
            'image'=>'mimes:jpeg,jpg,png',
        ]);

        $model=HomeBanner::find($id);
        $model->tag=$request->post('hb_tag');
        $model->text=$request->post('hb_text');
        $model->link=$request->post('hb_link');

        if($request->hasfile('image')){
            $arrImage=[];
            $arrImage=DB::table('home_banners')->where(['id'=>$id])->get();
            if(Storage::exists('/public/media/banners/'.$arrImage[0]->image)){
                Storage::delete('/public/media/banners/'.$arrImage[0]->image);
            }
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->storeAs('/public/media/banners',$image_name);
            $model->image=$image_name;
        }


        $model->save();
        $request->session()->flash('message', 'Banner Updated');
        return redirect('admin/HB');
    }

    public function status(Request $request,$status,$id){
        $model=HomeBanner::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Banner status updated');
        return redirect('admin/HB');
    }

}
