<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';
    protected $primaryKey = 'Document_ID';
    public $timestamps = false;

    protected $fillable = [
        'Subject', 'DocumentType','Title', 'Date', 'UserID', 'Status', 'RecipientEmail', 'FileName'
    ];
    protected $casts = [
        'Date' => 'datetime', // Assuming 'date' is your actual date field
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
    
}
