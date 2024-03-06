<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(){
        $customers=Customer::all();
        return view('customers.index',['customers'=>$customers]);
    }

    public function create(){
        return view('customers.create');
    }

    public function store(Request $request){
        $data=$request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'address'=>'required',
            'phone'=>'required'
        ]);

        $newCustomer=Customer::create($data);

        return redirect(route('customer.index'));
    }
}
