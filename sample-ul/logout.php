<?php
session_start();
session_unset();
session_destroy();
echo "<script>alert('Logged out'); window.location.href='../mainlogin/abcd.php';</script>";
?>
