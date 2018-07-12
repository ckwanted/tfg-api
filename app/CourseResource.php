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
        'section_id', 'title', 'uri', 'quiz'
    ];

    /*
     * ACCESSORS AND MUTATORS
     */
    /**
     * Get Quiz
     *
     * @param  string  $value
     * @return string
     */
    public function getUriAttribute($value) {
        return app()->call('\App\Http\Controllers\Controller@getAmazonUrlToken', [$value]);
    }

    /**
     * Get Quiz
     *
     * @param  string  $value
     * @return string
     */
    public function getQuizAttribute($value) {
        return json_decode($value);
    }

    /*
     * RELATIONSHIPS
     */
    public function section() {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

}
