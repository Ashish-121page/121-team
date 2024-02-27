<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        return view('panel.search.index');
    }

    public function result(Request $request)
    {

        // magicstring(request()->all());
        // return;

        $user = auth()->user();
        if ($request->hasFile('searchimg')) {
            $file= $request->file('searchimg');
            $folderPath = "public/images/search/".$user->id;
            // $filename = \Str::random(10) . '.' . str_replace(' ',"_",$file->getClientOriginalName());
            $filename = str_replace(' ',"_",$file->getClientOriginalName());
            $path = $file->storeAs($folderPath, $filename);
            $path = str_replace("public","storage",$path);
            $search = "ai-search";
        }else{
            $path = "";
            $search = "ai-search";
        }


        $AssetVaultname = $request->input('AssetVaultname') ?? [];
        $productcatname = $request->input('productcatname') ?? [];



        return view('panel.search.index',compact('search','path','AssetVaultname','productcatname'));

    }


    public function result1(Request $request)
    {



        $user = auth()->user();
        if ($request->hasFile('searchimg')) {
            $file= $request->file('searchimg');
            $folderPath = "public/images/search/".$user->id;
            // $filename = \Str::random(10) . '.' . str_replace(' ',"_",$file->getClientOriginalName());
            $filename = str_replace(' ',"_",$file->getClientOriginalName());
            $path = $file->storeAs($folderPath, $filename);
            $path = str_replace("public","storage",$path);
            $search = "ai-search";
        }else{
            $path = "";
            $search = "ai-search";
        }


        $AssetVaultname = $request->input('AssetVaultname') ?? [];
        $productcatname = $request->input('productcatname') ?? [];

        return view('panel.search.pages.result1',compact('search','path','AssetVaultname','productcatname'));
     
    }
}
