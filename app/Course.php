<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'description', 'category', 'skill_level', 'price', 'photo'
    ];

    /*
     * RELATIONSHIPS
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sections() {
        return $this->hasMany(CourseSection::class);
    }

}
