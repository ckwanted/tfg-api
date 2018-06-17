<?php

namespace App\Mail;

use App\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartMail extends Mailable {
    use Queueable, SerializesModels;

    public $courses = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($coursesId) {

        foreach($coursesId as $courseId) {
            array_push($this->courses, Course::findOrFail($courseId));
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('email.cart')
                    ->subject("ULPGC COURSE");
    }

}
