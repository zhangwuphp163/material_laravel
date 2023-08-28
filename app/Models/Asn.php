<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asn extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'asns';
    protected $fillable = ['asn_number','status','remarks','inbound_at','confirmed_at'];
    public function items(){
        return $this->hasMany(AsnItem::class);
    }

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
