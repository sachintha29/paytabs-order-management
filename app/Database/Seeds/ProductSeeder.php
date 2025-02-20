<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Ballpoint Pen', 'price' => 50.00],
            ['name' => 'Notebook', 'price' => 30.00],
            ['name' => 'Marker', 'price' => 20.00],
            ['name' => 'Eraser', 'price' => 10.00],
            ['name' => 'Pencil', 'price' => 15.00],
        ];
        $this->db->table('products')->insertBatch($data);
    }
}
