<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;
use Illuminate\Support\Facades\Input;
use Response;
use Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('Category')->get();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "name"=> "required|max:199|min:2|regex:/^[a-zA-Z ]+$/u|unique:items",
            "category_id"=> "required|numeric",
            "price"=> "required|numeric|min:200",
            "quantity"=> "required|numeric",
        ]);

        if($validator->fails())
        {
            return Response::json(array('errors'=> $validator->getMessageBag()->toArray()));
        }
        else
        {
        $item = new Item();
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->price = $request->price;
        $item->quantity = $request->quantity;

        $item->save();
        
        $returnItem = $item->where('id', $item->id)->with('category')->get();
        
        return Response::json(array('item'=>$returnItem));
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
        $item = Item::findorfail($id);
        // echo $item; die();
        $validator = Validator::make(Input::all(), [
            "name"=> "required|max:199|min:2|regex:/^[a-zA-Z ]+$/u|unique:items,name,".$item->id,
            "category_id"=> "required|numeric",
            "price"=> "required|numeric|min:200",
            "quantity"=> "numeric",
        ]);

        if($validator->fails())
        {
            return Response::json(array('errors'=> $validator->getMessageBag()->toArray()));
        }
        else
        {
        
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->price = $request->price;
        $item->quantity = '0';

        $item->save();
        
        $returnItem = $item->where('id', $item->id)->with('category')->get();
        
        return Response::json(array('item'=>$returnItem));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findorfail($id);
        $item->delete();

        return Response::json(array("message"=>"successfully deleted"));
    }

    //get all categories
    public function getCategories()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return Response::json(array('categories'=>$categories));
    }
}
