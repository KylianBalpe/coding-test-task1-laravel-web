<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        'name'
    ];
}
