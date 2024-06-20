<!DOCTYPE html>
<html>
    <head>
        <title>Travel Safe Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">  <!--link that have the css file-->
    <style>
        body#openbody{
    background: url('images/bgimg.jpeg'); 
    background-repeat: no-repeat;
    background-size: 100% 100%;
    height: 500px;
    text-align: center;
}

div.openHeader{
    text-align: center;
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
    </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!--  <script src="my_jquery_functions.js"></script> jQuery functions can be in a seperate js file which is added here-->

<script>
$(document).ready(function(){
  $("#btn_reg").click(function(event){
    event.preventDefault();
    window.location.href = "register.php";
  });
  $("#btn_log").click(function(event){
    event.preventDefault();
    window.location.href = "login.php";
  });
});

</script>

        
    </head>
    <body id="openbody">
        <div class="container">
            <div class="openHeader">
                <h1>TSMS</h1>
                <h3>Travel Safe Management System</h3>
            </div>
            <br><br><br>
            
            <div class="openbody">
                    <div id="reg">
                        <form method="post" action="register.php">
                        <p>Are you new to TSMS? Please Register</p>
                        <input  type="submit">Register</input>
                        </form>
                    </div>
                    <div id="log">
                    <form method="post" action="login.php">
                        <p>Login if already Registered</p>
                        <input id="btn_log" type="submit">Login</input>
                        </form>
                    </div>
 
            </div>
        </div>

    </body>
</html>