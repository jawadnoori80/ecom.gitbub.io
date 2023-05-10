<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Echo_;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Returns products details
    public function index()
    {
        
        $result['data']=Product::orderByDesc('id')->paginate(12);
        return view('admin/product',$result);
    }

    //Returns category and Sizes for adding a new Product
    public function manage_product()
    {
        $result['category']=DB::table('category')->get();
        $result['sizes']=DB::table('sizes')->get();
        
        return view('admin.manage_product',$result);
    }

    //this function adds a new product to the database with information provided
    public function manage_product_process(Request $request)
    {

        
        
        /*echo '<pre>';
        print_r($request->post('piid'));
        die;*/
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug',
            'image'=>'required|mimes:jpeg,jpg,png',
            'images.*'=>'mimes:jpeg,jpg,png',
            'category_id'=>'required',
            'brand'=>'required',
            'desc'=>'required',
            'sku'=>'required|unique:products_attr,sku',
            'size_id'=>'required',
            'price'=>'required',
            'msrp[]'=>'int|nullable',
        ]);

        //PRODUCT INFORMATION
        $model=new Product();
        $model->name=$request->post('name');
        $model->slug=$request->post('slug');
        $model->category_id=$request->post('category_id');
        $model->brand=$request->post('brand');
        $model->desc=$request->post('desc');
        $model->status=1;
        if(null !== $request->post('best_selling')){
            $model->best_selling=$request->post('best_selling');
        }else{
            $model->best_selling=0;
        }

        if(null !== $request->post('discounted')){
            $model->discounted=$request->post('discounted');
        }else{
            $model->discounted=0;
        }

        if(null !== $request->post('popular')){
            $model->popular=$request->post('popular');
        }else{
            $model->popular=0;
        }

        if($request->hasfile('image')){
            $rand =rand('111111111','999999999');
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=$rand.'.'.$ext;
            $image->storeAs('/public/media/product_img',$image_name);
            $model->image=$image_name;
        }

        $model->save();
        $PID=$model->id;

        //PRODUCT ATTRIBUTES INFORMATION

        $skuArr=$request->post('sku'); 
        $priceArr=$request->post('price'); 
        $msrpArr=$request->post('msrp'); 
        $size_idArr=$request->post('size_id');

        foreach($skuArr as $key=>$val){
            $productAttrArr['products_id']=$PID;
            $productAttrArr['sku']=$skuArr[$key];
            $productAttrArr['size_id']=$size_idArr[$key];
            $productAttrArr['price']=$priceArr[$key];
            $productAttrArr['msrp']=$msrpArr[$key];
            $productAttrArr['created_at']=date('Y-m-d H:i:s');
            $productAttrArr['updated_at']=date('Y-m-d H:i:s');

            DB::table('products_attr')->insert($productAttrArr);
        }
        

        $image_id=$request->post('piid');
        foreach($image_id as $key=>$val){
            if($request->hasfile("images.$key")){
            $rand =rand('111111111','999999999');
            $image=$request->file("images.$key");
            $ext=$image->extension();
            $image_name=$rand.'.'.$ext;
            $image->storeAs('/public/media/product_img',$image_name);
            $imageArr['images']=$image_name;
            $imageArr['products_id']=$PID;

            DB::table('products_images')->insert($imageArr);

        }
        }


        $request->session()->flash('message', 'Product Inserted');
        return redirect('admin/product');

    }
    //this function deletes the product with the given ID and the corresponding product_attributes
    public function delete(Request $request, $id)
    {
        $model=Product::find($id);
        
        $arrImage=[];
        $arrImage=DB::table('products')->where(['id'=>$id])->get();
        if(Storage::exists('/public/media/product_img/'.$arrImage[0]->image)){
            Storage::delete('/public/media/product_img/'.$arrImage[0]->image);
        }
        $model->delete();

        $arrImage=[];
        $arrImage=DB::table('products_images')->where(['products_id'=>$id])->get();
        foreach($arrImage as $key=>$val){
            if(Storage::exists('/public/media/product_img/'.$arrImage[$key]->images)){
                Storage::delete('/public/media/product_img/'.$arrImage[$key]->images);
            }
        }

        DB::table('products_images')->where(['products_id'=>$id])->delete();
        DB::table('products_attr')->where(['products_id'=>$id])->delete();
        
        $request->session()->flash('message', 'Product Deleted');
        return redirect('admin/product');

    }

    //this function redirects to the edit page where you can edit product informations of the product ID given
    public function edit(Request $request, $id)
    {
        $result['data']=Product::find($id);
        $result['category']=DB::table('category')->get();
        $result['sizes']=DB::table('sizes')->get();
        $result['productAttrArr']=DB::table('products_attr')->where(['products_id'=>$id])->get();
        $result['productImagesrArr']=DB::table('products_images')->where(['products_id'=>$id])->get();

        return view('admin.edit_product',$result);

    }

    //this function only deletes the product attributes data
    public function product_attr_delete(Request $request,$paId){
        DB::table('products_attr')->where(['id'=>$paId])->delete();
        //return redirect('admin/product/manage_product/'.$pid);
    }
    
    public function product_image_delete(Request $request,$pIId){
        $arrImage=[];
        $arrImage=DB::table('products_images')->where(['id'=>$pIId])->get();
        if(Storage::exists('/public/media/product_img/'.$arrImage[0]->images)){
            Storage::delete('/public/media/product_img/'.$arrImage[0]->images);
        }
        DB::table('products_images')->where(['id'=>$pIId])->delete();
        //return redirect('admin/product/manage_product/'.$pid);
    }

    //this function updates the product information and attribute with the edited data
    public function update(Request $request, $id){


        
        $request->validate([
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$id,
            'image'=>'mimes:jpeg,jpg,png',
            'images.*'=>'mimes:jpeg,jpg,png',
            'category_id'=>'required',
            'brand'=>'required',
            'desc'=>'required',
            'size_id'=>'required',
            'price'=>'required',
            'msrp.*'=>'nullable',
            'sku.*'=>[
                'distinct',
                Rule::unique('products_attr', 'sku')->ignore($id,'products_id'),
                ],    
        ]);
        
        $model=Product::find($id);
        $model->name=$request->post('name');
        $model->slug=$request->post('slug');
        $model->category_id=$request->post('category_id');
        $model->brand=$request->post('brand');
        $model->desc=$request->post('desc');
        if(null !== $request->post('best_selling')){
            $model->best_selling=$request->post('best_selling');
        }else{
            $model->best_selling=0;
        }

        if(null !== $request->post('discounted')){
            $model->discounted=$request->post('discounted');
        }else{
            $model->discounted=0;
        }
        
        if(null !== $request->post('popular')){
            $model->popular=$request->post('popular');
        }else{
            $model->popular=0;
        }
        $model->status='1';

        if($request->hasfile('image')){
            $arrImage=[];
            $arrImage=DB::table('products')->where(['id'=>$id])->get();
            if(Storage::exists('/public/media/product_img/'.$arrImage[0]->image)){
                Storage::delete('/public/media/product_img/'.$arrImage[0]->image);
            }
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->storeAs('/public/media/product_img',$image_name);
            $model->image=$image_name;
        }

        $model->save();

        $PID=$model->id;

        //PRODUCT ATTRIBUTES INFORMATION
        $paidArr=$request->post('paid');
        $skuArr=$request->post('sku'); 
        $priceArr=$request->post('price'); 
        $msrpArr=$request->post('msrp'); 
        $size_idArr=$request->post('size_id');

        foreach($skuArr as $key=>$val){
            if($paidArr[$key]==''){
                $productAttrArr['products_id']=$PID;
                $productAttrArr['sku']=$skuArr[$key];
                $productAttrArr['size_id']=$size_idArr[$key];
                $productAttrArr['price']=$priceArr[$key];
                $productAttrArr['msrp']=$msrpArr[$key];
                $productAttrArr['created_at']=date('Y-m-d H:i:s');
                $productAttrArr['updated_at']=date('Y-m-d H:i:s');

                DB::table('products_attr')->insert($productAttrArr);
            }else{
                $productAttrArr['products_id']=$PID;
                $productAttrArr['sku']=$skuArr[$key];
                $productAttrArr['size_id']=$size_idArr[$key];
                $productAttrArr['price']=$priceArr[$key];
                $productAttrArr['msrp']=$msrpArr[$key];
                $productAttrArr['updated_at']=date('Y-m-d H:i:s');

                DB::table('products_attr')->where(['id'=>$paidArr[$key]])->update($productAttrArr);
            }
        }

        $image_id=$request->post('piid');
        /*echo '<pre>';
        print_r($image_id);
        die;*/
        foreach($image_id as $key=>$val){
            if($image_id[$key]!=''){
                if($request->hasfile("images.$key")){
                    $arrImage=DB::table('products_images')->where(['id'=>$image_id[$key]])->get();
                    if(Storage::exists('/public/media/product_img/'.$arrImage[0]->images)){
                        Storage::delete('/public/media/product_img/'.$arrImage[0]->images);
                    }
                    $rand =rand('111111111','999999999');
                    $image=$request->file("images.$key");
                    $ext=$image->extension();
                    $image_name=$rand.'.'.$ext;
                    $image->storeAs('/public/media/product_img',$image_name);
                    $imageArr=[];
                    $imageArr['images']=$image_name;
                    $imageArr['products_id']=$PID;

                    DB::table('products_images')->where(['id'=>$image_id[$key]])->update($imageArr);
                }
            }
            
            if($image_id[$key]==''){
                if($request->hasfile("images.$key")){
                $rand =rand('111111111','999999999');
                $image=$request->file("images.$key");
                $ext=$image->extension();
                $image_name=$rand.'.'.$ext;
                $image->storeAs('/public/media/product_img',$image_name);
                $imageArr=[];
                $imageArr['images']=$image_name;
                $imageArr['products_id']=$PID;

                DB::table('products_images')->insert($imageArr);

                }
            }
        }


        $request->session()->flash('message', 'Product Updated');
        return redirect('admin/product');
    }
    
    public function status(Request $request,$status,$id){
        $model=Product::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Product status updated');
        return redirect('admin/product');
    }
    
    public function search(Request $request){
        $q=$request->get('q');
        // prx($q);

        $query=DB::table('products');
        $query=$query->where('products.name','like',"%$q%");
        $query=$query->orwhere('products.slug','like',"%$q%");
        $query=$query->orwhere('products.brand','like',"%$q%");
        $query=$query->orwhere('products.desc','like',"%$q%");

        $query=$query->distinct()->select('products.*');
        $query=$query->paginate(2);

        $result['products']=$query;
        $result['q']=$q;
        // prx($result);


        return view('admin.product_search', $result);

        // $result['data']=Product::all();
    }

    
}
