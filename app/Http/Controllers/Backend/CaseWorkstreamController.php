<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Presentation;
use App\Models\CaseWorkstream;
use App\Models\CaseWorkstreamMessage;
use App\Models\Appointment;
use App\Models\CaseWorkstreamParticipant;
use Illuminate\Http\Request;

class CaseWorkstreamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        //
        try {
            // if($id == null){
                $workStream = CaseWorkstream::get();
            // }
            // else{
            //     $case = Presentation::get();
            //     $workStream = CaseWorkstream::whereCaseId($id)->get();
            // }
            return view('panel.work-stream.index', compact('workStream', 'id'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function manageCancerBoard()
    {
        //
        try {
            $participant = CaseWorkstreamParticipant::whereUserId(\Auth::id())->pluck('workstream_id');
            $workStream = CaseWorkstream::whereIn('id', $participant)->get();
            return view('panel.manage-cancer-board', compact('workStream'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        return view('panel.work-stream.create');
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
        // try {
            $this->validate($request, [
                'author_id' => 'required',
                'case_id' => 'required',
            ]);
            $data = new CaseWorkstream();
            $data->name=$request->name;
            $data->description=$request->description;
            $data->author_id=$request->author_id;
            $data->case_id=$request->case_id;
            $data->status=0;
            $data->save();

            return redirect(route('panel.case_work_stream.index',$request->case_id))->with('success', 'Case Workstream created successfully.');
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Error: ' . $e->getMessage());
        // }
    }
    public function voiceCall(Request $request)
    {
        //
        // return $request->all();
        try {
            $url = 'https://meet.jit.si/';
            $voice = $url.generateRandomStringNative(12); // Chose length randomly in 7 to 12
            $message = new CaseWorkstreamMessage();
            $message->workstream_id= $request->workstream_id;
            $message->type= 'voice';
            $message->user_id= auth()->id();
            $message->message= auth()->user()->name.' invited to join the voice call, please use the following link to initiate the call '.$voice;
            $message->save();

            return redirect()->back()->with('success', 'Calling messgae send successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function videoCall(Request $request)
    {
        //
        // return $request->all();
        try {
            $url = 'https://meet.jit.si/';
            $voice = $url.generateRandomStringNative(12); // Chose length randomly in 7 to 12
            $message = new CaseWorkstreamMessage();
            $message->workstream_id= $request->workstream_id;
            $message->type= 'video';
            $message->user_id= auth()->id();
            $message->message= auth()->user()->name.' invited to join the video call, please use the following link to initiate the call '.$voice;
            $message->save();
            return redirect()->back()->with('success', 'Calling messgae send successfully.');            
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaseWorkstream  $caseWorkstream
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        $message = CaseWorkstreamMessage::whereWorkstreamId($id)->get();
        $otherMessage = CaseWorkstreamMessage::whereWorkstreamId($id)->get();


        $workStream = CaseWorkstream::whereId($id)->first();
        return view('panel.work-stream.show', compact('workStream', 'message', 'otherMessage', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaseWorkstream  $caseWorkstream
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        //
        $workStream = CaseWorkstream::whereId($id)->first();
        return view('panel.work-stream.edit', compact('workStream'));
    }
    public function markCompleted( $id)
    {
        // return $id;
        $workStream = CaseWorkstream::whereId($id)->first();
        $appointment = Appointment::whereId($workStream->case_id)->first();
        if($appointment){
            $appointment->update(['status' => 2]);
        }
        return back()->with('success', 'Case Workstream Completed!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaseWorkstream  $caseWorkstream
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // return $request->all();
        try {
            $data = CaseWorkstream::whereId($id)->first();
            $data->name=$request->name;
            $data->description=$request->description;
            $data->author_id=$request->author_id;
            $data->case_id=$request->case_id;
            $data->status=$request->status;
            $data->save();
            return redirect(route('panel.case_work_stream.index',$request->case_id))->with('success', 'Case Workstream update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CaseWorkstream  $caseWorkstream
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $chk = CaseWorkstream::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Case Workstream Deleted Successfully!');
        }
    }
}
