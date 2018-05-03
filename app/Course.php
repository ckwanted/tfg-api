<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model {

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'description', 'category', 'skill_level', 'price', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    /*
     * ACCESSORS AND MUTATORS
     */
    /**
     * Get photo
     *
     * @param  string  $value
     * @return string
     */
    public function getPhotoAttribute($value) {
        return app()->call('\App\Http\Controllers\Controller@getAmazonUrlToken', [$value]);
    }

    /*
     * RELATIONSHIPS
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sections() {
        return $this->hasMany(CourseSection::class);
    }

    public function stars() {
        return $this->hasMany(CourseStar::class);
    }

}
