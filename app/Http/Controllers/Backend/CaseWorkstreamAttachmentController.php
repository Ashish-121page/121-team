<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CaseWorkstream;
use App\Models\CaseWorkstreamAttachment;
use Illuminate\Http\Request;

class CaseWorkstreamAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $work = CaseWorkstream::get();
        $caseAttach = CaseWorkstreamAttachment::whereWorkstreamId($id)->get();
        return view('panel.work-stream-attachment.index',compact('caseAttach', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $work = CaseWorkstream::get();
        $caseAttach = CaseWorkstream::whereId($id)->first();
        return view('panel.work-stream-attachment.create', compact('caseAttach', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // return $request->all();
        try {
            $this->validate($request, [
                'workstream_id' => 'required',
                'user_id' => 'required',
            ]);
            $data = new CaseWorkstreamAttachment();
            $data->workstream_id=$request->workstream_id;
            $data->user_id=$request->user_id;
            if ($request->has('path')) {
                $image = $request->file('path');
                $path = storage_path('app/public/backend/workstream-attachment');
                $imageName = 'attachment' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->path = $imageName;
            }
            $data->save();

            return redirect(route('panel.case_work_stream_attachment.index',$request->workstream_id))->with('success', 'Case Workstream Attchment created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaseWorkstreamAttachment  $caseWorkstreamAttachment
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $caseAttach = CaseWorkstreamAttachment::whereId($id)->first();
        return view('panel.work-stream-attachment.show', compact('caseAttach'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaseWorkstreamAttachment  $caseWorkstreamAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $caseAttach = CaseWorkstreamAttachment::whereId($id)->first();
        return view('panel.work-stream-attachment.edit', compact('caseAttach'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaseWorkstreamAttachment  $caseWorkstreamAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // return $request->all();
        try {
            $data = CaseWorkstreamAttachment::whereId($id)->first();
            $data->workstream_id=$request->workstream_id;
            $data->user_id=$request->user_id;
            if ($request->has('path')) {
                if ($data->path != null) {
                    unlinkfile(storage_path() . '/app/public/backend/workstream-attachment', $data->path);
                }
                $image = $request->file('path');
                $path = storage_path('app/public/backend/workstream-attachment');
                $imageName = 'attachment' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->path=$imageName;
            }
            $data->save();
            return redirect(route('panel.case_work_stream_attachment.index',$request->workstream_id))->with('success', 'Case Workstream Attachment update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CaseWorkstreamAttachment  $caseWorkstreamAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $chk = CaseWorkstreamAttachment::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Case Workstream Attachment Deleted Successfully!');
        }
    }
}
