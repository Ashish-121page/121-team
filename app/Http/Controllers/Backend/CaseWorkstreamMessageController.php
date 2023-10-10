<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CaseWorkstream;
use App\Models\CaseWorkstreamMessage;
use Illuminate\Http\Request;

class CaseWorkstreamMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $work = CaseWorkstream::get();
        $caseMessage = CaseWorkstreamMessage::whereWorkstreamId($id)->get();
        return view('backend.doctor.work-stream-message.index', compact('caseMessage', 'id'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $work = CaseWorkstream::get();
        $caseMessage = CaseWorkstreamMessage::whereWorkstreamId($id)->first();
        return view('backend.doctor.work-stream-message.create',compact('caseMessage', 'id'));
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
        try {
            $this->validate($request, [
                'workstream_id' => 'required',
                'user_id' => 'required',
            ]);
            $data = new CaseWorkstreamMessage();
            $data->workstream_id=$request->workstream_id;
            $data->user_id=$request->user_id;
            $data->type=$request->type;
            $data->message=$request->message;
            $data->save();

            return redirect()->back()->with('success', 'Case Workstream Message created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaseWorkstreamMessage  $caseWorkstreamMessage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $caseMessage = CaseWorkstreamMessage::whereId($id)->first();
        return view('backend.doctor.work-stream-message.show', compact('caseMessage'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaseWorkstreamMessage  $caseWorkstreamMessage
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        //
        $caseMessage = CaseWorkstreamMessage::whereId($id)->first();
        return view('backend.doctor.work-stream-message.edit', compact('caseMessage'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaseWorkstreamMessage  $caseWorkstreamMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        // return $request->all();
        try {
            $data = CaseWorkstreamMessage::whereId($id)->first();
            $data->workstream_id=$request->workstream_id;
            $data->user_id=$request->user_id;
            $data->type=$request->type;
            $data->message=$request->message;
            $data->save();
            return redirect(route('panel.case_work_stream_message.index'))->with('success', 'Case Workstream Message update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CaseWorkstreamMessage  $caseWorkstreamMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = CaseWorkstreamMessage::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Case Workstream Message Deleted Successfully!');
        }
    }
}
