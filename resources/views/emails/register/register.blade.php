@component('mail::message')
# Thank's for registration

Please activate your account.
@component('mail::button', ['url' => $url, 'color' => 'green'])
Activate account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
