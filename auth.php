<?php

function isAuthenticated() {
    if (isset($_SESSION['user_email'])) {
        echo $_SESSION['user_email'];
        return true;
    } else {
        echo $_SESSION['user_email'];
        return false;
    }
}

?>