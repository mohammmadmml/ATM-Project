<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'bank_id',
        'card_number',
        'balance',
        'amount',
        'password',
        'password_confirmation'
    ];
    public function banks(){
        return $this->belongsTo(Bank::class,'bank_id');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
