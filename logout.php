<?php
session_start();
session_destroy();
header("Location: index.php?action=logout_successful");
exit();
