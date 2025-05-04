<x-mail::message>
# Hello{{ ($user) ? ' ' . $user : '' }}!

You have successfully registered. Welcome to our community.

All the best,<br>
{{ config('app.name') }} Team
</x-mail::message>
