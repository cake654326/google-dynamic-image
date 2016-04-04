<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Google Cloud Platform : Project ID
    |--------------------------------------------------------------------------
    |
    | You can find your Project ID on your Google Cloud Platform dashboard.
    | Note: you'll need the Project ID, not the Project number.
    |
    | https://console.cloud.google.com/home/dashboard
    |
    */
    'project_id' => '',

    /*
    |--------------------------------------------------------------------------
    | Google Cloud Platform : Api key
    |--------------------------------------------------------------------------
    |
    | You can generate an api key at the credentials section in the
    | API Manager, pick 'Server key' in the popup dialog
    |
    | https://console.cloud.google.com/apis/credentials
    |
    */
    'api_key' => '',

    /*
    |--------------------------------------------------------------------------
    | Google Cloud Platform : Service account key
    |--------------------------------------------------------------------------
    |
    | You can generate a service account key at the credentials section in the
    | API Manager, pick 'Service account key'. Choose p12 as Key type and
    | place the downloaded file in your storage folder. Put the name of the p12
    | file below.
    |
    | https://console.cloud.google.com/apis/credentials/serviceaccountkey
    |
    */
    'p12_file_name' => '',

    /*
    |--------------------------------------------------------------------------
    | Google Cloud Platform : Service account email address
    |--------------------------------------------------------------------------
    |
    | You can create a service account key at the Service accounts
    | tab in the Permissions section. We give it the Editor role.
    | Give it a name and type in the email address below. Don't forget to add it
    | to your bucket permissions, you can add it when you edit your bucket
    | permissions: https://console.cloud.google.com/storage/browser
    |
    | https://console.cloud.google.com/permissions/serviceaccounts
    |
    */
    'service_email' => '',

    /*
    |--------------------------------------------------------------------------
    | Google Cloud Platform : Bucket Name
    |--------------------------------------------------------------------------
    |
    | The bucket where you want to store your files
    |
    */
    'bucket_name' => '',

    /*
    |--------------------------------------------------------------------------
    | Google Cloud Api
    |--------------------------------------------------------------------------
    |
    */
    'google_cloud_api' => 'https://www.googleapis.com/auth/devstorage.read_write',

);
