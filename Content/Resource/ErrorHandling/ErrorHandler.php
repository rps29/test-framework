<?php
namespace Content\Resource\ErrorHandling;

// TODO: Content\Resource\ErrorHandler
// any way: log error
// Developer: Display error
// Live: Send email to admin and display message with generated error code

class ErrorHandler
{

    function errorHandler($code, $message, $file, $line)
    {
        echo "<b>Code:</b> $code<br>";
        echo "<b>Message:</b> $message<br>";
        echo "<b>File:</b> $file<br>";
        echo "<b>Line:</b> $line<br>";
    }

}
