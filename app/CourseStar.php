<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStar extends Model {

    public $incrementing = false;

    /**
     * Indicates model primary keys.
     */
    protected $primaryKey = ['course_id', 'user_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'user_id', 'value'
    ];

    /*
     * RELATIONSHIPS
     */
    public function course() {
        return $this->belongsTo(Course::class);
    }

}
