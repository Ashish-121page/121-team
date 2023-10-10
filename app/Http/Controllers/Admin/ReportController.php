<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\AccessCode;
use App\Models\UserPackage;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accessCode()
    {
        return view('backend.admin.report.access-code');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userPackages(Request $request)
    {
        $length = 50;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $user_packages = UserPackage::groupBy('user_id')->paginate($length);
        if ($request->ajax()) {
            return view('backend.admin.report.partials.user_package', ['user_packages' => $user_packages])->render();  
        }
        return view('backend.admin.report.user-packages',compact('user_packages'));
    }
    public function userAcquisition(Request $request)
    {
        $length = 50;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $year = date('Y');
        if($request->get('from') != null && $request->get('to') == null){
        return back()->with('error', 'Please select both Date fields');
        }
        if($request->get('to') != null && $request->get('from') == null){
        return back()->with('error', 'Please select both Date fields');
        }
        
        $users =  User::query();

        if($request->get('from') && $request->get('to')){
            $users->whereBetween('created_at',[\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
        }else{
           $users = User::whereMonth('created_at', '>=', date('m'));
        }

        $users =  $users->role('User')->paginate($length);
        if ($request->ajax()) {
            return view('backend.admin.report.partials.user_acquisition', ['users' => $users])->render();  
        }
        return view('backend.admin.report.user-acquisition',compact('users','year'));
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
