<?php 
/**
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Http\Controllers\Admin\ConstantManagement;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function country(Request $request)
    {
        $length = 10;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $country = Country::query();
        //   return $request->all();
            if($request->get('from') && $request->get('to') ){
        //  return explode(' - ', $request->get('date')) ;
            $country->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }
            if($request->get('search')){
                $country->where('name','like','%'.$request->get('search').'%');
            }
            $country= $country->paginate($length);
            if ($request->ajax()) {
                return view('backend.constant-management.location.loads.country', ['country' => $country])->render();  
            }
        return view('backend.constant-management.location.country', compact('country'));
    }
    public function state(Request $request)
    {
        $length = 50;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $state = State::query();
        if($request->get('search')){
            $state->where('name','like','%'.$request->get('search').'%');
        }
        //   return $request->all();
            if($request->get('country')){
            //  return explode(' - ', $request->get('date')) ;
            $state->whereCountryId($request->get('country'));
            }
            $state= $state->paginate($length);
            if ($request->ajax()) {
                return view('backend.constant-management.location.loads.state', ['state' => $state])->render();  
            }
        return view('backend.constant-management.location.state', compact('state'));
    }
    public function city(Request $request)
    {
        $length = 10;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $city = City::query();
            if($request->get('state')){
            $city->whereStateId($request->get('state'));
            }
            $city= $city->paginate($length);
            if ($request->ajax()) {
                return view('backend.constant-management.location.loads.city', ['city' => $city])->render();  
            }
        return view('backend.constant-management.location.city', compact('city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.constant-management.location.create');
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
        try {
            $this->validate($request, [
                'name' => 'required',
                'iso2' => 'required|min:2',
            ]);
            // return $request->all();
            $data = new Country();
            $data->name=$request->name;
            $data->phonecode=$request->phonecode;
            $data->region=$request->region;
            $data->currency=$request->currency;
            $data->iso2=$request->iso2;
            $data->capital=$request->capital;
            $data->emoji=$request->emoji;
            $data->save();
            return redirect(route('panel.constant_management.location.country'))->with('success', 'Country created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function stateStore(Request $request)
    {
        //
        // return $request->all();
        try {
            $this->validate($request, [
                'name' => 'required',
            ]);

            $country = Country::whereId($request->country_id)->first();
            if($country){
                $data = new State();
                $data->name=$request->name;
                $data->country_id=$request->country_id;
                $data->country_code=$country->iso2;
                $data->iso2=$request->iso2;
                $data->fips_code=$request->fips_code;
                $data->save();
                return redirect(route('panel.constant_management.location.state')."?country=".$request->country_id)->with('success', 'State created successfully.');
            }else{
                return back()->with('error', 'Oops! Something went wrong');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function stateUpdate(Request $request)
    {
        //
        // return $request->all();
        try {
            $this->validate($request, [
                'name' => 'required',
            ]);

            $state = State::whereId($request->id)->first();
            if($state){
                $state->name=$request->name;
                $state->iso2=$request->iso2;
                $state->fips_code=$request->fips_code;
                $state->save();
                return redirect(route('panel.constant_management.location.state')."?country=".$state->country_id)->with('success', 'State updated successfully.');
            }else{
                return back()->with('error', 'Oops! State not found!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function cityStore(Request $request)
    {
        //
        // return $request->all();
        try {
            $this->validate($request, [
                'name' => 'required',
                'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            ]);

            $country = Country::whereId($request->country_id)->first();
            if($country){
                $data = new City();
                $data->name=$request->name;
                $data->country_id=$request->country_id;
                $data->country_code=$country->iso2;
                $data->state_id=$request->state_id;
                $data->state_code=$request->state_code;
                $data->latitude=$request->latitude;
                $data->longitude=$request->longitude;
                $data->save();
                return redirect(route('panel.constant_management.location.city')."?state=".$request->state_id)->with('success', 'City created successfully.');
            }else{
                return back()->with('error', 'Oops! Something went wrong');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function cityUpdate(Request $request)
    {
        //
        // return $request->all();
        // try {
            $this->validate($request, [
                'name' => 'required',
                'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            ]);

            $city = City::whereId($request->id)->first();
            if($city){
                $city->name=$request->name;
                $city->latitude=$request->latitude;
                $city->longitude=$request->longitude;
                $city->save();
                return redirect(route('panel.constant_management.location.city')."?state=".$city->state_id)->with('success', 'City updated successfully.');
            }else{
                return back()->with('error', 'Oops! City not found!');
            }
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Error: ' . $e->getMessage());
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        $article = Article::whereId($id)->first();
        return view('backend.constant-management.article.show', compact('article'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $country = Country::whereId($id)->first();
        return view('backend.constant-management.location.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $data = Country::whereId($id)->first();
            $data->name=$request->name;
            $data->phonecode=$request->phonecode;
            $data->region=$request->region;
            $data->currency=$request->currency;
            $data->iso2=$request->iso2;
            $data->capital=$request->capital;
            $data->emoji=$request->emoji;
            $data->save();
            return redirect(route('panel.constant_management.location.country'))->with('success', 'Country  updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = Article::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Article Deleted Successfully!');
        }
    }
}
