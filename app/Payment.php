<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'stripe_id', 'amount',
    ];

    /*
     * RELATIONSHIPS
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

}
