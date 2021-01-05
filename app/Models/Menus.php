<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The table primary key name
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The fields allows fill
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'order',
        'icon',
        'name',
        'route',
    ];

    /**
     * The fields does not allows fill
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menusAccessGroups()
    {
        return $this->hasMany('App\Models\MenusAccessGroups', 'menus_id', 'id');
    }

    /**
     * @param $request
     * @return Sped_nfe|\Illuminate\Support\Collection|static
     */
    static public function getMenu($accessGroups)
    {
        try {
            $entity = Menus::join('menus_access_groups', 'menus_access_groups.menus_id', '=', 'menus.id')
                ->where('menus_access_groups.access_groups_id', $accessGroups)
                ->select(
                    'menus.id',
                    'menus.parent_id',
                    'menus.order',
                    'menus.icon',
                    'menus.name',
                    'menus.route'
                )
                ->get();

            return $entity;
        } catch (\Exception $e) {
            return new Menus();
        }
    }
}