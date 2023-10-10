<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CaseWorkstream;
use App\User;
use App\Models\CaseWorkstreamParticipant;
use App\Models\MailSmsTemplate;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\Request;

class CaseWorkstreamParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        // try {
            if($id == null){
                $work = CaseWorkstream::get();
                // $workStreamPart = [];
            }else{
                $work = CaseWorkstream::get();
                $workStreamPart = CaseWorkstreamParticipant::whereWorkstreamId($id)->get();
            }
        return view('panel.work-stream-participant.index', compact('workStreamPart' , 'work', 'id'));
        // } catch (\Exception $e) {
        //     return back()->with('error', 'Error: ' . $e->getMessage());
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $workStreamPart = CaseWorkstream::whereId($id)->first();
        return view('panel.work-stream-participant.create', compact('workStreamPart', 'id'));
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
        $user = User::whereId($request->user_id)->first();
        // return NameById($request->user_id);
        try {
            $this->validate($request, [
                'workstream_id' => 'required',
                'user_id' => 'required',
            ]);
            $data = new CaseWorkstreamParticipant();
            $data->workstream_id=$request->workstream_id;
            $data->user_id=$request->user_id;
            $data->is_chat_visible=$request->is_chat_visible;
            $data->status=1;
            $data->save();
            $event = new Event;
            $event->name = 'Tumor Board Meeting';
            $event->startDateTime = Carbon::parse($request->date.' '.$request->time);
            $event->endDateTime = Carbon::parse($request->date.' '.$request->end_time);
            $event->save();

            return redirect(route('panel.case_work_stream_participant.index',$request->workstream_id))->with('success', 'Case Workstream Participant created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaseWorkstreamParticipant  $caseWorkstreamParticipant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $workStreamPart = CaseWorkstreamParticipant::whereId($id)->first();
        return view('panel.work-stream-participant.show', compact('workStreamPart'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaseWorkstreamParticipant  $caseWorkstreamParticipant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $workStreamPart = CaseWorkstreamParticipant::whereId($id)->first();
        return view('panel.work-stream-participant.edit', compact('workStreamPart'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaseWorkstreamParticipant  $caseWorkstreamParticipant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // return $request->all();
        try {
            $data = CaseWorkstreamParticipant::whereId($id)->first();
            $data->workstream_id=$request->workstream_id;
            $data->user_id=$request->user_id;
            $data->is_chat_visible=$request->is_chat_visible;
            $data->status=$request->status;
            $data->save();
            return redirect(route('panel.case_work_stream_participant.index', $request->workstream_id))->with('success', 'Case Workstream Participant update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CaseWorkstreamParticipant  $caseWorkstreamParticipant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = CaseWorkstreamParticipant::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Case Workstream Participant Deleted Successfully!');
        }
    }
}
