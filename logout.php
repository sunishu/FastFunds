<?php
session_start();
session_destroy();


echo "<b><form action='login.html' method='POST'>";
echo "<h4>Successfully logged out!</h4>";
echo "<button type='submit' value='submit'  style='width: 300px; margin: 0 auto;''>Login Again</b></button></form>";
?>