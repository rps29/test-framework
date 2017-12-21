<?php
namespace Core\Resource\Helper\GlobalHelper\Logger;

class ErrorLogger
{

    /**
     * @const logging directory
     */
    const LOG_DIR = 'log/';

    /**
     * @const where to put logged messages by default, if no custom file is given
     */
    const LOG_DEFAULT_FILE = 'error.log';

    /**
     * @return bool true on success, false on failure
     */
    public function log(string $message, string $file = self::LOG_DEFAULT_FILE)
    {
        $logFile = self::LOG_DIR . $file;
        if (substr($message, -1) !== "\n") {
            $message .= "\n";
        }

        // TODO: Create a DateFormatHelper, with lots of functions that provide date pre formatting.
        $message = date("d-n-o H:i:s") . " " . $message;

        return error_log($message, 3, $logFile);
    }

}
