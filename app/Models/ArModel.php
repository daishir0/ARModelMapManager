<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArModel extends Model
{
    public $table = 'models';

    public $fillable = [
        'title',
        'latitude',
        'longitude',
        'altitude',
        'url',
        'options',
        'filename'
    ];

    protected $casts = [
        'title' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'altitude' => 'float',
        'url' => 'string',
        'options' => 'string',
        'filename' => 'string'
    ];

    public static array $rules = [
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'title' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'altitude' => 'required|numeric',
        'url' => 'required|string',
        'options' => 'required|string',
        'filename' => 'required|string|max:255'
    ];

    
}
