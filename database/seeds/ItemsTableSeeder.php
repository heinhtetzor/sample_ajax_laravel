<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'name' => 'iPhone',
            'category_id' => '1',
            'price'=>'1000',
            'quantity'=>'0' 
         
        ]);
        DB::table('items')->insert([
            'name' => 'Galaxy Phones',
            'category_id' => '1',
             'price'=>'900',
            'quantity'=>'0' 
       
        ]);
        DB::table('items')->insert([
            'name' => 'XBox',
            'category_id' => '1',
             'price'=>'650',
            'quantity'=>'0' 
     
        ]);

        DB::table('items')->insert([
            'name' => 'Chairs',
            'category_id' => '2',
             'price'=>'300',
            'quantity'=>'0' 
        
        ]);
        DB::table('items')->insert([
            'name' => 'Bed',
            'category_id' => '2',
             'price'=>'4500',
            'quantity'=>'0' 
        ]);
        DB::table('items')->insert([
            'name' => 'Toothpaste',
            'category_id' => '2',
             'price'=>'50',
            'quantity'=>'0' 
        ]);
    }
}
