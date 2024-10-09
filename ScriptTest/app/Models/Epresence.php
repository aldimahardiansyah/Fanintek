<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epresence extends Model
{
    use HasFactory;

    protected $table = 'epresence';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
