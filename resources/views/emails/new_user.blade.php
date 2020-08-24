@component('mail::message')

New user has registered to your website.

Account activation is requested before the user login. You must manually activate their account.

<a href="{{ $userDetailLink }}">Click Here</a> or copy paste the URL {{ $userDetailLink }} on the browser to view user details.

Thanks,<br>

{{ setting('site_name') }}

@endcomponent
