<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;

use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create([
            'uuid' => (string)Str::uuid(),
            'name'=>'admin',
            'description' =>'compte administrateur'
        ]);


        Role::create([
            'uuid' => (string)Str::uuid(),
            'name' => 'Pharmacien',
            'description' => 'compte pharmacien'
        ]);

        Role::create([
            'uuid' => (string)Str::uuid(),
            'name' => 'Caissier',
            'description' => 'compte caissier'
        ]); 
        Role::create([
            'uuid' => (string)Str::uuid(),
            'name' => 'Contrôlleur',
            'description' => 'compte contrôlleur'
        ]); 
        
     

    }
}
