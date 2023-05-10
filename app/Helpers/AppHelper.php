<?php

use Illuminate\Support\Facades\DB;

     function getUserTempId()
     {
        if(session()->get('USER_TEMP_ID')===null){
            $rand=rand(111111111,999999999);
            session()->put('USER_TEMP_ID',$rand);
            return $rand;
        }else{
            return session()->get('USER_TEMP_ID');
        }
     }
     function topNavCart()
     {
        if(session()->has('FRONT_USER_LOGIN')){
            $uid=session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempId();
            $user_type="Not-Reg";
        }
        $result['list']=DB::table('cart')
        ->select('products.id','products.name','products.slug','products.image','cart.id as cart_id', 'cart.product_attr_id', 'cart.qty', 'products_attr.price','sizes.size')
        ->leftJoin('products','products.id','=','cart.product_id')
        ->leftJoin('category','category.id','=','products.category_id')
        ->leftJoin('products_attr','products_attr.id','=','cart.product_attr_id')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->get();
    
        $result['total']=0;
        $result['subTotal'][0]=0;
        foreach($result['list'] as $list){
            $result['subTotal'][$list->cart_id]=$list->qty*$list->price;
            $result['total']+=$result['subTotal'][$list->cart_id];
        }
        $result['cartCount']=count($result['list']);
        // prx($result);
        return ($result);
     }
    function prx($code)
     {
        echo '<pre>';
        print_r($code);
        die;
     }

?>