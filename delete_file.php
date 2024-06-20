<?php
$response = ['status' => 'error', 'message' => 'An error occurred'];

if (isset($_POST['filename'])) {
    $filename = basename($_POST['filename']);
    $filePath = 'uploads/' . $filename;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            $response['status'] = 'success';
            $response['message'] = 'File deleted successfully';
        } else {
            $response['message'] = 'Could not delete the file';
        }
    } else {
        $response['message'] = 'File not found';
    }
} else {
    $response['message'] = 'No filename provided';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
