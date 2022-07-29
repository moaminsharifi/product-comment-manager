<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
class JsonWarehouse extends BaseWarehouse
{
    /**
     * Read File as json
     *
     * @return array
     */
    protected function readFile()
    {
        try {
            $jsonData = json_decode(Storage::get(config('warehouse.connections.json.path')), true);
        } catch (\Throwable $th) {
            Storage::put(config('warehouse.connections.json.path'), '{}');
        }
        return $jsonData;
    }
    /**
     * increment key in database.
     *
     * @param string $key
     * @return void
     */
    public function increment(string $key)
    {
        $jsonData = $this->readFile();
        $jsonData[$key] = array_key_exists($key , $jsonData)? $jsonData[$key] + 1 : 0; 
        
        try {
            Storage::put(config('warehouse.connections.json.path'), json_encode($jsonData));
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        

    }
    /**
     * Get key
     *
     * @param string $key
     * @return void
     */
    public function get(string $key){

        $jsonData = $this->readFile();
        return array_key_exists($key , $jsonData)? $jsonData[$key]  : '';
    }


}
