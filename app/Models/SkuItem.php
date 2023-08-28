<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkuItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'sku_items';
    protected $fillable = [
        'sku_id',
        'material_id',
        'qty'
    ];

    public function materials(){
        return $this->belongsToMany(Material::class);
    }

    public function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
