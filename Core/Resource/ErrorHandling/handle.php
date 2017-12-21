<?php
// TODO: activate custom error handler again
set_error_handler('errorHandler');

register_shutdown_function('fatalErrorShutdownHandler');

// TODO: ErrorHandler

/**
 * Custom error handling
 */
function errorHandler($code, $message, $file, $line)
{
    try
    {
        $handler = new \Core\Resource\ErrorHandling\ErrorHandler();
        $handler->errorHandler($code, $message, $file, $line);
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
}


/**
 * Last call on fatal error
 */
function fatalErrorShutdownHandler()
{
    $last_error = error_get_last();

    if ($last_error['type'] === E_ERROR)
    {
        errorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
    }
}
