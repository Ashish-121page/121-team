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

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserEnquiry;
use App\Models\Article;
use App\Models\AccessCode;
use App\Models\Brand;
use App\Models\NewsLetter;
use App\Models\WebsitePage;
use App\Models\SupportTicket;

class HomeController extends Controller
{


    public function index($slug = null)
    {
        return view('frontend.home.index');
    }

    public function page($slug = null)
    {
        if($slug != null){
            $page = WebsitePage::where('slug', '=', $slug)->whereStatus(1)->first();
            if(!$page){
                abort(404);
            }
        }else{
            $page = null;
        }

        return view('frontend.micro-site.privacy.index',compact('page'));
    }


    public function dashboard()
    {
        $brand_assign = Brand::whereUserId(auth()->id())->first();
        $access_code = AccessCode::whereRedeemedUserId(auth()->id())->first();
        
        if(getSetting('sms_verify') && auth()->user()->isverified){
            return redirect()->route('sms.verify')->with(['phone' => auth()->user()->phone]);
        // }elseif(getSetting('email_verify') && auth()->user()->email_verified_at == null){
        //     return redirect()->route('verification.notice');
        }
        if(AuthRole() == 'User'){
            if(!$access_code){
              return redirect(route('customer.dashboard'))->with('error','You don\'t have permission to access seller panel.');
            }

           if(auth()->user()->is_supplier == 0){
                return redirect()->route('customer.dashboard')->with('success','Welcome to 121, You have been Registered Successfully');
           }
           else{
                return view('pages.dashboard');
           }
        }else{
            return view('pages.dashboard');
        }
        if(AuthRole() == 'Brand'){
             if(!$brand_assign){
                return back()->with('error','No brand has been assigned to you!');
           }else{
               return view('pages.dashboard');
           }
        }
    }
    public function contact(Request $request)
    {
        // return $request->all();
        try {
            $this->validate($request, [
                'name' => 'required',
                'category_id' => 'required',
                'email' => 'required',
            ]);
            $data = new UserEnquiry();
            $data->name=$request->name;
            $data->category_id=$request->category_id;
            $data->email=$request->email;
            $data->status=0;
            $data->subject=$request->subject;
            $data->description=$request->description;
            $data->contact_number=$request->contact_number;
            $data->save();
            // Push On Site Notification
            $data_notification = [
                'title' => $data->name."have a enquiry",
                'notification' => $data->description,
                'link' => "#",
                'user_id' => $data->id,
            ];
            pushOnSiteNotification($data_notification);
            // End Push On Site Notification
            return redirect()->back()->with('success', 'Thank you for contacting'.config('app.name').'! Our team of experts will get in touch with you shortly.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function smsVerification(Request $request)
    {   
        if(auth()->check()){
            $user = auth()->user();
        }else{
            $user = User::where('phone', $request->phone)->first();
        }
        
        if($user->temp_otp != null){
            if($user->temp_otp = $request->verification_code){
                $user->update(['is_verified' => 1,'temp_otp'=>null ]);
                return redirect()->route('panel.dashboard');
                return $request->all();
            }else{
                return back()->with('error','OTP Mismatch');
            }
        }else{
            return back()->with('error','Try Again');
        }
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return view('clear-cache');
    }
    public function showArticle($slug)
    {
        $article = Article::where('slug',$slug)->first();
        return view('frontend.article.show',compact('article'));
    }
    public function storeNewsletter(Request $request)
    {
        $news_letter = NewsLetter::whereValue($request->email)->first();
        if ($news_letter) {
            return back()->with('success',"Subscribed Successfully!");
        }
        // elseif (auth()->check()) {
        $news = NewsLetter::create([
            'type' => 0,
            'value' =>$request->get('email'),
            'name' =>auth()->user()->name ?? $request->get('name') ?? 'anonymous',
            'phone' => $request->get('number'),
            'country_code' => $request->get('countrycode'),

        ]);
        return back()->with('success',"Subscribed Successfully!");
        // }
        // else {
        // return back()->with('error',"Please Login first to send Newsletter!");
        // }
    }

    
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (! auth()->user()) {
            
            return redirect()->url('/');
        }
        
        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id
            $admin_id = session()->get('admin_user_id');

            session()->forget('admin_user_id');
            session()->forget('temp_user_id');

            // Re-login admin
            auth()->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect()->route('panel.users.index');
        } else {
            // return 'f';
            session()->forget('admin_user_id');
            session()->forget('temp_user_id');

            // Otherwise logout and redirect to login
            auth()->logout();

            return redirect('/');
        }
    }
}
