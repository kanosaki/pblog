<?php
require 'lib/common.php';
?>

<!doctype html>
<html>
    <head><title>Scratch</title></head>
    <body>
<?php
var_dump(root_url());
echo '<br />';
var_dump(absolute_url("actions/twitter-callback.php"));

?>
    </body>
</html>
