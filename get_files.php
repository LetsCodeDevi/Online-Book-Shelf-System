<?php
// Directory where uploaded files are stored
$uploadDir = 'uploads/';

// Initialize array to store file names
$fileList = [];

// Check if directory exists
if (is_dir($uploadDir)) {
    // Open directory
    if ($dh = opendir($uploadDir)) {
        // Read files from directory
        while (($file = readdir($dh)) !== false) {
            // Skip parent and current directory entries
            if ($file != '.' && $file != '..') {
                // Add file to list
                $fileList[] = array('filename' => $file);
            }
        }
        // Close directory
        closedir($dh);
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($fileList);
?>
