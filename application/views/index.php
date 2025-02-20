<?php


if (!isset($_SESSION['email'])) {
    header("location:".base_url()."logincontroller");
    exit;
}
else{
    header("location:".base_url()."pagescontroller");
    exit;
}


?>