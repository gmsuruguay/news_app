<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Favorite::where('id_user', Auth::id())->where('is_deleted','<>',Favorite::IS_DELETED)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $favorite = new Favorite();
        $favorite->id_new = $request->id;
        $favorite->title = $request->title;
        $favorite->url = $request->url;
        $favorite->is_deleted = 0;
        $favorite->id_user = Auth::id();
        $favorite->save();
        return response($favorite,201);

    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new = Favorite::find($id);
        $new->is_deleted = 1;
        $new->update();
       
    }
}
