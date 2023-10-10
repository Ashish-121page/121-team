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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use DataTables,Auth;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the roles page
     *
     */
    public function index(Request $request)
    {
        try{
            $length = 10;
            if(request()->get('length')){
                $length = $request->get('length');
            }
            $roles = Role::pluck('name','id');
            $permissions = Permission::query();
            if($request->get('search')){
                $permissions->where('name','like','%'.$request->search.'%');
            }
            $permissions= $permissions->paginate($length);
            if ($request->ajax()) {
                return view('permission.load-permission', ['permissions' => $permissions,'roles' => $roles])->render();  
            }

            return view('permission.new-permission', compact('roles','permissions'));
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    /**
     * Show the role list with associate permissions.
     * Server side list view using yajra datatables
     */

    /**
     * Store new roles with assigned permission
     * Associate permissions will be stored in table
     */

    public function create(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'permission' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try{
            $permission = Permission::create(['name' => $request->permission]);
            $permission->syncRoles($request->roles);

            if($permission){ 
                return redirect('panel/permission')->with('success', 'Permission created succesfully!');
            }else{
                return redirect('panel/permission')->with('error', 'Failed to create permission! Try again.');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

  

    public function update(Request $request)
    {

        // update permission table
        $permission = Permission::find($request->id);
        $permission->name = $request->name;
        $permission->save();

        return $permission;
    }


    public function delete($id)
    {
        $permission   = Permission::find($id);
        if($permission){
            $delete = $permission->delete();
            $perm   = $permission->roles()->delete();

            return redirect('panel/permission')->with('success', 'Permission deleted!');
        }else{
            return redirect('404');
        }
    }


    public function getPermissionBadgeByRole(Request $request){
        $badges = '';
        if ($request->id) {
            $role = Role::find($request->id);
            $permissions =  $role->permissions()->pluck('name','id');
            foreach ($permissions as $key => $permission) {
                $badges .= '<span class="badge badge-dark m-1">'.$permission.'</span>';
            }
        }

        if($role->name == 'Super Admin'){
            $badges = 'Super Admin has all the permissions!';
        }

        return $badges;
    }
}
