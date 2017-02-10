<?php
/**
 * Created by PhpStorm.
 * User: yatou02
 * Date: 2017/2/9
 * Time: 18:00
 */
namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use Config;

class Role extends EntrustRole
{
    protected $authGuardName='admin';

    protected $fillable=['name','display_name','description'];

    public function users()
    {
        return $this->belongsToMany(Config::get('entrust.user'), Config::get('entrust.role_user_table'),Config::get('entrust.role_foreign_key'),Config::get('entrust.user_foreign_key'));
    }
}