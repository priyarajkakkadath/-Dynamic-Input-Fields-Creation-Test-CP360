<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HTMLFields;
use Illuminate\Support\Facades\DB;

class htmlFieldsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      HTMLFields::truncate();
      $data = [
        [
            'type' => 'Text',
            'multiple_options' => '0'
        ],[
            'type' => 'Number',
            'multiple_options' => '0'
        ],[
            'type' => 'Dropdown',
            'multiple_options' => '1'
        ]
    ];

    HTMLFields::insert($data);

    }
}
