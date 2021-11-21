<?php

$id = $_POST{"sessionStorageID"};
unlink("../json/".$id.".json");
    
?>