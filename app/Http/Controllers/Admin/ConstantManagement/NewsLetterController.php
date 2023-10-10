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


namespace App\Http\Controllers\Admin\ConstantManagement;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\NewsLetter;
use App\Models\CampaginLog;

class NewsLetterController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/constant-management/news_letters/";
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $news_letters = fetchAll('App\Models\NewsLetter');
            return view('backend/constant-management.news_letters.index',compact('news_letters'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('backend/constant-management.news_letters.create');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                    $this->validate($request, [
                                'group_id'     => 'required',
                                'type'     => 'required',
                                'value'     => 'required',
                            ]);
        
        try{
                                                                                                
            $news_letter = NewsLetter::create($request->all());
            return redirect()->route('backend/constant-management.news_letters.index')->with('success','Record Created!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(NewsLetter $news_letter)
    {
        try{
            return view('backend/constant-management.news_letters.show',compact('news_letter'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(NewsLetter $news_letter)
    {   
        try{
            
            return view('backend/constant-management.news_letters.edit',compact('news_letter'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request,NewsLetter $news_letter)
    {
            $this->validate($request, [
                'type'     => 'required',
                'group_id'     => 'required',
                'value'     => 'required',
            ]);
                
        try{
            
            
            if($news_letter){
                                                                                                                                
                $chk = $news_letter->update($request->all());

                return redirect()->route('backend/constant-management.news_letters.index')->with('success','Record Updated!');
            }
            return back()->with('error','NewsLetter not found');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function launchcampaignShow(Request $request)
    {
        return view('backend/constant-management.news_letters.campaign');
    }
   
    public function runCampaign(Request $request)
    {
        try{
            $subject = $request->title;
            $body = $request->body;
            if($request->group_id == null){
                // Get all newsletter users
                $users = NewsLetter::whereType(1)->get();
                $emails = $users->pluck('value');

                $camp = CampaginLog::create([
                    'subject' => $subject,
                    'user_id' => auth()->id(),
                    'email' => json_encode($emails),
                    'body' => $body,
                    'status' => 0,
                ]);
            }else{
                   // Get all newsletter users of a particular group
                   $users = NewsLetter::whereType(1)->whereGroupId($request->group_id)->get();
                   $emails = $users->pluck('value');
   
                   $camp = CampaginLog::create([
                       'subject' => $subject,
                       'user_id' => auth()->id(),
                       'email' => json_encode($emails),
                       'body' => $body,
                       'status' => 0,
                   ]);
            }
                $count = 0;
                foreach($users as $user){
                    if(StaticMail($user->name, $user->value, $subject,'Lauching Campaign', $body, null, null, null, null) == "done")
                        $count++;
                }
                if($emails->count() == $count){
                    $camp->update([
                        'status' => 1
                    ]);
                }
                return redirect()->back()->with('success', 'Campaign run successfully');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
       
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(NewsLetter $news_letter)
    {
        try{

            
            if($news_letter){
                                     
                    $news_letter->delete();
                    return back()->with('success', 'Record Deleted!');
                                                         
                    $news_letter->delete();
                    return back()->with('success', 'Record Deleted!');
                                                         
                    $news_letter->delete();
                    return back()->with('success', 'Record Deleted!');
                                                }
            return back()->with('error','NewsLetter not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
