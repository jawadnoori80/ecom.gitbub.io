<?php

namespace App\Http\Controllers\Front;


use App\Helpers\AppHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function index(Request $request)
    {

        // $result['best_selling_products']=DB::table('products')
        // ->select('products.*','category.category_name', 'category.category_slug')
        // ->leftJoin('category','category.id','=','products.category_id')
        // ->where(['status'=>1])
        // ->where(['best_selling'=>1])
        // ->get();

        // foreach($result['best_selling_products'] as $list){
        //     $result['best_product_attr'][$list->id]=
        //         DB::table('products_attr')
        //         ->select('products_attr.*','sizes.size')
        //         ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        //         ->where(['products_attr.products_id'=>$list->id])
        //         ->get();
               
        //         $i=0;
        //         foreach($result['best_product_attr'][$list->id] as $attr){
        //             $size[$list->id][$i]=$attr->size;   
        //             $i++;
        //             $prices[$list->id][]=$attr->price;
        //         }
                
        //     $endsize=collect($size[$list->id]);
        //     $result['sizeArr'][$list->id]=$endsize->implode(' / ');
            
        //     $minPrice[$list->id]=min($prices[$list->id]);
        //     $result['minPrice'][$list->id]=$minPrice[$list->id];
        // }
        // echo '<pre>';
        // print_r($result['best_product_attr']);
        // die;

        // $result['discounted_products']=DB::table('products')
        // ->select('products.*','category.category_name', 'category.category_slug')
        // ->leftJoin('category','category.id','=','products.category_id')
        // ->where(['status'=>1])
        // ->where(['discounted'=>1])
        // ->get();
    
        // foreach($result['discounted_products'] as $list){
        //     $result['discounted_products_attr'][$list->id]=
        //         DB::table('products_attr')
        //         ->select('products_attr.*','sizes.size')
        //         ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        //         ->where(['products_attr.products_id'=>$list->id])
        //         ->get();

        //         $i=0;
        //         foreach($result['discounted_products_attr'][$list->id] as $attr){
        //             $size[$list->id][$i]=$attr->size;   
        //             $i++;
        //             $prices[$list->id][]=$attr->price;
        //             $msrps[$list->id][]=$attr->msrp;
        //         }

                
        //     $endsize=collect($size[$list->id]);
        //     $result['sizeArr'][$list->id]=$endsize->implode(' / ');
            
        //     $minPrice[$list->id]=min($prices[$list->id]);
        //     $minMsrp[$list->id]=min($msrps[$list->id]);

        //     $result['minPrice'][$list->id]=$minPrice[$list->id];
        //     $result['minMsrp'][$list->id]=$minMsrp[$list->id];

            
        // }

        
        
        // // echo '<pre>';
        // // print_r($result);
        // // die;

        // $result['popular_products']=DB::table('products')
        // ->select('products.*','category.category_name', 'category.category_slug')
        // ->leftJoin('category','category.id','=','products.category_id')
        // ->where(['status'=>1])
        // ->where(['popular'=>1])
        // ->get();

        // foreach($result['popular_products'] as $list){
        //     $result['popular_products_attr'][$list->id]=
        //         DB::table('products_attr')
        //         ->select('products_attr.*','sizes.size')
        //         ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        //         ->where(['products_attr.products_id'=>$list->id])
        //         ->get();

        //         $i=0;
        //         foreach($result['popular_products_attr'][$list->id] as $attr){
        //             $size[$list->id][$i]=$attr->size;   
        //             $i++;
        //             $prices[$list->id][]=$attr->price;
        //         }
                
        //     $endsize=collect($size[$list->id]);
        //     $result['sizeArr'][$list->id]=$endsize->implode(' / ');
            
        //     $minPrice[$list->id]=min($prices[$list->id]);
        //     $result['minPrice'][$list->id]=$minPrice[$list->id];
        // }
        // echo '<pre>';
        // print_r($result['popular_products_attr']);
        // die;

        $result['home_banner']=DB::table('home_banners')
        ->where(['status'=>1])
        ->get();

        $result['page']='home';
        return view('front.index',$result);
    }


    public function product_page(Request $request,$slug)
    {
        $result['product']=DB::table('products')
        ->select('products.*','category.category_name', 'category.category_slug')
        ->leftJoin('category','category.id','=','products.category_id')
        ->where(['status'=>1])
        ->where(['slug'=>$slug])
        ->get();

        $id=$result['product'][0]->id;
        $category_id=$result['product'][0]->category_id;

        
        $result['product_attr']=DB::table('products_attr')
        ->select('products_attr.*','sizes.size')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->where(['products_id'=>$id])
        ->get();


        $result['products_images']=DB::table('products_images')
        ->where(['products_id'=>$id])
        ->get();

        $result['related_products']=DB::table('products')
        ->select('products.*','category.category_name', 'category.category_slug')
        ->leftJoin('category','category.id','=','products.category_id')
        ->where(['category_id'=>$category_id])
        ->inRandomOrder()
        ->limit(8)
        ->get();

        foreach($result['related_products'] as $list){
            $result['related_products_attr'][$list->id]=
                DB::table('products_attr')
                ->select('products_attr.*', 'sizes.size')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->where(['products_attr.products_id'=>$list->id])
                ->get();
            // prx($result['related_products_attr'][$list->id]);
            $result['links'][$list->id]=DB::table('products')
                ->select('category.category_slug', 'aisles.aisle_slug')
                ->leftJoin('category','category.id','=','products.category_id')
                ->leftJoin('aisles','aisles.id','=','category.aisle_id')
                ->where(['products.id'=>$list->id])
                ->first();
                // prx($result['links']);

                $i=0;
                foreach($result['related_products_attr'][$list->id] as $attr){
                    $size[$list->id][$i]=$attr->size;   
                    $i++;
                    $prices[$list->id][]=$attr->price;
                }
                
            $endsize=collect($size[$list->id]);
            $result['sizeArr'][$list->id]=$endsize->implode(' / ');
            
            $minPrice[$list->id]=min($prices[$list->id]);
            $result['minPrice'][$list->id]=$minPrice[$list->id];
        }

        // $result['link']=DB::table('category')
        // ->leftJoin('aisles','aisles.id','=','category.aisle_id')
        // ->where(['products_attr.products_id'=>$list->id])
        // ->get();
        $result['page']='product';
        // prx($result);
        return view('front.product_page',$result);
    }

    public function addToCart(Request $request)
    {

        // echo '<pre>';
        // print_r($request->post());
        // die;


        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempId();
            $user_type="Not-Reg";
        }


       
        
        $product_id=$request->post('id');
        $product_attr_id=$request->post('attr_id');
        $quantity=$request->post('qty');

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
        // return response()->json(['msg'=>$msg]);
    }

    public function update_cart(Request $request)
    {

        


        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid=$request->session()->get('FRONT_USER_ID');
            $user_type="Reg";
        }else{
            $uid=getUserTempId();
            $user_type="Not-Reg";
        }

        
    
        
        $product_id=$request->post('product_id');
        $product_attr_id=$request->post('product_attr_id');
        $quantity=$request->post('product_qty');

        foreach ($product_id as $key => $value) {
            $cartProductArr['product_attr_id']=$product_attr_id[$key];
            $cartProductArr['qty']=$quantity[$key];
           
            DB::table('cart')
            ->where(['user_id'=>$uid])
            ->where(['product_id'=>$product_id[$key]])
            ->update($cartProductArr);
        }
        

    }
    public function cart_page(Request $request)
    {
        // if($request->session()->has('FRONT_USER_LOGIN')){
        //     $uid=$request->session()->get('FRONT_USER_LOGIN');
        //     $user_type="Reg";
        // }else{
        //     $uid=getUserTempId();
        //     $user_type="Not-Reg";
        // }


        
        // $result['list']=DB::table('cart')
        // ->select('products.id','products.name','products.slug','products.image','products.desc','cart.id as cart_id','cart.qty', 'cart.product_attr_id', 'category.category_name', 'category.category_slug', 'products_attr.price')
        // ->leftJoin('products','products.id','=','cart.product_id')
        // ->leftJoin('category','category.id','=','products.category_id')
        // ->leftJoin('products_attr','products_attr.id','=','cart.product_attr_id')
        // ->where(['user_id'=>$uid])
        // ->where(['user_type'=>$user_type])
        // ->get();

        // $result['total']=0;
        // $result['subTotal'][0]=0;

        // foreach($result['list'] as $list){
        //     $result['list_attr'][$list->id]=
        //         DB::table('products_attr')
        //         ->select('products_attr.*','sizes.size')
        //         ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        //         ->where(['products_attr.products_id'=>$list->id])
        //         ->get();

        //         $result['subTotal'][$list->cart_id]=$list->qty*$list->price;
        //         $result['total']+=$result['subTotal'][$list->cart_id];
        // }



        // $result['product_count']=count($result['list']);
        // // prx($result);
        // // prx(topNavCart());
        return view('front.shopping-cart');
    }   
    
    public function delet_cart_item(Request $request)
    {   $id=$request->post('cartId');
        DB::table('cart')
        ->where(['id'=>$id])
        ->delete();
    }

    public function categoryListing(Request $request,$aisle_slug,$category_slug)
    {
        $sort="";
        if($request->get('sort')!==null){
            $sort=$request->get('sort');
        }

        $query=DB::table('products');
        $query=$query->leftJoin('category','category.id','=','products.category_id');
        $query=$query->leftJoin('aisles','aisles.id','=','category.aisle_id');
        $query=$query->leftJoin('products_attr','products_attr.products_id','=','products.id');
        $query=$query->where(['products.status'=>1]);
        $query=$query->where(['category.category_slug'=>$category_slug]);

        if($sort=='name'){
            $query=$query->orderBy('products.name','asc');
        }
        if($sort=='price_desc'){
            $query=$query->orderByRaw('CAST(products_attr.price as unsigned) DESC');
            // $query=$query->orderBy('products_attr.price','desc');
        }if($sort=='price_asc'){
            $query=$query->orderByRaw('CAST(products_attr.price as unsigned) ASC');
        }

        $query=$query->distinct()->select('products.*','category.category_name', 'category.category_slug', 'aisles.aisle_slug');
        $query=$query->paginate(12);
        $result['product']=$query;
        // prx($result['product']);
        foreach($result['product'] as $list1){
           
            $query1=DB::table('products_attr');
            $query1=$query1->select('products_attr.*','sizes.size');
            $query1=$query1->leftJoin('sizes','sizes.id','=','products_attr.size_id');
            $query1=$query1->where(['products_attr.products_id'=>$list1->id]);
            $query1=$query1->get();
            $result['product_attr'][$list1->id]=$query1;

            $i=0;
            foreach($result['product_attr'][$list1->id] as $attr){
                            $size[$list1->id][$i]=$attr->size;   
                            $i++;
                            $prices[$list1->id][]=$attr->price;
                        }

            $endsize=collect($size[$list1->id]);
            $result['sizeArr'][$list1->id]=$endsize->implode(' / ');
            
            $minPrice[$list1->id]=min($prices[$list1->id]);
            $result['minPrice'][$list1->id]=$minPrice[$list1->id];            

        }

        
  
        $result['aisle_slug']=$aisle_slug;

        $aisle_name=DB::table('aisles')->select('aisles.aisle_name')->where(['aisles.aisle_slug'=>$aisle_slug])->first();
        $result['aisle_name']=$aisle_name->aisle_name;
        $result['category_slug']=$category_slug;

        $category_name=DB::table('category')->select('category.category_name')->where(['category.category_slug'=>$category_slug])->first();
        // prx($category_name);
        $result['category_name']=$category_name->category_name;
        $result['sort']=$sort;
 
        
        // $generalResult['result']=$result;

        return view('front.product_listing',$result);
    }
    


    public function search(Request $request)
    {
        $q=$request->get('q');
        // prx($q);
        $sort="";
        if($request->get('sort')!==null){
            $sort=$request->get('sort');
        }

        $query=DB::table('products');
        $query=$query->leftJoin('category','category.id','=','products.category_id');
        $query=$query->leftJoin('aisles','aisles.id','=','category.aisle_id');
        $query=$query->leftJoin('products_attr','products_attr.products_id','=','products.id');
        $query=$query->where(['products.status'=>1]);
        $query=$query->where('products.name','like',"%$q%");
        $query=$query->orwhere('products.brand','like',"%$q%");
        $query=$query->orwhere('products.desc','like',"%$q%");

        if($sort=='relevance'){
            $query=$query->orderBy('relevance','desc');
        }
        if($sort=='price_desc'){
            $query=$query->orderByRaw('CAST(products_attr.price as unsigned) DESC');
            // $query=$query->orderBy('products_attr.price','desc');
        }if($sort=='price_asc'){
            $query=$query->orderByRaw('CAST(products_attr.price as unsigned) ASC');
        }

        $query=$query->distinct()->select('products.*','category.category_name', 'category.category_slug', 'aisles.aisle_slug');
        $query=$query->paginate(12);
        // $query=$query->get();
        $result['product']=$query;
        // prx($result['product']);
        foreach($result['product'] as $list1){
           
            $query1=DB::table('products_attr');
            $query1=$query1->select('products_attr.*','sizes.size');
            $query1=$query1->leftJoin('sizes','sizes.id','=','products_attr.size_id');
            $query1=$query1->where(['products_attr.products_id'=>$list1->id]);
            $query1=$query1->get();
            $result['product_attr'][$list1->id]=$query1;

            $i=0;
            foreach($result['product_attr'][$list1->id] as $attr){
                            $size[$list1->id][$i]=$attr->size;   
                            $i++;
                            $prices[$list1->id][]=$attr->price;
                        }

            $endsize=collect($size[$list1->id]);
            $result['sizeArr'][$list1->id]=$endsize->implode(' / ');
            
            $minPrice[$list1->id]=min($prices[$list1->id]);
            $result['minPrice'][$list1->id]=$minPrice[$list1->id];            

        }

    
        $result['sort']=$sort;
        $result['q']=$q;
 
        // prx($result);

        return view('front.search',$result);
    }


    public function registration(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')!=null) {
            return redirect('/');
        }

     return view('front.registration');
    }

    
    public function registration_process(Request $request)
    {
        $request->validate([
            'firstName'=>'required|string',
            'lastName'=>'required|string',
            'email'=>'required|email|unique:customers,email,', 
            'password'=>'required|min:8',
        ]);
        $rand_id=rand(111111111,999999999);
        $model=new Customer();
        $model->firstName=Str::ucfirst($request->post('firstName'));
        $model->lastName=Str::ucfirst($request->post('lastName'));
        $model->email=$request->post('email');
        $model->status=1;
        $model->is_verify=0;
        $model->is_forgot_password=0;
        $model->rand_id=$rand_id;
        $model->password=Hash::make($request->post('password'));

        $model->save();

        
        $request->session()->put('FRONT_USER_LOGIN',true);
        $request->session()->put('FRONT_USER_ID',$model->id);
        $request->session()->put('FRONT_USER_NAME',$model->firstName);
        
        $name="$model->firstName $model->lastName";

        $data=['name'=>$name,'rand_id'=>"$rand_id"];
        $user['to']=$model->email;
        Mail::send('front/email_verification',$data, function ($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Email Verification');
        });

        // $msg="Your account has been successfully Created.";
        // return response()->json(['status'=>$msg]);
        
    }
    public function login_process(Request $request)
    {
        $result=DB::table('customers')
            ->where(['email'=>$request->str_login_email])
            ->get();

            // prx($_POST);
            // prx($result);
        if(isset($result[0])){
            
            if(Hash::check($request->str_login_password,$result[0]->password)){
                
                if($request->rememberme===null){
                    setcookie('login_email',$request->str_login_email,100);
                    setcookie('login_pwd',$request->str_login_password,100);
                }else{
                   setcookie('login_email',$request->str_login_email,time()+60*60*24*100);
                   setcookie('login_pwd',$request->str_login_password,time()+60*60*24*100);
                }
                
            $request->session()->put('FRONT_USER_LOGIN',true);
            $request->session()->put('FRONT_USER_ID',$result[0]->id);
            $request->session()->put('FRONT_USER_NAME',$result[0]->firstName);

            $getUserTempId=getUserTempId();
                DB::table('cart')  
                    ->where(['user_id'=>$getUserTempId,'user_type'=>'Not-Reg'])
                    ->update(['user_id'=>$result[0]->id,'user_type'=>'Reg']);

            $status="success";
            $error="Login Succesfully";
            }else{
                $status="error";
                $error="Incorrect Email or Password";
            }
        }else{
            $status="error";
            $error="Incorrect email or password";
        }
            



        return response()->json(['status'=>$status,'error'=>$error]);
        // prx(response()->json(['status'=>$status,'error'=>$error]));
    }

    
    public function verification(Request $request,$id)
    {
        $result=DB::table('customers')
            ->where(['rand_id'=>$id])
            ->where(['is_verify'=>0])
            ->get();
            if (isset($result[0])) {
                DB::table('customers')
                ->where(['id'=>$result[0]->id])
                ->update(['is_verify'=>1,'rand_id'=>null]);
                
            return view('front.verification');
            }else {
            return redirect('/');
            }

    }
    
    public function forgot_password(Request $request)
    {
        
        // prx($_POST);
        $result=DB::table('customers')
            ->where(['email'=>strtolower($request->str_reset_email)])
            ->get();

            // prx($_POST);
            // prx($result);
            $rand_id=rand(111111111,999999999);
        if(isset($result[0])){
            DB::table('customers')  
                ->where(['email'=>$request->str_reset_email])
                ->update(['is_forgot_password'=>1,'rand_id'=>$rand_id]);

            $data=['name'=>$result[0]->firstName,'rand_id'=>"$rand_id"];
            $user['to']=$request->str_reset_email;
            Mail::send('front/forgot_email',$data, function ($messages) use ($user){
                $messages->to($user['to']);
                $messages->subject('Reset Password');
            });

            $status='found';
            $msg='We have sent you an email with instructions to reset your password.';

            return response()->json(['status'=>$status,'msg'=>$msg]);
        }else{
            $status="not found";
            $msg="Email not found!";
            
        return response()->json(['status'=>$status,'msg'=>$msg]);
        }
            




    }
    
    public function reset_password(Request $request,$id)
    {
        $result=DB::table('customers')  
        ->where(['rand_id'=>$id])
        ->where(['is_forgot_password'=>1])
        ->get(); 

        if(isset($result[0])){
            $request->session()->put('FORGOT_PASSWORD_USER_ID',$result[0]->id);
        
            return view('front.password_change');
        }else{
            return redirect('/');
        }



    }
    public function reset_password_process(Request $request)
    {
        DB::table('customers')  
            ->where(['id'=>$request->session()->get('FORGOT_PASSWORD_USER_ID')])
            ->update(
                [
                    'is_forgot_password'=>0,
                    'password'=>Hash::make($request->new_password),
                    'updated_at'=>date('Y-m-d h:i:s'),
                    'rand_id'=>null
                ]
            );

            $result=DB::table('customers')
            ->where(['id'=>$request->session()->pull('FORGOT_PASSWORD_USER_ID')])
            ->get();

            $request->session()->put('FRONT_USER_LOGIN',true);
            $request->session()->put('FRONT_USER_ID',$result[0]->id);
            $request->session()->put('FRONT_USER_NAME',$result[0]->firstName);

            setcookie('login_email', "", 100, '/');
            setcookie('login_pwd', "", 100, '/');

        return response()->json(['status'=>'success','msg'=>'Password changed successfully']);     



    }

    public function checkout(Request $request)
    {
        // prx(topNavCart());
        $result=topNavCart();


        // prx($result);
        if($result['cartCount']>0){

            if($request->session()->has('FRONT_USER_LOGIN')){
                // $uid=$request->session()->get('FRONT_USER_ID');
                // $customer_info=DB::table('customers')  
                //     ->where(['id'=> $uid])
                //      ->get(); 
                //     // prx($customer_info);
                // $result['customers']['firstName']=$customer_info[0]->firstName;
                // $result['customers']['lastName']=$customer_info[0]->lastName;
                // $result['customers']['email']=$customer_info[0]->email;
                // $result['customers']['mobile']=$customer_info[0]->mobile;
                // $result['customers']['company']=$customer_info[0]->company;
                // $result['customers']['address']=$customer_info[0]->address;
                // $result['customers']['optionalAdd']=$customer_info[0]->optionalAdd;
                // $result['customers']['city']=$customer_info[0]->city;
                // $result['customers']['state']=$customer_info[0]->state;
                // $result['customers']['postCode']=$customer_info[0]->postCode;
            }else{
                // $result['customers']['firstName']='';
                // $result['customers']['lastName']='';
                // $result['customers']['email']='';
                // $result['customers']['mobile']='';
                // $result['customers']['company']='';
                // $result['customers']['address']='';
                // $result['customers']['optionalAdd']='';
                // $result['customers']['city']='';
                // $result['customers']['state']='';
                // $result['customers']['postCode']='';
            }

        // prx($result);
            return view('front.checkout',$result);
        }else{
            return back();
        }
    }

    
    // public function create_order(Request $request)
    // {
    //     $orderID = 132;

    //     // return $orderID;     
    //     return response()->json(['orderId'=>$orderID]);


    // }
    public function orders(Request $request)
    {
        $result['orders']=DB::table('orders')
        ->where(['customer_id'=>$request->session()->get('FRONT_USER_ID')])
        ->get(); 

        // prx($result);
        return view('front.orders',$result);
    }
    
    public function order_details(Request $request, $id)
    {
        $result['order_details']=DB::table('orders')
        ->where(['id'=>$id])
        // ->where(['customer_id'=>$request->session()->get('FRONT_USER_ID')])
        ->get();

        // prx($result['order_details']);

        $result['items']=DB::table('order_details')
        ->where(['order_id'=>$id])
        ->get();
        
        foreach($result['items'] as $list){

            $result['name'][$list->product_id]=DB::table('products')
            ->select('products.name')
            ->where(['id'=>$list->product_id])
            ->first();



            $size_id=DB::table('products_attr')
            ->select('products_attr.size_id')
            ->where(['id'=>$list->product_attr_id])
            ->get();

            
            $result['size'][$list->product_id]=DB::table('sizes')
            ->select('sizes.size')
            ->where(['id'=>$size_id[0]->size_id])
            ->first();
            
        }

        return view('front.order_details',$result);
    }

    
    public function my_account(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')==null) {
            return redirect('/');
        }
            $uid=$request->session()->get('FRONT_USER_ID');
            $customer_info=DB::table('customers')  
                ->where(['id'=> $uid])
                 ->get(); 
            $result['user']['firstName']=$customer_info[0]->firstName;
            $result['user']['lastName']=$customer_info[0]->lastName;
            $result['user']['email']=$customer_info[0]->email;

        return view('front.my_account',$result);
    }

    public function update_account(Request $request)
    {
        $user=DB::table('customers')
        ->where(['id'=>$request->session()->get('FRONT_USER_ID')])
        ->get();

        if ($user[0]->email === $request->post('email') ) {
            $request->validate([
                'firstName'=>'required|string',
                'lastName'=>'required|string',
            ]);
        }else {
            $request->validate([
                'firstName'=>'required|string',
                'lastName'=>'required|string',
                'email'=>'required|email|unique:customers,email,', 
            ]);
        }

        if ($request->post('currentPassword') != null) {
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|min:8',
                'confirmPassword' => 'required|min:8|same:newPassword',
            ]);

    
            if (Hash::check($request->post('currentPassword'),$user[0]->password)) {
                // update Passwords
                DB::table('customers')->where(['id' => $request->session()->get('FRONT_USER_ID')])
                    ->update([
                        'firstName' => $request->post('firstName'),
                        'lastName' => $request->post('lastName'),
                        'email' => $request->post('email'),
                        'password' => Hash::make($request->post('newPassword')),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
        
                setcookie('login_email', $request->post('email'), time()+60*60*24*100, '/');
                setcookie('login_pwd', $request->post('newPassword'), time()+60*60*24*100, '/');
                $request->session()->put('FRONT_USER_NAME',$request->post('firstName'));
        
                $result['status'] = "success";
                $result['msg'] = "Password Changed Successfully!";
                return $result;
            } else {
                $result['status'] = "error";
                $result['msg'] = "Incorrect Old Password!";
                return $result;
            }
        }else {
            // update names only
            DB::table('customers')->where(['id' => $request->session()->get('FRONT_USER_ID')])
                ->update([
                    'firstName' => $request->post('firstName'),
                    'lastName' => $request->post('lastName'),
                    'email' => $request->post('email'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);

            $request->session()->put('FRONT_USER_NAME',$request->post('firstName'));

            $result['status'] = "success";
            $result['msg'] = "User Credentials changed!";
            return $result;
        }
    }


    public function test(Request $request)
    {

        // $users = DB::table('customers')->get();
        
        // foreach($users as $user){
        //     $plain=Crypt::decrypt($user->password);
            
        //     DB::table('customers')->where(['id' => $user->id])
        //     ->update([
        //         'password' => Hash::make($plain)
        //     ]);
        // }
        // prx($plain);
        
        // prx($users);


        // $uid=session()->get('FRONT_USER_ID');
        //   $cartUid=session()->get('FRONT_USER_ID');
        //   $email=DB::table('customers')
        //   ->where(['id'=>$uid])
        //   ->value('email');

        // prx($email[0]->email);
        $result=topNavCart();
        return view("front.checkout", $result);
    }
}

