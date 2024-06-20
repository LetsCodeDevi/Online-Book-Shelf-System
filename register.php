<!DOCTYPE html>
<html>
    <head>
        <title>Travel Safe Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">  <!--link that have the css file-->
    <style>
        body#Registerbody{
    background: url('images/bgimg.jpeg'); 
    background-repeat: no-repeat;
    background-size: 100% 100%;
    height: 500px;
}

div.registerHeader{
    text-align: center;
}

div.Registerbody form{
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
  
  $("#regbtn").click(function(event){
    event.preventDefault();
    //console.log("event triggered");

    var name = $("#name").val();
    var username = $("#username").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var password = $("#password").val();

    $.ajax({
        url: 'save_user.php', // URL of the server-side script
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            username: username,
            email: email,
            phone: phone,
            password: password
              },
        success: function(response) {
            // Handle the response from the server
            alert('User data saved successfully!');
            window.location.href = "login.php";
        },
        error: function(xhr, status, error) {
            // Handle any errors
            console.error(error);
            alert('An error occurred while saving the data.');
        }
        });
    });
 
        
    });

</script>

   
    </head>
    <body id="Registerbody">
        <div class="register_header">
            <button id="back">Back</button>
        </div>
        <div class="container">
            <div class="registerHeader">
                <h1>TSMS</h1>
                <h3>Travel Safe Management System</h3>
            </div>
            
            <div class="Registerbody">
                <form id="regform" onsubmit="return false" >
                    <div>
                        <label for=" ">Name</label>
                        <input type="text" id="name" value="" name="name" />
                    </div>
                    <div>
                        <label for=" ">Username</label>
                        <input type="text" id="username" name="username" />
                    </div>
                    <div>
                        <label for=" ">Email</label>
                        <input type="text" id="email" value="" name="email" />
                    </div>
                    <div>
                        <label for=" ">Contact</label>
                        <input type="text" id="phone" name="phone" />
                    </div>
                    <div>
                        <label for=" ">Password</label>
                        <input type="password" id="password" name="password" />
                    </div>
                    <div class="Registerbuttoncontainer">
                    <input id="regbtn" type="submit" name="submit">
                    </div>
                </form>
 
            </div>
        </div>

    </body>
</html>