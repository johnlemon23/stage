<?php
if(isset($_GET["communes"])){
        $communes_str = $_GET["communes"];
        $communes = explode(',', $communes_str);
    } else {
        $communes = array($_GET["communes"]);
}
?>