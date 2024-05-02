<?php
namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

    protected $fillable = [
        'username', 'password', 'Department', 'FirstName', 'LastName', 'Email',
    ];

    // Implement the required methods of the Authenticatable interface
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute('username');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    // Methods related to remember tokens
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    // Implement other methods as needed
}
