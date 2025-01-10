<?php

use Config\Mimes;

if (!function_exists('decode_base64_image')) {

    function decode_base64_image($base64_image, $uploadPath, $fileName)
    {
        // Extract the file extension and base64 string
        list($extension, $base64) = get_base64_image_file_ext($base64_image);

        // Decode the base64 string
        $decoded_data = base64_decode($base64);

        // Set the upload path and the full path with the file name
        $file_path = $uploadPath . DIRECTORY_SEPARATOR . $fileName . '.' . $extension;

        // Save the decoded image to the file path
        file_put_contents($file_path, $decoded_data);

        return $file_path; // Return the path where the image is saved
    }
}

if (!function_exists('get_base64_image_file_ext')) {
    function get_base64_image_file_ext($base64_image)
    {
        // Split the base64 string into parts (data type and actual base64)
        list($meta, $base64) = explode(';', $base64_image);
        list(, $base64) = explode(',', $base64);

        // Extract the mime type
        $mime_type = substr($meta, 5);

        // Determine the file extension based on mime type
        $extension = '';

        if (isset(Mimes::$mimes[$mime_type])) {
            $extension = Mimes::$mimes[$mime_type][0];
        } else {
            $extension = 'png';
        }
        return [$extension, $base64];
    }
}
