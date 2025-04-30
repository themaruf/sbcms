<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'publish_date'
    ];

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}