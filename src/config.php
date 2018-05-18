<?php

return [
    'node' => [

        'bin_path' => env('SSR_NODE_BIN_PATH', ''),

        'temp_path' => storage_path('app/public')

    ],

    'js_path' => public_path('js')
];