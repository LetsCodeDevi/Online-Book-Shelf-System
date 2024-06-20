<?php
session_start();
if (isset($_POST['loggedin']) && $_POST['loggedin'] === 'true') {
    $_SESSION['loggedin'] = true;
}
?>
