<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

    protected $fillable = [
        'username', 'Password', 'Department', 'FirstName', 'LastName', 'Email',
    ];

   
}
