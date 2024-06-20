<?php
header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => 'Unknown error occurred.'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        // Check if the file is a PDF
        $fileType = mime_content_type($_FILES['file']['tmp_name']);
        if ($fileType === 'application/pdf') {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                $response['status'] = 'success';
                $response['message'] = 'File successfully uploaded.';
            } else {
                $response['message'] = 'Error moving uploaded file.';
            }
        } else {
            $response['message'] = 'Please upload a valid PDF file.';
        }
    } else {
        $response['message'] = 'No file uploaded or upload error.';
    }
} else {
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>
