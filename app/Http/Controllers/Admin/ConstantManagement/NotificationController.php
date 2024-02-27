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
use App\Models\Notification;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        try {
            $roles = Role::whereIn('id', [3,10])->get()->pluck('name', 'id');
            $notification = Notification::where('user_id','=',auth()->id())->latest()->get();
            return view('notification', compact('notification', 'roles'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function seeAllNotification(Request $request)
    {
        //  Notification::whereUserId(auth()->id())->whereIsReaded(0)->get();
       Notification::whereUserId(auth()->id())->whereIsReaded(0)->update([
        'is_readed'=>1
       ]);
       return redirect(route('panel.constant_management.notification.index'));
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
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        $notification->update(['is_readed'=>1]);
        if ($notification->link != null && $notification->link != "#") {
            return redirect($notification->link);
        
        } else {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
