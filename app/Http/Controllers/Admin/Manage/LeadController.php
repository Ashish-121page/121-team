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

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\UserNote;
use  App\Models\MailSmsTemplate;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request->all();
        $length = 10;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $lead = Lead::query();
    
            //    return $request->all();
          if($request->get('from') && $request->get('to')) {
            //  return explode(' - ', $request->get('date')) ;
              $lead->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
             }
          if($request->get('lead_type_id')){
              $lead->where('lead_type_id','=',$request->lead_type_id);
          }
          if($request->get('search')){
              $lead->where('name','like','%'.$request->search.'%');
          }
            $lead= $lead->paginate($length);
            if ($request->ajax()) {
                return view('backend.admin.manage.lead.load', ['lead' => $lead])->render();  
            }

            return view('backend.admin.manage.lead.index', compact('lead'));
   }

   
   public function print(Request $request){
    //    return json_decode($request->leads);
            $leads = collect($request->records['data']);
            return view('backend.admin.manage.lead.print', ['lead' => $leads])->render();  
       
   }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.admin.manage.lead.create');
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
        // return $request->all();
    //   return  \Auth::user->id;
        try {
            $this->validate($request, [
                'user_id' => 'required',
                'name' => 'required',
                'lead_type_id' => 'required',
                'lead_source_id' => 'required',
                'owner_email' => 'required',
            ]);
            $data = new Lead();
            $data->user_id=$request->user_id;
            $data->name=$request->name;
            $data->lead_type_id=$request->lead_type_id;
            $data->lead_source_id=$request->lead_source_id;
            $data->owner_email=$request->owner_email;
            $data->phone=$request->phone;
            $data->address=$request->address;
            $data->city=$request->city;
            $data->state=$request->state;
            $data->country=$request->country;
            $data->zip=$request->zip;
            $data->phone=$request->phone;
            $data->website=$request->website;
            $data->save();
            // Push On Site Notification
            $data_notification = [
                'title' => "New Lead of ".$data->name,
                'notification' => "You have a new Lead",
                'link' => "#",
                'user_id' => auth()->id(),
            ];
            pushOnSiteNotification($data_notification);
            $mailcontent_data = MailSmsTemplate::where('code','=',"new-lead")->first();
            if($mailcontent_data){
                $arr=[
                    '{name}'=>$data->name,
                    '{id}'=> $data->id,
                    '{type}'=>fetchFirst('App\Models\Category',$data->lead_type_id,'name',''),
                    '{source}'=>fetchFirst('App\Models\Category',$data->lead_source_id,'name',''),
                    '{email}'=>$data->owner_email,
                    '{phone}'=>$data->phone,
                    '{city}'=>$data->city,
                    '{state}'=>$data->state,
                    '{country}'=>$data->country,
                    '{app_name}'=>config('app.name'),
                ];
                customMail("Admin",getSetting('admin_email'),$mailcontent_data,$arr,null ,null ,null ,null,null ,null);
            }
            // End Push On Site Notification
            return redirect(route('panel.admin.lead.index'))->with('success', 'Lead created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $lead = Lead::whereId($id)->first();
        $user_note = UserNote::whereTypeId($id)->get();
        return view('backend.admin.manage.lead.show', compact('lead', 'user_note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $lead = Lead::whereId($id)->first();
        return view('backend.admin.manage.lead.edit', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $data = Lead::whereId($id)->first();
            $data->user_id=$request->user_id;
            $data->name=$request->name;
            $data->lead_type_id=$request->lead_type_id;
            $data->lead_source_id=$request->lead_source_id;
            $data->owner_email=$request->owner_email;
            $data->phone=$request->phone;
            $data->address=$request->address;
            $data->city=$request->city;
            $data->state=$request->state;
            $data->country=$request->country;
            $data->zip=$request->zip;
            $data->phone=$request->phone;
            $data->website=$request->website;
            $data->save();
            return redirect(route('panel.admin.lead.index'))->with('success', 'Lead update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = Lead::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Lead Deleted Successfully!');
        }
    }
}
