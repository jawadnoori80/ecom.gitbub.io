<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $cache;

    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    public function index(Request $request)
    {
        if($request->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return view('admin/login');
        }

    }

    
    public function auth(Request $request)
    {
        $email=$request->post('email');
        $password=$request->post('password');

        //$result=Admin::where(['email'=>$email, 'password'=>$password])->get();
        $attemptCount = $this->cache->get("login-attempts-{$request->ip()}", 0);

        if ($attemptCount >= 5) {
            abort(429, 'Too many login attempts. Please try again later.');
        }

        $result=Admin::where(['email'=>$email])->first();

        if($result){
            if(Hash::check($request->post('password'),$result->password)){
                $request->session()->put('ADMIN_LOGIN', true);
                $request->session()->put('ADMIN_ID', $result->id);
                $request->session()->put('ADMIN_NAME',$result->firstName);
                
                $this->cache->forget("login-attempts-{$request->ip()}");

                return redirect('admin/dashboard');
            }else{
                $this->cache->put("login-attempts-{$request->ip()}", $attemptCount + 1, 1);

                $request->session()->flash('error', 'Please Enter Correct Password');
                return redirect('admin');
            }
        
        }else{

            $request->session()->flash('error', 'Please Enter Valid Login Details');
            return redirect('admin');
        }
    }
    public function dashboard()
    {
        $result['orders'] = DB::table('orders')
            ->orderBy('added_on', 'desc')
            ->paginate(10);

        return view('admin.dashboard', $result);
    }
    public function search(Request $request)
    {
        $q=$request->get('q');
        // prx($q);

        $query=DB::table('orders');
        $query=$query->where('orders.id','like',"%$q%");
        $query=$query->orwhere('orders.customer_id','like',"%$q%");
        $query=$query->orwhere('orders.name','like',"%$q%");
        $query=$query->orwhere('orders.email','like',"%$q%");
        $query=$query->orwhere('orders.city','like',"%$q%");
        $query=$query->orwhere('orders.total','like',"%$q%");
        $query=$query->orwhere('orders.invoice_id','like',"%$q%");
        $query=$query->orwhere('orders.transaction_id','like',"%$q%");
        $query=$query->orwhere('orders.payment_status','like',"%$q%");
        $query=$query->orwhere('orders.order_status','like',"%$q%");
        
        $query=$query->distinct()->select('orders.*');
        $query=$query->orderByDesc('orders.added_on');
        $query=$query->paginate(12);

        $result['orders']=$query;
        $result['q']=$q;
        // prx($result);
        return view('admin.orders_search', $result);
    }

    public function Order_details(Request $request, $id)
    {
        $result['order_details']=DB::table('orders')
        ->where(['id'=>$id])
        ->get();

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

            $result['sku'][$list->product_id]=DB::table('products_attr')
            ->select('products_attr.sku')
            ->where(['id'=>$list->product_attr_id])
            ->first();

            
            $result['size'][$list->product_id]=DB::table('sizes')
            ->select('sizes.size')
            ->where(['id'=>$size_id[0]->size_id])
            ->first();
            
        }
        // prx($result);

        return view('admin.orders_details', $result);
    }

    public function account(Request $request)
    {
        // $request->session()->put('ADMIN_LOGIN', true);
        // $request->session()->put('ADMIN_ID', $result->id);

        if ($request->session()->has('ADMIN_LOGIN')==null) {
            return redirect('/');
        }
            $uid=$request->session()->get('ADMIN_ID');
            $customer_info=DB::table('admins')  
                ->where(['id'=> $uid])
                 ->get(); 
            $result['user']['firstName']=$customer_info[0]->firstName;
            $result['user']['lastName']=$customer_info[0]->lastName;
            $result['user']['email']=$customer_info[0]->email;

        return view('admin.account', $result);
    }
    public function update_account(Request $request)
    {
        $user=DB::table('admins')
        ->where(['id'=>$request->session()->get('ADMIN_ID')])
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

            if (Hash::check($request->post('currentPassword'), $user[0]->password)) {
                // update Passwords
                DB::table('admins')->where(['id' => $request->session()->get('ADMIN_ID')])
                    ->update([
                        'firstName' => $request->post('firstName'),
                        'lastName' => $request->post('lastName'),
                        'email' => $request->post('email'),
                        'password' => Hash::make($request->post('newPassword')),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
        
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
            DB::table('admins')->where(['id' => $request->session()->get('ADMIN_ID')])
                ->update([
                    'firstName' => $request->post('firstName'),
                    'lastName' => $request->post('lastName'),
                    'email' => $request->post('email'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);

            $result['status'] = "success";
            $result['msg'] = "User Credentials changed!";
            return $result;
        }
    }
}
