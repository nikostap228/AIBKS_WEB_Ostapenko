<?php
setcookie("User", "", time() - 3600);

header("Location: /index.php");
exit();
?>