<?php

# Setting Up Connection
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'geographic');

# Connect
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
