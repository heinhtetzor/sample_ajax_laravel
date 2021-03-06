<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;

class CategoryController extends Controller
{

    // Rules
     protected $rules = 
    [
        'name' => 'required|max:192|min:2|regex:/^[a-zA-Z ]+$/u|max:255|unique:categories'
    ];
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // public function load()
    // {
    //     $categories = Category::all();
    //     return response()->json($categories);

    // }

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
    
        $validator = Validator::make(Input::all(), $this->rules);
        if($validator->fails())
        {
            return Response::json(array('errors'=> $validator->getMessageBag()->toArray()));
        }
        else 
        {
            $category = new Category();
            $category->name = $request->name;
    
            $category->save();
            return response()->json(array('category' => $category));

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
    
            $category = Category::findorfail($id);
            $this->validate($request, [
                'name' => 'required|max:190|regex:/^[a-zA-Z ]+$/u|unique:categories,name,'.$category->id
            ]);
            $category->name = $request->name;
            $category->save();
            return Response::json(array("message"=>"Successful Editing", "category"=>$category));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorfail($id);
        $category->delete();
        return Response::json(array("message"=>"Successful Deleting"));
    }

    //home
    public function home()
    {
        return view('welcome');
    }
}
