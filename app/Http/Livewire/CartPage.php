<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Map\AssociativeArrayMap;
use stdClass;
use Illuminate\Support\Str;

class CartPage extends Component
{
    public function remove_item($cart_id)
    {
        DB::table('cart')
        ->where(['id'=>$cart_id])
        ->delete();
        $this->emit( event:'updateCart');

    }
    public function render(Request $request)
    {
        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempId();
            $user_type="Not-Reg";
        }


        
        $result['list']=DB::table('cart')
        ->select('products.id','products.name','products.slug','products.image','products.desc','cart.id as cart_id','cart.qty', 'cart.product_attr_id', 'category.category_name', 'category.category_slug', 'products_attr.price','products_attr.sku')
        ->leftJoin('products','products.id','=','cart.product_id')
        ->leftJoin('category','category.id','=','products.category_id')
        ->leftJoin('products_attr','products_attr.id','=','cart.product_attr_id')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->get();

        $result['total']=0;
        $result['subTotal'][0]=0;
        // $list=$result['list'];
        // $list=json_encode($list);        
        // $list=json_decode($list);    
        
        // $guest['firstName']="jawad";
        // $guest['lastName']="Noori";

        // $test=array_values($guest);
        // $random=str::random(15);
        // echo $random;
        // die;
        // prx($randdom);
        // // print_r(array_values($guest));
        // // die;
        // // print_r($guest[0]);
        // echo $test[0];
        // echo $test[1];
        // die;

        // prx($list);
        foreach($result['list'] as $list){
            $result['list_attr'][$list->id]=
                DB::table('products_attr')
                ->select('products_attr.*','sizes.size')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->where(['products_attr.products_id'=>$list->id])
                ->get();
                
                $result['subTotal'][$list->cart_id]=$list->qty*$list->price;
                $result['total']+=$result['subTotal'][$list->cart_id];
            }
       
        $result['product_count']=count($result['list']);
        // prx($result);
        // prx($name_size);
        return view('livewire.cart-page',$result);




        
    }
}
