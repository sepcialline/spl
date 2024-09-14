@component('mail::message')
# Reset Password

To reset your password, click the button below:

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

If you did not request this password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
