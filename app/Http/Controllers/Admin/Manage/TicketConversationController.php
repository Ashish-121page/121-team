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
use App\Models\TicketConversation;
use App\Models\Ticket;
use App\Models\SupportTicket;
use App\Models\MailSmsTemplate;
use Illuminate\Http\Request;

class TicketConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ticket_conver = TicketConversation::all();
        return view('backend.admin.manage.ticket-conversation.index', compact('ticket_conver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.admin.manage.ticket-conversation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'type_id' => 'required',
        ]);
        try {
        $data = new TicketConversation();
        $data->type_id=$request->type_id;
        $data->type = $request->type;
        $data->enquiry_id = $request->enquiry_id ?? 0;
        $data->user_id=auth()->id();
        $data->comment=$request->comment;
        $data->save();
    
        SupportTicket::whereId($request->type_id)->update([
            'status' => 1
        ]);
        
        // Start Dynamic mail send
        $mail = MailSmsTemplate::whereCode('ClientReply')->first();
        if($mail){
            $arr=[
                '{type_id}' => $data->type_id=$request->type_id,
                '{comment}' => $data->comment=$request->comment,
                '{app_name}'=>config('app.name'),
            ];
            // mail send to Client 
            // TemplateMail(auth()->user()->name, $mail->code, auth()->user()->email, $mail->type, $arr, $mail, null, $action_button = null);
        }
        
        return back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketConversation  $ticketConversation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket_conver = TicketConversation::whereId($id)->firstOrFail();
        return view('backend.admin.manage.ticket-conversation.show', compact('ticket_conver'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TicketConversation  $ticketConversation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket_conver = TicketConversation::whereId($id)->first();
        return view('backend.admin.manage.ticket-conversation.edit', compact('ticket_conver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TicketConversation  $ticketConversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $data = TicketConversation::whereId($id)->first();
            $data->ticket_id=$request->ticket_id;
            $data->user_id=$request->user_id;
            $data->comment=$request->comment;
            $data->save();
            return redirect(route('panel.admin.ticket_conversation.index'))->with('success', 'Ticket Conversation update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketConversation  $ticketConversation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = TicketConversation::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Ticket Conversation Deleted Successfully!');
        }
    }
}
