<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{


    public function index() {
        
        // Return Index View of Page

        return view('panel.currency.index');

    }



}
