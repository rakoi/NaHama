<?php

namespace App\Models;

use App\Models\Scopes\PropertyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Property extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $casts=[
        'is_available'=>'boolean'
    ];
    protected $fillable=[
        'title',
        'description',
        'contact',
        'user_id',
        'sizes_id',
        'town_id',
        'longitutde',
        'latitude',
        'is_available',
        'location'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }
    public function  town(){
        return $this->belongsTo(Town::class);
    }
    public function property(){
        return $this->hasMany(Review::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new PropertyScope());
    }

    function setLocationAttribute($value)
    {
        //replace lat_column_name and lng_column_name with your column names
        $this->attributes['location'] = $value;
        $_location = @json_decode($value,true);
        $this->attributes['latitude'] = data_get($_location,"lat");
        $this->attributes['longitutde'] = data_get($_location,"lng");
    }
}
