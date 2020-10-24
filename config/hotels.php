<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The available providers.
    |--------------------------------------------------------------------------
    |
    | Here you may specify the available hotel providers to be used to
    | fetch and aggregate hotels.
    |
    | Note: The provider(s) must implement the \App\Providers\HotelProvider interface.
    */
    'providers' => [
        \App\Providers\BestHotelProvider::class,
        \App\Providers\TopHotelsProvider::class,
    ],
];
