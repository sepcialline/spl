<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VendorResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $resetUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(config('auth.passwords.vendors.expire')),
            ['token' => $this->token, 'email' => $this->email]
        );

        return $this->markdown('emails.reset_password')
            ->with(['resetUrl' => $resetUrl]);
    }
}
