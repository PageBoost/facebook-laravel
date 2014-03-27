<?php
return array(
    'laravelDebug' => false, // Log api calls
    'appId' => 'YOUR-FACEBOOK-APP-ID',
    'secret' => 'YOUR-FACEBOOK-APP-SECRET',
    'allowSignedRequest' => true, // Indicates if signed_request is allowed in query parameters.
    'fileUpload' => false, // Indicates if the CURL based @ syntax for file uploads is enabled.
    'trustForwarded' => false, // Indicates if we trust HTTP_X_FORWARDED_* headers.
);
