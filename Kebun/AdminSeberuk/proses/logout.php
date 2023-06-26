<?php
 session_start();

 $_SESSION = [];

 session_unset();
 session_destroy();

 setcookie('id_cookie','', time() - 86400);


 header("Location: /index");
 exit;

 ?> 