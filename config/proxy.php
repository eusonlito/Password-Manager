<?php

use Illuminate\Http\Request;

return [
    'trusted' => env('PROXY_TRUSTED', ''),
    'headers' => env('PROXY_HEADERS', Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO),
    'hosts' => env('PROXY_HOSTS', ''),
];
