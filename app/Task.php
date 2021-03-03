<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['content', 'status'];
    
    /**
     * 所有ユーザ
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
