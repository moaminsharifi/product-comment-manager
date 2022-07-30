<?php

namespace App\Services;

class KeyValueYMLStyleWarehouse extends BaseWarehouse
{
    protected function runCommand($command)
    {
        $output = null;
        $retval = null;
        exec($command, $output, $retval);

        return $output;
    }

    /**
     * increment.
     *
     * @param string $key
     * @return void
     */
    public function increment(string $key, $filePath = false)
    {
        if (!$filePath) {
            $filePath = config('warehouse.connections.yml.path');
        }
       
        $command = "grep {$key} {$filePath}";
        $output = $this->runCommand($command);
        $existInFile = count($output) ? true : false;

        if ($existInFile) {
            // get oldValue
            $valuesInFile = explode(':', $output[0]);
            $oldValue = (int) $valuesInFile[1];
            $newValue = $oldValue + 1;
            
            $command = sprintf("sed -ir 's/^[#]*\s*%s: .*/%s: %u/' %s", $key, $key, $newValue, $filePath);     
            $output = $this->runCommand($command);
            
        } else {
            $command = "echo '{$key}: 1' >> {$filePath}";
            $output = $this->runCommand($command);
        }
    }

    /**
     * get specific key.
     *
     * @param string $key
     * @return value
     */
    public function get(string $key, $filePath = false)
    {
        if (!$filePath) {
            $filePath = storage_path(config('warehouse.connections.yml.path'));
        }
        try {
            $command = sprintf('sed -rn "s/^%s: ([^\n]+)$/\1/p" %s', $key, $filePath);
            $output = $this->runCommand($command);

            return  $output[0];
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
