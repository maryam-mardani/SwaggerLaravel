<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use LogsActivity;
    use HasFactory,SoftDeletes;
    protected $guarded=[],$hidden=['created_at','updated_at','deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
