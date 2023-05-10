<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Products extends Component
{
    public function addToCart($id,$attr_id,$qty, Request $request)
    {
        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempId();
            $user_type="Not-Reg";
        }

        $product_id=$id;
        $product_attr_id=$attr_id;
        $quantity=$qty;

        $check=DB::table('cart')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->where(['product_id'=>$product_id])
        ->where(['product_attr_id'=>$product_attr_id])
        ->get();
        if(isset($check[0])){
            $update_id=$check[0]->id;
            DB::table('cart')
            ->where(['id'=>$update_id])
            ->update(['qty'=>$quantity]);
            $msg="Updated";
        }else{
            $id=DB::table('cart')->insertGetId([
                'user_id'=>$uid,
                'user_type'=>$user_type,
                'product_id'=>$product_id,
                'product_attr_id'=>$product_attr_id,
                'qty'=>$quantity,
                'added_on'=>date('Y-m-d h:i:s'),
            ]);
            $msg="added";
        }
        $this->emit( event:'updateCart');
        // prx($msg);
    }

    public function render()
    {
        $result['best_selling_products']=DB::table('products')
        ->select('products.*','category.category_name', 'category.category_slug')
        ->leftJoin('category','category.id','=','products.category_id')
        ->where(['status'=>1])
        ->where(['best_selling'=>1])
        ->get();

        foreach($result['best_selling_products'] as $list){
            $result['best_product_attr'][$list->id]=
                DB::table('products_attr')
                ->select('products_attr.*','sizes.size')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->where(['products_attr.products_id'=>$list->id])
                ->get();
                
            $result['links'][$list->id]=DB::table('products')
                ->select('category.category_slug', 'aisles.aisle_slug')
                ->leftJoin('category','category.id','=','products.category_id')
                ->leftJoin('aisles','aisles.id','=','category.aisle_id')
                ->where(['products.id'=>$list->id])
                ->first();
               
                $i=0;
                foreach($result['best_product_attr'][$list->id] as $attr){
                    $size[$list->id][$i]=$attr->size;   
                    $i++;
                    $prices[$list->id][]=$attr->price;
                }
                
            $endsize=collect($size[$list->id]);
            $result['sizeArr'][$list->id]=$endsize->implode(' / ');
            
            $minPrice[$list->id]=min($prices[$list->id]);
            $result['minPrice'][$list->id]=$minPrice[$list->id];
        }
        
        $result['discounted_products']=DB::table('products')
        ->select('products.*','category.category_name', 'category.category_slug')
        ->leftJoin('category','category.id','=','products.category_id')
        ->where(['status'=>1])
        ->where(['discounted'=>1])
        ->get();
    
        foreach($result['discounted_products'] as $list){
            $result['discounted_products_attr'][$list->id]=
                DB::table('products_attr')
                ->select('products_attr.*','sizes.size')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->where(['products_attr.products_id'=>$list->id])
                ->get();

            $result['links'][$list->id]=DB::table('products')
                ->select('category.category_slug', 'aisles.aisle_slug')
                ->leftJoin('category','category.id','=','products.category_id')
                ->leftJoin('aisles','aisles.id','=','category.aisle_id')
                ->where(['products.id'=>$list->id])
                ->first();

                $i=0;
                foreach($result['discounted_products_attr'][$list->id] as $attr){
                    $size[$list->id][$i]=$attr->size;   
                    $i++;
                    $prices[$list->id][]=$attr->price;
                    $msrps[$list->id][]=$attr->msrp;
                }

                
            $endsize=collect($size[$list->id]);
            $result['sizeArr'][$list->id]=$endsize->implode(' / ');
            
            $minPrice[$list->id]=min($prices[$list->id]);
            $minMsrp[$list->id]=min($msrps[$list->id]);

            $result['minPrice'][$list->id]=$minPrice[$list->id];
            $result['minMsrp'][$list->id]=$minMsrp[$list->id];

            
        }

        $result['popular_products']=DB::table('products')
        ->select('products.*','category.category_name', 'category.category_slug')
        ->leftJoin('category','category.id','=','products.category_id')
        ->where(['status'=>1])
        ->where(['popular'=>1])
        ->get();

        foreach($result['popular_products'] as $list){
            $result['popular_products_attr'][$list->id]=
                DB::table('products_attr')
                ->select('products_attr.*','sizes.size')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->where(['products_attr.products_id'=>$list->id])
                ->get();

            $result['links'][$list->id]=DB::table('products')
                ->select('category.category_slug', 'aisles.aisle_slug')
                ->leftJoin('category','category.id','=','products.category_id')
                ->leftJoin('aisles','aisles.id','=','category.aisle_id')
                ->where(['products.id'=>$list->id])
                ->first();

                $i=0;
                foreach($result['popular_products_attr'][$list->id] as $attr){
                    $size[$list->id][$i]=$attr->size;   
                    $i++;
                    $prices[$list->id][]=$attr->price;
                }
                
            $endsize=collect($size[$list->id]);
            $result['sizeArr'][$list->id]=$endsize->implode(' / ');
            
            $minPrice[$list->id]=min($prices[$list->id]);
            $result['minPrice'][$list->id]=$minPrice[$list->id];
        }

        return view('livewire.products',$result);
    }
}
