<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $json
 * @property string $created_at
 * @property string $updated_at
 */
class Data extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'json', 'created_at', 'updated_at'];

}
