<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'title'
    ];

    /*
     * RELATIONSHIPS
     */
    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function resources() {
        return $this->hasMany(CourseSection::class);
    }

}
