<?php

if (!function_exists('upload_file')) {
    /**
     * Upload a file to a specified destination.
     *
     * @param string $inputName The name of the file input field
     * @param string $uploadPath The path where the file will be uploaded
     * @param array $allowedTypes An array of allowed MIME types or file extensions
     * @return array An associative array with 'status' and 'message'
     */
    function upload_file($inputName, $uploadPath, $allowedTypes = [])
    {
        $file = \Config\Services::request()->getFile($inputName);

        if (!$file->isValid()) {
            return ['status' => false, 'message' => $file->getErrorString()];
        }

        $randomName = generate_random_name(10) . '.' . $file->getExtension();

        // Set upload configurations
        $config = [
            'path' => $uploadPath,
            'name' => $randomName,
            'overwrite' => false,
            'allowed_types' => implode('|', $allowedTypes),
        ];

        if (!$file->move($config['path'], $config['name'])) {
            return ['status' => false, 'message' => "FILE UPLOAD FAILED"];
        }

        return ['status' => true, 'message' => 'File uploaded successfully!', 'file_name' => $config['name']];
    }
}

if (!function_exists('upload_bulk_files')) {
    /**
     * Upload multiple files to a specified destination.
     *
     * @param string $inputName The name of the file input field
     * @param string $uploadPath The path where the files will be uploaded
     * @param array $allowedTypes An array of allowed MIME types or file extensions
     * @return array An associative array with 'status', 'messages', and 'uploaded_files'
     */
    function upload_bulk_files($inputName, $uploadPath, $allowedTypes = [])
    {
        // Get the array of uploaded files
        $files = \Config\Services::request()->getFiles();
        
        // Check if there are any files uploaded under the given input name
        if (!isset($files[$inputName]) || count($files[$inputName]) === 0) {
            return ['status' => false, 'message' => 'No files uploaded'];
        }

        // Array to hold the status of each file upload
        $uploadedFiles = [];
        $errors = [];

        foreach ($files[$inputName] as $file) {
            // Validate the file
            if (!$file->isValid()) {
                $errors[] = $file->getErrorString();
                continue;
            }

            $randomName = generate_random_name(10) . '.' . $file->getExtension();

            // Set upload configuration for each file
            $config = [
                'path' => $uploadPath,
                'name' => $randomName,
                'overwrite' => false,
                'allowed_types' => implode('|', $allowedTypes),
            ];

            // Attempt to move the file
            if (!$file->move($config['path'], $config['name'])) {
                $errors[] = "Failed to upload file: " . $file->getName();
            } else {
                $uploadedFiles[] = $config['name'];
            }
        }

        // Return result
        if (count($uploadedFiles) > 0) {
            return [
                'status' => true,
                'message' => 'Files uploaded successfully!',
                'uploaded_files' => $uploadedFiles,
                'errors' => $errors
            ];
        }

        return ['status' => false, 'message' => 'File upload failed for all files', 'errors' => $errors];
    }
}


if (!function_exists('get_uploaded_file_path')) {
    /**
     * Get the full path of an uploaded file.
     *
     * @param string $fileName The name of the uploaded file
     * @param string $uploadPath The path where the file was uploaded
     * @return string The full path to the file
     */
    function get_uploaded_file_path($fileName, $fileType)
    {
        return base_url() . 'uploads/' . $fileType . '/' . $fileName;
    }
}


if (!function_exists('generate_random_name')) {
    /**
     * Generate a random name with a specified length.
     *
     * @param int $length The length of the random name
     * @return string The generated random name
     */
    function generate_random_name($length = 16)
    {
        // Define the characters to be used in the random name
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomName = '';

        // Generate the random name
        for ($i = 0; $i < $length; $i++) {
            $randomName .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomName;
    }
}

if (!function_exists('getFilePath')) {

    function getFilePath($fileType = '')
    {

        if (!empty($fileType) && $fileType != '') {
            return UPLOADPATH . $fileType;
        } else {
            return UPLOADPATH;
        }

    }

}