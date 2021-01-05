<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Support\Facades\Hash;

class Users extends Model implements Authenticatable
{

    use AuthenticableTrait;

    private $haveAccessGroup;

    protected $table = 'users';

    protected $fillable = [
        'fullname',
        'email',
        'username',
        'password',
        'active',
        'access_groups_id',
    ];

    protected $hidden = [
        'password'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = crypt($value, env('API_KEY'));
    }

    public function accessGroups()
    {
        return $this->hasOne('App\Models\AccessGroups', 'id', 'access_groups_id');
    }

    public function hasRole($roles)
    {

        $this->haveAccessGroup = $this->getUserAccessGroup();

        // Check if the user is a root account
        if ($this->haveAccessGroup->name == 'Root') {
            return true;
        }

        if (is_array($roles)) {

            foreach($roles as $role) {

                if($this->checkIfUserHasRole($role)) {
                    return true;
                }
            }

        } else {
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }

    public function getUserAccessGroup()
    {
        return $this->accessGroups()->getResults();
    }

    private function checkIfUserHasRole($role)
    {
        return (strtolower($role) == strtolower($this->haveAccessGroup->name)) ? true : false;
    }

    public static function getMenus($accessGroupsId)
    {
        try {
            $entity = \App\Models\Menus::getMenu($accessGroupsId);

            return $entity;
        } catch (\Exception $e) {
            return new Campaigns();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies() :\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\Companies', 'users_has_companies','users_id', 'companies_id');
    }

    public function getUserCompanies()
    {
        return  $this->companies()->getResults();
    }

}