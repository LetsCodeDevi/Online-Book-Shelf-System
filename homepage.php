<?php 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: openpage.php");
    exit;
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Travel Safe Home Page</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">  <!--link that have the css file-->
        <script src="https://kit.fontawesome.com/e88bbb46b5.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            body#loginbody{
    background: url('images/bgimg.jpeg'); 
    background-repeat: no-repeat;
    background-size: 100% 100%;
    height: 500px;
}

div.loginHeader{
    text-align: center;
}

div.loginbody form{
    margin: 0 auto;
    width: 200px;
    
}
div.loginbuttoncontainer{
    margin-top: 20px;
    
}

div.header{
    width: 100%;
    
    background: burlywood;
    padding: 20px 0px;
    text-align: right;
}


div.header a{
    font-size: 20px;
    color: #040000;
    border: 2px solid #000000;
    padding: 5px 10px;
    
    
}
.btn-group {
            float: left; /* Float button group to the left */
            
            border: 1px solid black;
            
}

.menu {
            float: left; /* Float button group to the left */
            
            border: 1px solid black;
            
}


div.banner{
    background: url('images/homebg.avif');
    background-repeat: no-repeat;
    background-size: 100% 100%;
    height: 600px;
}
div.homepagecontainer{
    text-align: center;
    width: 100%;
    max-width: 900px;
    margin: 0 auto;

}

div.homepagefeatures{
    display: flex;
    flex-direction: row;
}
    
div.homepagenotified{
    display:flex;
    flex-direction: row;
    
}

.dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
        }

        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }

        .dropdown-submenu:hover > a:after {
            border-left-color: #fff;
        }

        .dropdown-submenu.pull-left {
            float: none;
        }

        .dropdown-submenu.pull-left > .dropdown-menu {
            left: -100%;
            margin-left: 10px;
        }
        .file-input-wrapper {
            position: relative;
        }

        .remove-file {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            display: none;
        }
        .uploaded-files {
            margin-top: 20px;
        }

        .uploaded-file {
            margin-bottom: 10px;
        }
        </style>
    </head>



    <body>
        <div class="header">
            <a href="logout.php">Log Out</a>
            <div class="btn-group">
    <button type="button" class="btn btn-dark " data-bs-toggle="dropdown">
    <i class="fa-solid fa-bars"></i>
    </button>
    <ul class="dropdown-menu">
        <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#">Settings</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" id="changePasswordBtn">Change Password</a></li>
                <li><a class="dropdown-item" href="#">Reading Status</a></li>
            </ul>
        </li>
        <li><a class="dropdown-item" href="#" id="profileBtn">Profile</a></li>
        <li><a class="dropdown-item" href="#" id="read_click">Read</a></li> <!-- Opens in same tab -->
        <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#">My Library</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" id="add_book" href="#">Add Book</a></li>
                <li><a class="dropdown-item" href="#">Search Book</a></li>
            </ul>
        </li>
    </ul>
</div>

<!-- Hidden form for file upload -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadModalLabel">Upload PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="fileUploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 file-input-wrapper">
                <label for="fileInput" class="form-label">Choose PDF file</label>
                <input class="form-control" type="file" id="fileInput" name="file" accept="application/pdf">
                <span class="remove-file">&times;</span>
            </div>
            <button type="button" class="btn btn-primary" id="uploadBtn">Upload</button>
        </form>
        <div id="uploadMessage" class="mt-3"></div>
      </div>
    </div>
  </div>
</div>

<!-- Add this modal structure for the profile -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="profileForm">
                        <div class="mb-3">
                            <label for="profileName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="profileName" name="name" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="profileUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="profileUsername" name="username" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="profileEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="profileEmail" name="email" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="profilePhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="profilePhone" name="phone" disabled>
                        </div>
                        <button type="button" id="editProfileBtn" class="btn btn-primary">Edit</button>
                        <button type="button" id="saveProfileBtn" class="btn btn-success" style="display:none;">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password modal structure -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                        </div>
                        <button type="button" id="changePasswordBtn" class="btn btn-success">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        $("#profileBtn").on("click", function(e) {
            e.preventDefault();
            $.ajax({
                url: 'get_profile.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        $('#profileName').val(response.Name);
                        $('#profileUsername').val(response.Username);
                        $('#profileEmail').val(response.Email);
                        $('#profilePhone').val(response.Contact);
                        $('#profileModal').modal('show');
                    } else {
                        alert('Failed to fetch profile information.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while fetching the profile.');
                }
            });
        });

        $("#editProfileBtn").on("click", function() {
            $("#profileForm input").prop("disabled", false);
            $(this).hide();
            $("#saveProfileBtn").show();
        });

        $("#saveProfileBtn").on("click", function() {
            var formData = $("#profileForm").serialize();
            $.ajax({
                url: 'update_profile.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Profile updated successfully!');
                        $("#profileForm input").prop("disabled", true);
                        $("#editProfileBtn").show();
                        $("#saveProfileBtn").hide();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while updating the profile.');
                }
            });
        });

        // Change Password Modal
        $("#changePasswordBtn").on("click", function(e) {
            e.preventDefault();
            $("#changePasswordModal").modal('show');
        });

        $("#changePasswordForm #changePasswordBtn").on("click", function() {
            var formData = $("#changePasswordForm").serialize();
            $.ajax({
                url: 'change_password.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Password changed successfully!');
                        $("#changePasswordModal").modal('hide');
                        $("#changePasswordForm")[0].reset();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while changing the password.');
                }
            });
        });
    });
    </script>

<script>   
    $(document).ready(function() {
        $("#add_book").on("click", function(e) {
            e.preventDefault();
            $("#uploadModal").modal('show');
        });
        $('#fileInput').on('change', function() {
            if (this.files.length > 0) {
                $('.remove-file').show();
            }
        });

        $('.remove-file').on('click', function() {
            $('#fileInput').val('');
            $(this).hide();
        });
        $('#uploadBtn').on('click', function() {
    var formData = new FormData();
    formData.append('file', $('#fileInput')[0].files[0]);

            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
        $('#uploadMessage').html('<div class="alert alert-' + response.status + '">' + response.message + '</div>');
        if (response.status === 'success') {
          // Optional: Perform any additional actions after successful upload
          $('#fileInput').val(''); // Clear file input
          $('.remove-file').hide(); // Hide remove file button
        }
      },
                error: function(xhr, status, error) {
                    $('#uploadMessage').html('<div class="alert alert-danger">An error occurred: ' + xhr.responseText + '</div>');
                }
            });
        });

        $("#read_click").click(function(event){
    event.preventDefault();
    window.location.href = "read.php";
  });

       
});
</script>
        <div class="banner">
            <div class="homepagecontainer">              
                <div class="bannerheader">
                    <h1>BSMS</h1>
                    <h3> Welcome <?php echo htmlspecialchars($username); ?></h3>
                
                    <p><h2>Online Book Shelf Management System</h2></p>
                </div>
                <p class="bannertagline">
                    Read Books Online and live your world of Joy..
                </p>
                <div class="bannericons">
                   <a href=""><i class="fa fa-android"></i></a>
                   <a href=""><i class="fa-brands fa-apple"></i></a>
                   <a href=""><i class="fa-brands fa-windows"></i></a>
                </div>
            </div>
            
        </div>
        <div class="homepagecontainer">
            <div class="homepagefeatures">
                <div class="homepagefeature">
                    <span><i class="fa-solid fa-gear"></i></span>
                    <h3>Suggestions</h3>
                    <p>Looking for great books to read? Dive into classics by Jane Austen or Charles Dickens for timeless tales, 
                        or explore contemporary works by Haruki Murakami and Chimamanda Ngozi Adichie for fresh perspectives. 
                        Whether you crave adventure, romance, or deep insights, there's a book out there ready to captivate your imagination.</p>
                </div>
                <div class="homepagefeature">
                    <span><i class="fa-solid fa-star"></i></span>
                    <h3>Free Download</h3>
                    <p>For downloading books in PDF format, Project Gutenberg offers over 60,000 free eBooks, including many classics. 
                        Google Books and Open Library provide access to a vast collection of digitized books, ideal for academic and research 
                        purposes. ManyBooks is great for a wide range of genres, while BookBoon offers free textbooks and business books. 
                        </p>
                </div>
                <div class="homepagefeature">
                    <span><i class="fa-solid fa-globe"></i></span>
                    <h3>Publish Your Books</h3>
                    <p>There are several platforms where authors can publish their books independently and reach a global audience. 
                        Amazon Kindle Direct Publishing (KDP) allows authors to self-publish eBooks and paperbacks easily, providing access 
                        to millions of readers on Amazon. Smashwords offers distribution to major eBook retailers like Apple Books and Barnes & 
                        Noble.  </p>
                </div>
            </div>
            <div class="homepagenotified">
    <div class="video">
        <iframe src="https://www.youtube.com/embed/9wpEnM5JR3I" width="300" height="300" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

            

        </div>
      
    </body>
</html>