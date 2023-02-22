<?php

namespace App\Http\Controllers;
use App\Models\Item;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $items = Item::orderBy('id','desc')->paginate(5);
        return view('items.index', compact('items'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('items.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',            
        ]);
        
        Item::create($request->post());

        return redirect()->route('items.index')->with('success','Item has been created successfully.');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
    public function show(Item $item)
    {
        return view('items.show',compact('item'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
    public function edit(Item $item)
    {
        return view('items.edit',compact('item'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\item  $item
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
        ]);
        
        $item->fill($request->post())->save();

        return redirect()->route('items.index')->with('success','Item Has Been updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success','Item has been deleted successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
    public function del(Request $request)
    {   
        $data = $request->id;
        $final = explode(", ",$data);
        Item::WhereNotIn('id',$final)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
