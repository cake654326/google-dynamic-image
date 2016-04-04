<?php
namespace ContentCrackers\GoogleDynamicImage;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class GoogleDynamicImage
{
    private static function connectToCloudStorage()
    {
        try {
            $client = new \Google_Client();
            $client->setApplicationName(config('google-dynamic-image.project_id'));
            $client->setDeveloperKey(config('google-dynamic-image.api_key'));
            $client->addScope(\Google_Service_Storage::DEVSTORAGE_FULL_CONTROL);
            // Read the generated client_secrets.p12 key.
            $key = file_get_contents(storage_path() . '/' . config('google-dynamic-image.p12_file_name'));
            $cred = new \Google_Auth_AssertionCredentials(
                config('google-dynamic-image.service_email'),
                config('google-dynamic-image.google_cloud_api'),
                $key
            );

            $client->setAssertionCredentials($cred);

            if ($client->getAuth()->isAccessTokenExpired()) {
                $client->getAuth()->refreshTokenWithAssertion($cred);
            }

            $storage = new \Google_Service_Storage($client);
            return $storage;
        } catch (\Google_Service_Exception $e) {
        }
    }

    private static function cleanFileName($fileName)
    {
        //remove blanks
        $fileName = preg_replace('/\s+/', '', $fileName);
        //remove characters
        $fileName = preg_replace('/[^A-Za-z0-9.]/', "", $fileName);
        return $fileName;
    }

    private static function getUniqueName($image)
    {
        $fileName = $image->getClientOriginalName();
        $fileName = self::cleanFileName($fileName);
        $fileName = time() . '_' . $fileName;
        return $fileName;
    }

    private static function generateHashedGoogleUrl($name, $type)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://' . config('google-dynamic-image.project_id') . '.appspot.com/?path=' . $name . '&type=' . $type
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        return $resp;
    }

    public static function uploadToGoogleCloudStorage($file, $path, $type = 'image', $generate_unique_name = true)
    {
        if (!$file instanceof UploadedFile) {
            $file = new UploadedFile($path . '/' . $file, $file);
        }

        if ($generate_unique_name) {
            $unique = self::getUniqueName($file);
        } else $unique = $file->getClientOriginalName();

        $name = $path . '/' . $unique;
        $storage = self::connectToCloudStorage();

        //upload_file
        $obj = new \Google_Service_Storage_StorageObject();
        $obj->setName($name);
        $parameters = ['data' => file_get_contents($file->getRealPath()), 'uploadType' => 'multipart', 'mimeType' => $file->getMimeType()];
        if ($type != 'image') $parameters['predefinedAcl'] = 'publicRead';
        $result = $storage->objects->insert(
            config('google-dynamic-image.bucket_name'),
            $obj,
            $parameters
        );

        $hashed_url = self::generateHashedGoogleUrl($result->name, $type);
        return array($unique, $hashed_url);
    }

    public static function deleteFromGoogleCloudStorage($file)
    {
        $storage = self::connectToCloudStorage();

        try {
            //delete file
            $obj = new \Google_Service_Storage_StorageObject();
            $parameters = ['object' => $file];
            $result = $storage->objects->delete(
                config('google-dynamic-image.bucket_name'),
                $obj,
                $parameters
            );
        } catch (\Google_Exception $e) {
            return $e;
        }

    }
}