<?php
namespace Auditor\Entities;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    protected $fillable = array('fullname','email','password','type');
    protected $perPage = 15;

    public function setPasswordAttribute($value)
    {
        if (! empty($value))
        {
            $this->attributes['password'] = \Hash::make($value);
        }
    }

    public function userCompany()
    {
        return $this->hasMany('Auditor\Entities\UserCompany');
    }

    public function roads()
    {
        return $this->hasMany('Auditor\Entities\Road');
    }

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

}
