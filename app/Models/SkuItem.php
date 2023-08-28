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
}
