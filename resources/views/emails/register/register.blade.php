@component('mail::message')
# {{ __("Thank's for registration") }}

{{ __('Please activate your account.') }}
@component('mail::button', ['url' => $url, 'color' => 'green'])
{{ __('Activate account') }}
@endcomponent

{{ __('Thanks,') }}<br>
{{ config('app.name') }}
@endcomponent
