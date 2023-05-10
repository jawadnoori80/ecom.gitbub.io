<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Customer::all();
        return view('admin/customer',$result);
    }

    public function show(Request $request,$id)
    {
        $result['data']=Customer::find($id); 

        return view('admin/show_customer',$result);
    }
}
