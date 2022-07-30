<?php

namespace Tests\Feature\Warehouse;

use App\Services\KeyValueYMLStyleWarehouse;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KeyValueYMLStyleTest extends TestCase
{
    /**
     * add multi value to warehouse test.
     * @test
     * @group Feature
     * @group Warehouse
     * @return void
     */
    public function add_multi_value_to_warehouse()
    {
        $warehouse = new KeyValueYMLStyleWarehouse();
        $disk = 'warehouses';
        $filePath = 'warehouse.yml';
        Storage::fake($disk);
        Storage::disk($disk)->put($filePath, '');
        Storage::disk($disk)->assertExists($filePath);
        $fileFullPath = Storage::disk($disk)->path($filePath);
        $warehouse->increment('A', $fileFullPath);

        $fileContent = Storage::disk($disk)->get($filePath);
        $this->assertTrue(str_contains($fileContent, 'A: 1'));

        $warehouse->increment('A', $fileFullPath);
        $fileContent = Storage::disk($disk)->get($filePath);

        $this->assertTrue(str_contains($fileContent, 'A: 2'));

        // Add other key
        $warehouse->increment('B', $fileFullPath);
        $fileContent = Storage::disk($disk)->get($filePath);
        $this->assertTrue(str_contains($fileContent, 'B: 1'));

        $warehouse->increment('B', $fileFullPath);
        $fileContent = Storage::disk($disk)->get($filePath);
        $this->assertTrue(str_contains($fileContent, 'B: 2'));
    }

    /**
     * get value from warehouse test.
     * @test
     * @group Feature
     * @group Warehouse
     * @return void
     */
    public function get_value_from_warehouse()
    {
        $warehouse = new KeyValueYMLStyleWarehouse();
        $disk = 'warehouses';
        $filePath = 'warehouse2.yml';
        Storage::fake($disk);
        Storage::disk($disk)->put($filePath, '');
        Storage::disk($disk)->assertExists($filePath);
        $fileFullPath = Storage::disk($disk)->path($filePath);
        $warehouse->increment('A', $fileFullPath);

        $fileContent = Storage::disk($disk)->get($filePath);
        $this->assertTrue(str_contains($fileContent, 'A: 1'));

        $output = $warehouse->get('A', $fileFullPath);
        $this->assertEquals(1, $output);
    }
}
