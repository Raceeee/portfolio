<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Admin Email
    |--------------------------------------------------------------------------
    |
    | Only a Google account matching this email address (case-insensitive)
    | is permitted to sign in to the admin panel. Set this in your .env
    | file — never hardcode your personal email directly in source control.
    |
    */

    'allowed_email' => env('ADMIN_EMAIL'),

];
