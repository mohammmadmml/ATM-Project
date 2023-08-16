<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'code'
    ];
    public function cards(){
        return $this->hasMany(Card::class);
    }
}
