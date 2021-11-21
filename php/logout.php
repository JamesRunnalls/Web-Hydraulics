<?php
session_start();
session_destroy();
echo('<script>sessionStorage.clear();</script>');
echo('<script>window.location="../index.php"</script>');
?>