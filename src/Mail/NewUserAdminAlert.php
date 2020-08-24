<?php

namespace LaraSnap\LaravelAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserAdminAlert extends Mailable
{
    use Queueable, SerializesModels;
	
    public $userID;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userID)
    {
        $this->userID = $userID;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userDetailLink = route('users.edit', $this->userID);
        // New User Registration
        return $this->markdown('larasnap::emails.new_user')->subject("New User Registeration")->with('userDetailLink', $userDetailLink);
    }
}
