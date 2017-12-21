<?php
namespace Core\Endpoint\Test\ToDo\Index\Index;

// TODO: make this controller 'access denied' on live website

use Core\Page\EndpointControlling\AbstractController;

class Controller extends AbstractController
{

    public function execute()
    {
        $files = $this->scanCdir();

        echo "Files Controller:<br><br>";

        foreach ($files as $file)
        {
            $content = file_get_contents($file);
            if ($pos = stripos($content, 'todo', 0))
            {
                echo $file . "<br>";
                $shorten = substr($content, 0, $pos);
                echo "Line: " . substr_count($shorten, "\n") . "<br><br>";
            }
        }
    }

    private function scanCdir($dir = null)
    {
        $ret = [];

        if (is_null($dir))
        {
            $dir = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
        }

        foreach ($this->scandir($dir) as $scanned)
        {
            $scanned = "$dir\\$scanned";

            if (is_file($scanned))
            {
                $ret[] = $scanned;
            }
            elseif (is_dir($scanned))
            {
                $res = $this->scanCdir($scanned);
                $ret = array_merge($ret, $res);
            }
        }

        return $ret;
    }


    private function scandir($dir)
    {
        $scanned = scandir($dir);

        foreach ($scanned as $key => $found)
        {
            if ($found === '.' || $found === '..')
            {
                unset($scanned[$key]);
            }
        }

        return $scanned;
    }

}
