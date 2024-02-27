<?php

namespace App\Http\Controllers;
use App\Models\SupportTicket;
use App\Models\Media;
use App\Models\TicketConversation;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AdminIndex(Request $request)
    {
        // return 's';
        $support_tickets = SupportTicket::query();
        if($request->has('status') && $request->get('status')){
            $support_tickets->where('status',$request->status);
        }
        $support_tickets = $support_tickets->latest()->get();   

       return view('backend.admin.support_tickets.index',compact('support_tickets'));




    }
    public function AdminShow(Request $request,$id)
    {
        $support_ticket = SupportTicket::whereId($id)->first();
        $medias = Media::whereType('SupportTicket')->whereTypeId($id)->get();
        $receiver = $support_ticket->user_id;
        $sender = auth()->id();
        
       return view('backend.admin.support_tickets.show',compact('support_ticket','receiver','medias','sender'));
    }


    public function reply(Request $request)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);

        try{
            $support_ticket = SupportTicket::whereId($request->id)->first();

        if($support_ticket){
        $support_ticket->reply = $request->reply;
            $support_ticket->status = 1;
            $support_ticket->save();
            return redirect()->route('panel.constant_management.support_ticket.index')->with('success','Replied
            Successfully!');
        }
            return back()->with('error','SupportTicket not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updateStatus(Request $request,$id,$status)
    {
        try{
            $support_ticket = SupportTicket::whereId($id)->first();

        if($support_ticket){
            
            $support_ticket->update([
                'status' => $request->status
            ]);


            $onsite_notification['user_id'] = $support_ticket->user_id;
            $onsite_notification['title'] = "Support Ticket got responded on";
            $onsite_notification['link'] = route('customer.ticket.show', $support_ticket->id);
            $onsite_notification['notification'] = "Your Support Ticket has got a response. Click here to view the response.";


            pushOnSiteNotification($onsite_notification);
            

            return back()->with('success','Status Updated Successfully!');
        }
            return back()->with('error','SupportTicket not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function supportTicket()
    {
        $supports = SupportTicket::where('user_id', auth()->id())->get();   

        return view('backend.support-ticket.index',compact('supports'));
    }

    public function Store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'message' => 'required',
        ]);
       
        try{
          $support = SupportTicket::create([
                'user_id' => auth()->id(),
                'subject' => $request->get('subject'),
                'priority' => $request->get('priority'),
                'message' => $request->get('message'),
                'status' => 0,
            ]);
            
            $filename = null;
            if($request->has('attachment')){
                $img = $this->uploadFile($request->file("attachment"), "support-ticket")->getFilePath();
                $filename = $request->file('attachment')->getClientOriginalName();
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
            }
            if($filename != null){
                    Media::create([
                        'type' => 'SupportTicket',
                        'type_id' => $support->id,
                        'file_name' => $filename,
                        'path' => $img,
                        'extension' => $extension,
                        'file_type' => "Image",
                        'tag' => "SupportTicketAttachment",
                    ]);
                }
            $ticket = TicketConversation::create([
                'type_id' => $support->id,
                'user_id' => $support->user_id,
                'type' => 'Support Ticket',
                'comment' => $support->message
             ]); 
            // return $ticket;

        return back()->with('success', "Ticket raised successfully!");
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        
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
