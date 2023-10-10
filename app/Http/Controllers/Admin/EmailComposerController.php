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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailComposer;
use App\Models\EmailLog;
use App\User;
use Illuminate\Http\Request;

class EmailComposerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         try {
            return view('backend.admin.email-composer.index');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

     public function send(Request $request)
    {
        // return $request->all();
    //    return explode(',',$request->email);
        $request->validate([
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        try  {
            foreach(explode(',',$request->email) as $email){
                $mail_footer = null;
                manualEmail(null, $email, $request->get('subject'), $request->get('body'), $mail_footer, null, $request->get('cc'), $request->get('bcc'));
    
                // EmailLog Capture
                EmailLog::create([
                    'subject' => $request->get('subject'),
                    'message' => $request->get('message'),
                    'attach' => json_encode($request->get('attach')),
                    'email' => $email,
                    'user_id' => auth()->id(),
                    'sent_by' => auth()->id(),
                    'type' => 'manual',
                    'datetime' => now(),
                ]);
            }

            return back()->with('success', 'Mail sent successfully!');

        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function msgPrepare(Request $request)
    {
         $request->all();
         $user_emails = $request->user_emails;
        $html ='';
        foreach($user_emails as $useremail){
            $user = User::where('email',$useremail)->first();
            $html .='<p>Name: '.ucwords($user->name).', <br>  URL: '.route("guest.view",$user->unique_id).'</p>';
        }
        return response($html,200);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailComposer  $emailComposer
     * @return \Illuminate\Http\Response
     */
    public function show(EmailComposer $emailComposer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailComposer  $emailComposer
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailComposer $emailComposer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailComposer  $emailComposer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailComposer $emailComposer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailComposer  $emailComposer
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailComposer $emailComposer)
    {
        //
    }
}
