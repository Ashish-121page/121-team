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
use App\Models\Ticket;
use App\Models\MailSmsTemplate;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        $length = 10;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $ticket = Ticket::query();
          // return $request->all();
        if($request->get('from') && $request->get('to') ){
            // return explode(' - ', $request->get('date')) ;
            $ticket->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
        }
        if($request->get('type')){
            $ticket->where('ticket_type_id','=',$request->type);
        }
        $ticket= $ticket->paginate($length);
        if ($request->ajax()) {
            return view('backend.admin.manage.ticket.load', ['ticket' => $ticket])->render();  
        }
        return view('backend.admin.manage.ticket.index', compact('ticket'));
    }

    public function print(Request $request){
        //    return json_decode($request->leads);
                $tickets = collect($request->records['data']);
                return view('backend.admin.manage.ticket.print', ['tickets' => $tickets])->render();  
           
       }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.admin.manage.ticket.create');
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
     try{
            $this->validate($request, [
                'client_name' => 'required',
                'client_email' => 'required',
                'title' => 'required',
                'user_id' => 'required',
                'ticket_type_id' => 'required',
            ]);
            $data = new Ticket();
            $data->client_name=$request->client_name;
            $data->client_email=$request->client_email;
            $data->description=$request->description;
            $data->title=$request->title;
            $data->user_id=auth()->id();
            $data->ticket_type_id=$request->ticket_type_id;
            $data->assigned_to=$request->assigned_to;
            $data->last_activity=$request->last_activity;
            $data->is_closed=0;
            $data->save();
            // Push On Site Notification
            $data_notification = [
                'title' => "New Ticket raise of ".$data->title,
                'notification' => "You have a new Ticket",
                'link' => "#",
                'user_id' => $data->user_id,
            ];
            pushOnSiteNotification($data_notification);
            // End Push On Site Notification

            // Start Dynamic mail send
            $mail = MailSmsTemplate::whereCode('ClientTicketRise')->first();
            $arr=[
                '{name}' => $data->client_name=$request->client_name,
                '{email}' => $data->client_email=$request->client_email,
                '{message}' => $data->description=$request->description,
                '{subject}' => $data->title=$request->title,
                '{app_name}'=>config('app.name'),
            ];
                try{
                    // mail send to Client 
                    TemplateMail($data->client_name=$request->client_name, $mail->code, $data->client_email=$request->client_email, $mail->type, $arr, $mail, null, $action_button = null);
                    // mail send to Admin 
                    TemplateMail(auth()->user()->name, $mail->code, auth()->user()->email, $mail->type, $arr, $mail, null, $action_button = null);
                    // End Dynamic mail send

                }catch(Exception $e){
                    
                }

            return redirect(route('panel.admin.ticket.index'))->with('success', 'Ticket created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $ticket = Ticket::whereId($id)->first();
        
        return view('backend.admin.manage.ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $ticket = Ticket::whereId($id)->first();
        return view('backend.admin.manage.ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // return $request->all();
        try {
            $data = Ticket::whereId($id)->first();
            $data->client_name=$request->client_name;
            $data->client_email=$request->client_email;
            $data->description=$request->description;
            $data->title=$request->title;
            $data->user_id=$request->user_id;
            $data->ticket_type_id=$request->ticket_type_id;
            $data->assigned_to=$request->assigned_to;
            $data->last_activity=$request->last_activity;
            $data->save();
            return redirect(route('panel.admin.ticket.index'))->with('success', 'Ticket update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function updateStatus($id, $s)
    {
        try {
            $user   = Ticket::find($id);
            $user->update(['is_closed' => $s]);
            return redirect()->back()->with('success', 'Ticket status Updated!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = Ticket::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Ticket Deleted Successfully!');
        }
    }
}
