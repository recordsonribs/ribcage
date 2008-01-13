<?php
echo "<html><head><title>Success</title></head><body><h3>Thank you for your order.</h3>";
foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
echo "</body></html>";
?>