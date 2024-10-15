<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;
use App\Models\Shipping;
use Illuminate\Support\Facades\Validator;


class ShippingController extends Controller
{
    public function create() {
        $counties = County::get();
        $data['counties'] = $counties;
        return view('front.shipping.create', $data);
    }

    public function store(Request $request) {
       $validator = Validator::make($request->all(),[
            'county' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->passes()) {

            $shipping = new Shipping;
            $shipping->county_id = $request->county;
            $shipping->amount = $request->amount;
            $shipping->save();

            session()->flash('success','Shipping added successfully');
            return response()->json([
                'status' => true,
            ]);
            

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
