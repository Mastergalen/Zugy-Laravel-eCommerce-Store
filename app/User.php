<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class User
 *
 * Group ID:
 * 0 - Normal user
 * 1 - Super admin
 * 2 - Admin
 * 3 - Driver
 *
 * @package App
 */

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'settings'];

    protected $casts = [
        'settings' => 'json'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $adminGroupIds = [1, 2, 3];

    /**
     * Get the user settings.
     *
     * @return Settings
     */
    public function settings()
    {
        return new Settings($this);
    }

    /**
     * Define relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function oauth_authorisations()
    {
        return $this->hasMany('App\OAuthAuthorisations');
    }

    /**
     * Define relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    /**
     * Define relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment_methods()
    {
        return $this->hasMany('App\PaymentMethod');
    }

    /**
     * Define relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function basket()
    {
        return $this->hasMany('App\Basket');
    }

    /**
     * Define accessor for user language setting
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getLanguageCodeAttribute()
    {
        return strtolower(Language::find(auth()->user()->settings()->language)->pluck('code'));
    }

    public function getIsAdminAttribute()
    {
        return in_array($this->attributes['group_id'], $this->adminGroupIds);
    }
}
