<?php
 session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Travel Safe Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">  <!--link that have the css file-->
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
    </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!--  <script src="my_jquery_functions.js"></script> jQuery functions can be in a seperate js file which is added here-->

<script>
$(document).ready(function(){
  $("#back").click(function(event){
    event.preventDefault();
    window.location.href = "openpage.php";
  });

  $("#logbtn").click(function(event){
    event.preventDefault();

    var username = $("#username").val();
    var password = $("#password").val();

    $.ajax({
        url: 'verify_user.php', // URL of the server-side script
        type: 'POST',
        dataType: 'json',
        data: {
            username: username,
            password: password
              },
        success: function(response) {
            // Handle the response from the server
            if (response.status === 'success') {
                           // Set the session variable via an AJAX call to a PHP script
                        $.ajax({
                            url: 'set_session.php',
                            type: 'POST',
                            data: { loggedin: true },
                            success: function() {
                                // Redirect to the homepage after successful login
                                window.location.href = "homepage.php";
                            }
                        });
                    }
            else {
                alert(response.message);
                }
        },
        error: function(xhr, status, error) {
            // Handle any errors
            console.error(error);
            alert('An error occurred while logging in.');
        }
        });

});
});

</script>

        
    </head>
    <body id="loginbody">
        <div class="login_header">
            <button id="back">Back</button>
        </div>
        <div class="container">
            <div class="loginHeader">
                <h1>TSMS</h1>
                <h3>Travel Safe Management System</h3>
            </div>
            <h2>Login</h2>
    <?php
  #  if (isset($_SESSION['error'])) {
   #     echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    #    unset($_SESSION['error']);
   # }
    ?>
            
            <div class="loginbody">
                <form id="login_form" onsubmit="return false" >
                    <div>
                        <label for=" ">Name</label>
                        <input type="text" id="username" name="username" />
                    </div>
                    <div>
                        <label for=" ">Password</label>
                        <input type="password" id="password" name="password" />
                    </div>
                    <div class="loginbuttoncontainer">
                    <input id="logbtn" type="submit" name="submit">
                    </div>
                </form>
 
            </div>
        </div>

    </body>




</html>