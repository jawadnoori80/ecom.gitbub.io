<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCard extends Component
{
        public $product;
        public $product_attr;
        public $qty;
        // public $minPrice;
    //     public $prd_id;

    // public array $attr_id= [];
    // public array $qty= [];

    protected $listeners = [
        // 'updateCart' => 'render',
        'refresh-me' => '$refresh'
    ];
    public function updateCart(){
        return;
    }
    public function add($id,$attr_id,$qty,Request $request)
    {

        // prx($request->post());
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
        // return $msg;
        // return;
    }
    public function mount($product,$product_attr,$qty)
    {

            $this->product_id = $product;
            $this->product_attr = $product_attr;
            $this->qty = $qty;

    }

    public function render()
    {

        // $this->product=$product->toArray();
        return view('livewire.product-card');
    }
}
