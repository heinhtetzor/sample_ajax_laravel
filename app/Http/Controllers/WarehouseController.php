<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use Response;
use Validator;
use Illuminate\Support\Facades\Input;
use Alert;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            "name"=> "required|max:199|min:2|unique:warehouses",
            "address1"=>"required|min:3",
            "address2"=>"required|min:3",
            "long"=>"required|numeric",
            "lat"=>"required|numeric"
        ]);
        if($validator->fails())
        {
            // return Response::json(array("errors"=>$validator->getMessageBag()->toArray()));
            $errors = $validator->getMessageBag();
            // echo $errors; 
            alert()->error('Error', 'Check your input');
            return redirect('/warehouses/create');
        }
        else
        {
            $warehouse = new Warehouse();
            $warehouse->name = $request->name;
            $warehouse->address1 = $request->address1;
            $warehouse->address2 = $request->address2;
            $warehouse->long = $request->long;
            $warehouse->lat = $request->lat;

            $warehouse->save();
            alert()->success('Success', 'Compelte Adding new Warehouse');
            return redirect('/warehouses/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
