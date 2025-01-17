<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetService extends Model
{
    use HasFactory;


    protected $guarded = [];

    // Disable auto-incrementing as composite keys are not auto-incrementing.
    public $incrementing = false;

    // Define your composite keys
    protected $primaryKey = ['user_id', 'service_id'];

    // Specify the data type for the primary key(s)
    protected $keyType = 'int';

    // Disable timestamps if you don't need them
    public $timestamps = false;

    // Override getKeyName to handle composite keys
    public function getKeyName()
    {
        return $this->primaryKey;
    }
}
