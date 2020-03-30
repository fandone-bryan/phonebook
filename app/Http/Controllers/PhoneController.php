<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Phone;

class PhoneController extends Controller
{
    public function index($customerId)
    {
        $phones = Phone::where('customer_id', '=',$customerId)->get();
        
        return response()->json($phones);
    }

    public function store(Request $request)
    {
        $phone = new Phone;

        $phone->number = $request->number;
        $phone->customer_id = $request->customer_id;

        $phone->save();

        return response()->json(["msg" => "ok"]);
    }

    public function update(Request $request, $id)
    {
        $phone = Phone::find($id);

        $phone->number = $request->number;

        $phone->save();

        return response()->json(["msg" =>"ok"]);
    }

    public function destroy($id)
    {
        $phone = Phone::find($id);

        $phone->delete();

        return response()->json(["msg" =>"ok"]);
    }
}
