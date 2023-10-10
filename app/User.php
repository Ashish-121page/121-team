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

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email',
    //     'password','status','phone','is_verified','temp_otp','provider','provider_id','timezone','language','industry_id','ekyc_status','ekyc_info','is_supplier','email_verified_at','country','state','city'
    // ];

    protected $guarded = ['id'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // public function getTableColumns() {
    //     return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    // }

    public function get_roles(){
        $roles = [];
        foreach ($this->getRoleNames() as $key => $role) {
            $roles[$key] = $role;
        }

        return $roles;
    }

    public function scopeNotRole(Builder $query, $roles, $guard = null): Builder 
    { 
         if ($roles instanceof Collection) { 
             $roles = $roles->all(); 
         } 
  
         if (! is_array($roles)) { 
             $roles = [$roles]; 
         } 
  
         $roles = array_map(function ($role) use ($guard) { 
             if ($role instanceof Role) { 
                 return $role; 
             } 
  
             $method = is_numeric($role) ? 'findById' : 'findByName'; 
             $guard = $guard ?: $this->getDefaultGuardName(); 
  
             return $this->getRoleClass()->{$method}($role, $guard); 
         }, $roles); 
  
         return $query->whereHas('roles', function ($query) use ($roles) { 
             $query->where(function ($query) use ($roles) { 
                 foreach ($roles as $role) { 
                     $query->where(config('permission.table_names.roles').'.id', '!=' , $role->id); 
                 } 
             }); 
         }); 
    }
    /**
     * Get avatar attribute with full path
     *
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        $avatar = !is_null($value) ? $value : 'https://ui-avatars.com/api/?name='.$this->name.'&background=6666CC&color=ffffff&v='.rand(00,99);
        if(\Str::contains(request()->url(), 'api')){
          return asset($avatar);
        }
        if($value){
            return asset('storage/backend/users/'.$avatar);
        }else{
            return $avatar;
        }
    }
    
    public function scopeRole(Builder $query, $roles, $guard = null): Builder 
    { 
         if ($roles instanceof Collection) { 
             $roles = $roles->all(); 
         } 
  
         if (! is_array($roles)) { 
             $roles = [$roles]; 
         } 
  
         $roles = array_map(function ($role) use ($guard) { 
             if ($role instanceof Role) { 
                 return $role; 
             } 
  
             $method = is_numeric($role) ? 'findById' : 'findByName'; 
             $guard = $guard ?: $this->getDefaultGuardName(); 
  
             return $this->getRoleClass()->{$method}($role, $guard); 
         }, $roles); 
  
         return $query->whereHas('roles', function ($query) use ($roles) { 
             $query->where(function ($query) use ($roles) { 
                 foreach ($roles as $role) { 
                     $query->where(config('permission.table_names.roles').'.id', '=' , $role->id); 
                 } 
             }); 
         }); 
    }

}
