<?php 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: openpage.php");
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies. ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        div.read_header{
    text-align: left;
    background: burlywood;
    width: 100%;
    padding: 20px 0px;

}
div.banner_read{
    background-image: url('images/homebg.avif'); /* Replace with your image URL */
            background-size: cover; /* Ensure the image covers the entire screen */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            background-attachment: fixed; /* Ensure the background stays fixed during scroll */
            background-position: center center; /* Center the background image */
            height: 100vh; /* Ensure the body height covers the entire viewport height */
            margin: 0; /* Remove default body margin */
}
div.bannerheader_read{
    text-align: center;
}
div.booklist{

}
</style>
</head>
<body>
<div class="read_header">
            <button id="back">Back</button>
        </div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
  $("#back").click(function(event){
    event.preventDefault();
    window.location.href = "homepage.php";
  });
  function fetchFiles(searchTerm = '') {
    $.ajax({
        url: 'get_files.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var fileListHTML = '';
            if (response.length > 0) {
                response.forEach(function(file) {
                    if (file.filename.toLowerCase().includes(searchTerm.toLowerCase())) {
                    fileListHTML += '<div class="mb-3">';
                        fileListHTML += '<a href="uploads/' + file.filename + '" target="_blank">' + file.filename + '</a>';
                        fileListHTML += ' <button class="btn btn-danger btn-sm delete-file-btn" data-filename="' + file.filename + '">Delete</button>';
                        fileListHTML += '</div>';
                    }
                });
            } else {
                fileListHTML = '<p>No files uploaded yet.</p>';
            }
            $('#fileList').html(fileListHTML);
             // Attach delete event handler to each delete button
             $('.delete-file-btn').on('click', function() {
                    var filename = $(this).data('filename');
                    deleteFile(filename);
                });

        }
    });
}
function deleteFile(filename) {
        $.ajax({
            url: 'delete_file.php',
            type: 'POST',
            data: { filename: filename },
            success: function(response) {
                $('#uploadMessage').html('<div class="alert alert-' + response.status + '">' + response.message + '</div>');
                if (response.status === 'success') {
                    // Update file list
                    fetchFiles();
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    }

    // Initially fetch uploaded files when page loads
    fetchFiles();
    // Search functionality
    $('#searchInput').on('input', function() {
        const searchTerm = $(this).val();
        fetchFiles(searchTerm);
    });
});

</script>
<div class="banner_read">
            <div class="readpagecontainer">              
                <div class="bannerheader_read">
                    <h1>BSMS</h1>
                    <p><h2>Book Shelf Management System</h2></p>
                    <p>Read Books Online and live your world of Joy..</p>
                </div>
                
                <div class="bannericons">
                   <a href=""><i class="fa fa-android"></i></a>
                   <a href=""><i class="fa-brands fa-apple"></i></a>
                   <a href=""><i class="fa-brands fa-windows"></i></a>
                </div>
            </div>
            <div class="container">
    <h1>Uploaded Books</h1>
    <input type="text" id="searchInput" class="form-control" placeholder="Search Book..."><br><br>
    <div class="booklist" id="fileList"></div>
    <div id="uploadMessage"></div>
</div>
            
        </div>
</body>
</html>
