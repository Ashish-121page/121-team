<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
          // Share button 1
               $shareButtons1 = \Share::page(
                     'https://makitweb.com/datatables-ajax-pagination-with-search-and-sort-in-laravel-8/'
               )
               ->facebook()
               ->twitter()
               ->linkedin()
               ->telegram()
               ->whatsapp() 
               ->reddit();

               // Share button 2
               $shareButtons2 = \Share::page(
                     'https://makitweb.com/how-to-make-autocomplete-search-using-jquery-ui-in-laravel-8/'
               )
               ->facebook()
               ->twitter()
               ->linkedin()
               ->telegram();

               // Share button 3
               $shareButtons3 = \Share::page(
                      'https://makitweb.com/how-to-upload-multiple-files-with-vue-js-and-php/'
               )
               ->facebook()
               ->twitter()
               ->linkedin()
               ->telegram()
               ->whatsapp() 
               ->reddit();

               // Load index view
               return view('pages.index',$slug)
                     ->with('shareButtons1',$shareButtons1 )
                     ->with('shareButtons2',$shareButtons2 )
                     ->with('shareButtons3',$shareButtons3 );
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
        //
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
