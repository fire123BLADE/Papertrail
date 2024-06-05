<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';
    protected $primaryKey = 'Document_ID';
    public $timestamps = false;

    protected $fillable = [
        'Subject', 'DocumentType','Title', 'DateCreated', 'UserID', 'Status', 'RecipientEmail', 'FileName'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
    
}
