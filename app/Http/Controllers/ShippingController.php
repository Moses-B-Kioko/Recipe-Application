<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;
use App\Models\ShippingCharge;
use Illuminate\Support\Facades\Validator;


class ShippingController extends Controller
{
    public function create() {
        $counties = County::get();
        $data['counties'] = $counties;

        $shippingCharges = ShippingCharge::select('shipping_charges.*','county.name')
                           ->leftJoin('county', 'county.id','shipping_charges.county_id')->get(); 
        //dd($shippingCharges);

        $data['shippingCharges'] = $shippingCharges;
        return view('front.shipping.create', $data);
    }

    public function store(Request $request) {

        $count= ShippingCharge::where('county_id',$request->county)->count();
        
       $validator = Validator::make($request->all(),[
            'county' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->passes()) {

            if ($count > 0) {
                session()->flash('error','Shipping already added');

                return response()->json([
                    'status' => true,
                ]);
            }
    

            $shipping = new ShippingCharge();
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

    public function edit($id) {
        $shippingCharge = ShippingCharge::find($id);  // Change this to lowercase
        $counties = County::get();
        $data['counties'] = $counties;
        $data['shippingCharge'] = $shippingCharge;
    
        return view('front.shipping.edit', $data);
    }

    public function update($id,Request $request) {
        $shipping = ShippingCharge::find($id);

        $validator = Validator::make($request->all(),[
             'county' => 'required',
             'amount' => 'required|numeric'
         ]);
 
         if ($validator->passes()) {

            if($shipping == null) {  // Change to lowercase
                session()->flash('error', 'Shipping not found');
                return response()->json([
                    'status' => true,
                ]);
            }
 
             $shipping->county_id = $request->county;
             $shipping->amount = $request->amount;
             $shipping->save();
 
             session()->flash('success','Shipping updated successfully');
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

     
    
    public function destroy($id) {
        $shippingCharge = ShippingCharge::find($id);  // Change this to lowercase
    
        if($shippingCharge == null) {  // Change to lowercase
            session()->flash('error', 'Shipping not found');
            return response()->json([
                'status' => true,
            ]);
        }
    
        $shippingCharge->delete();  // Change to lowercase
    
        session()->flash('success', 'Shipping deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
    
}
