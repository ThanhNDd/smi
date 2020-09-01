<?php
function myErrorHandler($errstr) {
    echo $errstr;
}
set_error_handler("myErrorHandler");