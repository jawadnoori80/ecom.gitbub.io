<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Resources\MergeValue;


class PaypalController extends Controller
{
  private $order_id;
  private $uid;
  private $user_type;
    public function create(Request $request)
    {
      return $this->createOrder();
    }

    public function capture($orderId)
    {
      
      return  $this->capturePayment($orderId);
    }

    private function createOrder() 
    {
      if(session()->has('FRONT_USER_LOGIN')){
      $uid=session()->get('FRONT_USER_ID');
      $user_type="Reg";
      }else{
          $uid=getUserTempId();
          $user_type="Not-Reg";
      }
      $result['list']=DB::table('cart')
      ->select('products.id','products.name','products.slug','products.image','products.desc','cart.id as cart_id','cart.qty', 'cart.product_attr_id', 'products_attr.price','products_attr.sku')
      ->leftJoin('products','products.id','=','cart.product_id')
      ->leftJoin('products_attr','products_attr.id','=','cart.product_attr_id')
      ->where(['user_id'=>$uid])
      ->where(['user_type'=>$user_type])
      ->get();

      $total=0;
      $result['subTotal'][0]=0;
      foreach($result['list'] as $list){
          $result['list_attr'][$list->id]=
              DB::table('products_attr')
              ->select('products_attr.*','sizes.size')
              ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
              ->where(['products_attr.products_id'=>$list->id])
              ->get();

              $obj=$result['list_attr'][$list->id][0];
              $size[$list->id]=$obj->size;

              $result['subTotal'][$list->cart_id]=$list->qty*$list->price;
              $total+=$result['subTotal'][$list->cart_id];
              
      }
      $result['product_count']=count($result['list']);

      $arr = []; //create empty array

      foreach($result['list'] as $list) {
        $name_size="{$list->name} - {$size[$list->id]}";

          $arr[] = 
              [
                "sku"=> "$list->sku",
                "name"=> "$name_size",
                "quantity"=> "$list->qty",
                "unit_amount"=> [
                    "currency_code"=> "AUD",
                    "value"=> "$list->price",
                ],
              ];//assign each sub-array to the newly created array
      } 


              $order=[
                "customer_id"=>$uid,
                "order_status"=>"Pending",
                "payment_status"=>"Pending",
                "total"=>$total,
            ];
            $order_id=DB::table('orders')->insertGetId($order);
            session()->put('ORDER_ID',$order_id);
            // $this->order_id=$order_id;
            // $this->uid=$uid;
            // $this->user_type=$user_type;

            $rand=rand(1111,9999);
            $invoice_id="SOH-$rand-$order_id";

            foreach($result['list'] as $list){
              $prductDetailsArr['product_id']=$list->id;
              $prductDetailsArr['product_attr_id']=$list->product_attr_id;
              $prductDetailsArr['price']=$list->price;
              $prductDetailsArr['quantity']=$list->qty;
              $prductDetailsArr['order_id']=$order_id;
              DB::table('order_details')->insert($prductDetailsArr);
            }

        $accessToken = $this->generateAccessToken();
        $url = $this->getBaseUrl()."/v2/checkout/orders";
        $response =Http::withHeaders([
            'Authorization'=>"Bearer $accessToken",
            "Content-Type"=> "application/json",
        ])->withBody(json_encode([
            "intent"=> "CAPTURE",
            "purchase_units"=> [
              [
                // "reference_id"=> "d9f80740-38f0-11e8-b467-0ed5f89f718b",
                "custom_id"=>"$order_id",
                "invoice_id"=>"$invoice_id",
                "amount"=> [
                  "currency_code"=> "AUD",
                  "value"=> "$total",
                  "breakdown"=> [
                    "item_total"=> [
                      "currency_code"=> "AUD",
                      "value"=> "$total",
                    ],
                  ],
                 
                ],
                "items"=> $arr,
                
              ],
            ],
        ]),'application/json')
        ->post($url);
        $data = $response->json();
        if($response->successful()){
        return response()->json($data, 200);
        }
        DB::table('orders')
        ->where(['id'=>$order_id])
        ->delete();

        DB::table('order_details')
        ->where(['order_id'=>$order_id])
        ->delete();

        return response()->json($data, 500);//error
      }

      // use the orders api to capture payment for an order
private function capturePayment($orderId) {
    
     $url = $this->getBaseUrl()."/v2/checkout/orders/$orderId/capture";
    $accessToken = $this->generateAccessToken();
    $response =Http::withHeaders([
        'Authorization'=>"Bearer $accessToken",
        "Content-Type"=> "application/json",
    ])->withBody('{}','application/json')
    ->post($url);
    $data = $response->json();
    if($response->successful()){
        // save in database
        // $newData = response()->json($data);
        // prx($data);
        $order_data=(object)$data['purchase_units'][0];
        $payment_source=(object)$data['payment_source'];
        $name=(object)$order_data->shipping['name'];
        $address=(object)$order_data->shipping['address'];
        $payments=(object)$order_data->payments['captures'][0];
        // prx($order_data);

        

        if(session()->has('FRONT_USER_LOGIN')){
          // $uid=session()->get('FRONT_USER_ID');
          // $cartUid=session()->get('FRONT_USER_ID');
          // $email=DB::table('customers')
          // ->select('customers.email')
          // ->where(['id'=>$uid])
          // ->get();
          $uid=session()->get('FRONT_USER_ID');
          $cartUid=session()->get('FRONT_USER_ID');
          $email=DB::table('customers')
          ->where(['id'=>$uid])
          ->value('email');
          }else{
            $cartUid=getUserTempId();
            $guest_account_names=array_values($payment_source->paypal['name']);
            $guest_account['first_name']=$guest_account_names[0];
            $guest_account['last_name']=$guest_account_names[1];
            $guest_account['email']=$payment_source->paypal['email_address'];
            $email=$this->register_guest($guest_account);
            $uid=session()->get('FRONT_USER_ID');
          }
          
          // prx($guest_account);


        $order['name']=$name->full_name;
        $order['email']=$email;
        $order['city']=$address->admin_area_2;
        $order['state']=$address->admin_area_1;
        $order['address']=$address->address_line_1;
        $order['optional_add']=$address->address_line_2;
        $order['post_code']=$address->postal_code;
        $order['order_status']="Placed";
        $order['payment_status']="Successful";
        $order['transaction_id']=$payments->id;
        $order['invoice_id']=$payments->invoice_id;
        $order['customer_id']=$uid;
        $order_id=session()->get('ORDER_ID');

        DB::table('orders')
        ->where(['id'=>$order_id])
        ->update($order);

        DB::table('cart')
        ->where(['user_id'=>$cartUid])
        ->delete();

      
    return response()->json($data, 200);
    }
    return response()->json($data, 500);//error
  }
// generate an access token using client id and app secret
private function generateAccessToken() {
    
    $auth =base64_encode(env('PAYPAL_CLIENT').":".env('PAYPAL_SECRET'));
    $url=$this->getBaseUrl()."/v1/oauth2/token";
    $response =Http::withHeaders([
        'Authorization'=>"Basic $auth"
    ])->asForm()
    ->post($url,[
        'grant_type'=>'client_credentials'
    ]);
    $data =  $response->json();
    if($response->successful()){
        return $data['access_token'];
    }
    return null;
  }

  private function getBaseUrl(){
      if(env('APP_ENV')=='production')
      return "https://api-m.paypal.com";

      return "https://api-m.sandbox.paypal.com";
  }


  private function register_guest($guest){

    $randPass=str::random(15);
    $rand_id=str::random(15);
    $model=new Customer();
    $model->firstName=$guest['first_name'];
    $model->lastName=$guest['last_name'];
    $model->email=$guest['email'];
    $model->status=1;
    $model->is_verify=0;
    $model->is_forgot_password=0;
    $model->rand_id=$rand_id;
    $model->password=Hash::make($randPass);

    $model->save();

    session()->put('FRONT_USER_LOGIN',true);
    session()->put('FRONT_USER_ID',$model->id);
    session()->put('FRONT_USER_NAME',$model->firstName);

    $name="$model->firstName $model->lastName";
    $data=['name'=>$name,'rand_id'=>"$rand_id",'email'=>"$model->email",'rand_pass'=>"$randPass"];
    $user['to']="jawadnoori80@gmail.com";
    Mail::send('front/guest_account_verify',$data, function ($messages) use ($user){
    $messages->to($user['to']);
    $messages->subject('Thanks for your order');
    });

    return $model->email;



  }
  
}

