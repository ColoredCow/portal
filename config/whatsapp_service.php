<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WABA Service Settings
    |--------------------------------------------------------------------------
    |
    | gupshup is enabled by default, You can override the value in the default .
    |
     */

    'default' => env('WABA_SERVICE', 'gupshup'),

    'waba_services' => [
        'gupshup' => [
            /*
            |--------------------------------------------------------------------------
            | Gupshup API KEY
            |--------------------------------------------------------------------------
            */

            'api_key' => env('GUPSHUP_API_KEY', ''),

            /*
            |--------------------------------------------------------------------------
            | Gupshup APP NAME
            |--------------------------------------------------------------------------
            */

            'app_name' => env('GUPSHUP_APP_NAME', ''),

            /*
            |--------------------------------------------------------------------------
            | Gupshup Sender or source phone number (with country code)
            |--------------------------------------------------------------------------
            */

            'source_phone' => env('GUPSHUP_SOURCE_PHONE', ''),

            /*
            |--------------------------------------------------------------------------
            | We will call these handlers when we receive a specific event on webhook
            |--------------------------------------------------------------------------
            */

            'webhook_handlers' => [
                /*
                    |--------------------------------------------------------------------------
                    | We will match the following type specs from the gupshup documentation
                            # type
                            user-event
                                # payload.type
                                sandbox-start
                                opted-in    # payload.type == opted-in
                                opted-out   # payload.type == opted-out
                    |--------------------------------------------------------------------------
                */

                'user-event' => '',

                /*
                    |--------------------------------------------------------------------------
                    | We will match the following type specs from the gupshup documentation
                            # type
                            message-event   $ type == message-event
                            # payload.type
                            enqueued
                            failed
                            sent
                            delivered
                            read
                    |--------------------------------------------------------------------------
                */

                'message-event' => '',

                /*
                    |--------------------------------------------------------------------------
                    | We will match the following type specs from the gupshup documentation
                           message # payload.type
                            text
                            image
                            file
                            audio
                            video
                            sticker
                            contact
                            location
                    """
                    |--------------------------------------------------------------------------
                */

                'message' => ''

            ]

        ]
    ]

];
