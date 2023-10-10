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

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\UserNote;
use Illuminate\Http\Request;

class UserNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_note = UserNote::all();
        return view('backend.admin.manage.user-note.index', compact('user_note'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.manage.user-note.create');
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
        // return $request->all();
        try {
            $this->validate($request, [
                'title' => 'required',
                'description' => 'required',
            ]);
            $data = new UserNote();
            $data->title=$request->title;
            $data->description=$request->description;
            $data->type=$request->type;
            $data->type_id=$request->type_id;
            $data->save();
            return redirect()->back()->with('success', 'User Note created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error:' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user_note = UserNote::whereId($id)->first();
        return view('backend.admin.manage.user-note.show', compact('user_note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_note = UserNote::whereId($id)->first();
        return view('backend.admin.manage.user-note.edit', compact('user_note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        //
        try {
            $data = UserNote::whereId($id)->first();
            $data->title=$request->title;
            $data->description=$request->description;
            $data->type=$request->type;
            $data->type_id=$request->type_id;
            $data->save();
            return redirect()->back()->with('success', 'User Note update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = UserNote::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'User Note Deleted Successfully!');
        }
    }
}
