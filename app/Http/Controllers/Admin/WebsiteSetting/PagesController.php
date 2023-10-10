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
use App\Models\WebsitePage;

class PagesController extends Controller
{
    //
    public function index(Request $request)
    {
        $length = 50;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $page = WebsitePage::query();
        //   return $request->all();
            if($request->get('from') && $request->get('to') ){
        //  return explode(' - ', $request->get('date')) ;
            $page->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }
            $page= $page->paginate($length);
            if ($request->ajax()) {
                return view('backend.website_setup.pages.load', ['page' => $page])->render();  
            }
        return view('backend.website_setup.pages.index', compact('page'));
    }
    public function print(Request $request){
        // return $request->all();
        // return $request->articles;
        //    return json_decode($request->articles,true);
        $pages = collect($request->records['data']);
        return view('backend.website_setup.pages.print', ['pages' => $pages])->render();  
    }

    public function createPage()
    {
        return view('backend.website_setup.pages.create');
    }

    public function storePages(Request $request)
    {
        //
        // return $request->all();
        try {
            $this->validate($request, [
                'title' => 'required',
                'slug' => 'required',
                'content' => 'required',
                'status' => 'required'
            ]);
            $data = new WebsitePage();
            $data->title=$request->title;
            $data->slug=$request->slug;
            $data->content=$request->content;
            $data->status=$request->status;
            $data->page_meta_title=$request->page_meta_title;
            $data->page_meta_description=$request->page_meta_description;
            $data->page_keywords=$request->page_keywords;
            if ($request->hasFile('page_meta_image')) {
                $image = $request->file('page_meta_image');
                $path = storage_path('app/public/backend/page');
                $imageName = 'page_meta_image' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->page_meta_image=$imageName;
            }
            $data->save();
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        
        return redirect(route('panel.website_setting.pages'))->with('success', 'Website Page created successfully.');
    }
    public function editPage($id)
    {
        //
        $page = WebsitePage::whereId($id)->first();
        return view('backend.website_setup.pages.edit', compact('page'));
    }

    public function updatePage(Request $request, $id)
    {
        // return $id;
        // return $request->all();
        try {
            $this->validate($request, [
                    'title' => 'required',
                    'slug' => 'required',
                    'content' => 'required',
                ]);
            $data = WebsitePage::whereId($id)->first();
            $data->title=$request->title;
            $data->slug=$request->slug;
            $data->content=$request->content;
            $data->status=$request->status ?? 0;
            
            $data->page_meta_title=$request->page_meta_title;
            $data->page_meta_description=$request->page_meta_description;
            $data->page_keywords=$request->page_keywords;
            if ($request->hasFile('page_meta_image')) {
                if ($data->page_meta_image != null) {
                    unlinkfile(storage_path() . '/app/public/backend/page', $data->page_meta_image);
                }
                $image = $request->file('page_meta_image');
                $path = storage_path('app/public/backend/page');
                $imageName = 'page_meta_image' . $data->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $data->page_meta_image=$imageName;
            }
            $data->save();
        }
        catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
        return redirect(route('panel.website_setting.pages'))->with('success', 'Website Page update successfully.');
    }

    public function storeHome(Request $request)
    {
        return $request->all();
    }

    public function destroy($id)
    {
        //
        $chk = WebsitePage::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Page Deleted Successfully!');
        }
    }
}
