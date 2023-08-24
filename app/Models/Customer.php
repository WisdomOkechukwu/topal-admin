<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    protected $hidden = ['pin'];
    protected $appends = ['profile_picture_link'];

    public function wallet()
    {
        return $this->hasOne(Wallet::class,'customer_id','customer_id');
    }

    public function transactions()
    {
        return  $this->hasMany(Transaction::class,'customer_id','customer_id');
    }

    public function savings()
    {
        return  $this->hasMany(Saving::class,'customer_id','customer_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class,'customer_id','customer_id');
    }

    public function getProfilePictureLinkAttribute()
    {
        if ($this->profile_picture == null) {
            return null;
        } else {
            $document = $this->profile_picture;
            $link = asset("storage/documents/profile_pictures/".$document);
            return $link;
        }
    }
}
