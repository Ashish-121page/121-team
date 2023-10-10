<?php

namespace App\Http\Controllers\Admin\ConstantManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailSmsTemplate;

class MailSmsTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = 50;
         if(request()->get('length')){
            $length = $request->get('length');
         }
         $mail_sms = MailSmsTemplate::query();
         if($request->get('search')){
            $mail_sms->where('code','like','%'.$request->search.'%')
                ->orWhere('title','like','%'.$request->search.'%');
        }
        $mail_sms = $mail_sms->paginate($length );
        if ($request->ajax()) {
            return view('backend.constant-management.mail-sms-template.load', ['mail_sms' => $mail_sms])->render();  
        }
        return view('backend.constant-management.mail-sms-template.index', compact('mail_sms','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.constant-management.mail-sms-template.create');
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
        $this->validate($request, [
            'code' => 'required',
            'title' => 'required',
            'type' => 'required',
            'body' => 'required',
            'variables' => 'required'
        ]);
        $data = new MailSmsTemplate();
        $data->code=$request->code;
        $data->title=$request->title;
        $data->type=$request->type;
        if($request->type == 1){
            $data->body=$request->mail_body;
        }else{
            $data->body=$request->body;
        }
        $data->variables=$request->variables;
        $data->footer=$request->footer;
        $data->save();
        return redirect(route('panel.constant_management.mail_sms_template.index'))->with('success', 'Mail Sms Template created successfully.');
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
        $mail_sms = MailSmsTemplate::whereId($id)->first();
        return view('backend.constant-management.mail-sms-template.show', compact('mail_sms'));
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
        $mail_sms = MailSmsTemplate::whereId($id)->first();
        return view('backend.constant-management.mail-sms-template.edit', compact('mail_sms'));
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
        // return $request->all();
        $data = MailSmsTemplate::whereId($id)->first();
        $data->code=$request->code;
        $data->title=$request->title;
        // $data->type=$request->type;
        // $data->whatapp=$request->whatapp;
        if($data->type == 1){
            $data->body=$request->mail_body;
        }else{
            $data->body=$request->body;
        }
        $data->variables=$request->variables;
        $data->footer=$request->footer;
        $data->save();
        return redirect(route('panel.constant_management.mail_sms_template.index'))->with('success', 'Mail Sms Template update successfully.');
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
        $chk = MailSmsTemplate::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Mail Sms Template Deleted Successfully!');
        }
    }
}
