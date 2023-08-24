<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne(Customer::class,'customer_id','customer_id');
    }
}
