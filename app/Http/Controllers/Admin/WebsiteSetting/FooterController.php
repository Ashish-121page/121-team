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

namespace App\Http\Controllers\Admin\WebsiteSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\Setting;

class FooterController extends Controller
{
    protected $path;
    public function __construct()
    {
        $this->path =   storage_path() . "/app/public/backend/logos/";
    }
    //
    public function index()
    {
        return view('backend.website_setup.footer');
    }

    public function storeAbout(Request $request)
    {
        // return $request->all();
        try {
            if ($request->has('frontend_footer_description')) {
                $frontend_footer_description = Setting::where('key', '=', 'frontend_footer_description')->first();
                if ($frontend_footer_description) {
                    $frontend_footer_description->value = $request->get('frontend_footer_description');
                    $frontend_footer_description->group_name = $request->get('group_name');
                    $frontend_footer_description->save();
                } else {
                    $data = new setting();
                    $data->key = 'frontend_footer_description';
                    $data->value = $request->get('frontend_footer_description');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', "Information Updated!!");
    }

    public function storeContact(Request $request)
    {
        // return $request->all();
        try {
            if ($request->has('frontend_footer_address')) {
                $frontend_footer_address = Setting::where('key', '=', 'frontend_footer_address')->first();
                if ($frontend_footer_address) {
                    $frontend_footer_address->value = $request->get('frontend_footer_address');
                    $frontend_footer_address->group_name = $request->get('group_name');
                    $frontend_footer_address->save();
                } else {
                    $data = new setting();
                    $data->key = 'frontend_footer_address';
                    $data->value = $request->get('frontend_footer_address');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        try {
            if ($request->has('frontend_footer_phone')) {
                $frontend_footer_phone = Setting::where('key', '=', 'frontend_footer_phone')->first();
                if ($frontend_footer_phone) {
                    $frontend_footer_phone->value = $request->get('frontend_footer_phone');
                    $frontend_footer_phone->group_name = $request->get('group_name');
                    $frontend_footer_phone->save();
                } else {
                    $data = new setting();
                    $data->key = 'frontend_footer_phone';
                    $data->value = $request->get('frontend_footer_phone');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

        try {
            if ($request->has('frontend_footer_email')) {
                $frontend_footer_email = Setting::where('key', '=', 'frontend_footer_email')->first();
                if ($frontend_footer_email) {
                    $frontend_footer_email->value = $request->get('frontend_footer_email');
                    $frontend_footer_email->group_name = $request->get('group_name');
                    $frontend_footer_email->save();
                } else {
                    $data = new setting();
                    $data->key = 'frontend_footer_email';
                    $data->value = $request->get('frontend_footer_email');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', "Information Updated!!");
    }

    public function storeFooterLinks(Request $request)
    {
        // return $request->all();
        try {
            if ($request->has('footer_link_widget')) {
                $footer_link_widget = Setting::where('key', '=', 'footer_link_widget')->first();
                if ($footer_link_widget) {
                    $footer_link_widget->value = $request->get('footer_link_widget');
                    $footer_link_widget->group_name = $request->get('group_name');
                    $footer_link_widget->save();
                } else {
                    $data = new setting();
                    $data->key = 'footer_link_widget';
                    $data->value = $request->get('footer_link_widget');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', "Information Updated!!");
    }
    
    public function storeFooterBottom(Request $request)
    {
        // return $request->all();
        try {
            if ($request->has('frontend_copyright_text')) {
                $frontend_copyright_text = Setting::where('key', '=', 'frontend_copyright_text')->first();
                if ($frontend_copyright_text) {
                    $frontend_copyright_text->value = $request->get('frontend_copyright_text');
                    $frontend_copyright_text->group_name = $request->get('group_name');
                    $frontend_copyright_text->save();
                } else {
                    $data = new setting();
                    $data->key = 'frontend_copyright_text';
                    $data->value = $request->get('frontend_copyright_text');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

        try {
            if ($request->has('show_social_links')) {
                $show_social_links = Setting::where('key', '=', 'show_social_links')->first();
                if ($show_social_links) {
                    $show_social_links->value = $request->get('show_social_links');
                    $show_social_links->group_name = $request->get('group_name');
                    $show_social_links->save();
                } else {
                    $data = new setting();
                    $data->key = 'show_social_links';
                    $data->value = $request->get('show_social_links');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        try {
            if ($request->has('show_social_links')) {
                $show_social_links = Setting::where('key', '=', 'show_social_links')->first();
                if ($show_social_links) {
                    $show_social_links->value = $request->get('show_social_links');
                    $show_social_links->group_name = $request->get('group_name');
                    $show_social_links->save();
                } else {
                    $data = new setting();
                    $data->key = 'show_social_links';
                    $data->value = $request->get('show_social_links');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        try {
            if ($request->has('facebook_link')) {
                $facebook_link = Setting::where('key', '=', 'facebook_link')->first();
                if ($facebook_link) {
                    $facebook_link->value = $request->get('facebook_link');
                    $facebook_link->group_name = $request->get('group_name');
                    $facebook_link->save();
                } else {
                    $data = new setting();
                    $data->key = 'facebook_link';
                    $data->value = $request->get('facebook_link');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        try {
            if ($request->has('twitter_link')) {
                $twitter_link = Setting::where('key', '=', 'twitter_link')->first();
                if ($twitter_link) {
                    $twitter_link->value = $request->get('twitter_link');
                    $twitter_link->group_name = $request->get('group_name');
                    $twitter_link->save();
                } else {
                    $data = new setting();
                    $data->key = 'twitter_link';
                    $data->value = $request->get('twitter_link');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        try {
            if ($request->has('instagram_link')) {
                $instagram_link = Setting::where('key', '=', 'instagram_link')->first();
                if ($instagram_link) {
                    $instagram_link->value = $request->get('instagram_link');
                    $instagram_link->group_name = $request->get('group_name');
                    $instagram_link->save();
                } else {
                    $data = new setting();
                    $data->key = 'instagram_link';
                    $data->value = $request->get('instagram_link');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        try {
            if ($request->has('youtube_link')) {
                $youtube_link = Setting::where('key', '=', 'youtube_link')->first();
                if ($youtube_link) {
                    $youtube_link->value = $request->get('youtube_link');
                    $youtube_link->group_name = $request->get('group_name');
                    $youtube_link->save();
                } else {
                    $data = new setting();
                    $data->key = 'youtube_link';
                    $data->value = $request->get('youtube_link');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        try {
            if ($request->has('linkedin_link')) {
                $linkedin_link = Setting::where('key', '=', 'linkedin_link')->first();
                if ($linkedin_link) {
                    $linkedin_link->value = $request->get('linkedin_link');
                    $linkedin_link->group_name = $request->get('group_name');
                    $linkedin_link->save();
                } else {
                    $data = new setting();
                    $data->key = 'linkedin_link';
                    $data->value = $request->get('linkedin_link');
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        try {
            if ($request->hasFile('payment_method_images')) {
                $image = $request->file('payment_method_images');
                $imageName = 'logo-'.rand(000, 999). '.' . $image->getClientOriginalExtension();
                $image->move($this->path, $imageName);
                
                $logo = Setting::where('key', '=', 'payment_method_images')->first();
                if ($logo) {
                    unlinkfile($this->path, $logo->value);
                    $logo->value = $imageName;
                    $logo->group_name = $request->get('group_name');
                    $logo->save();
                } elseif (!$logo) {
                    $data = new Setting();
                    $data->key ='payment_method_images';
                    $data->value = $imageName;
                    $data->group_name = $request->get('group_name');
                    $data->save();
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', "Information Updated!!");
    }
}
