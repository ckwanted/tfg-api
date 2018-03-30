<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'section_id', 'title', 'type', 'uri'
    ];

    /*
     * RELATIONSHIPS
     */
    public function section() {
        return $this->belongsTo(CourseSection::class);
    }

}
