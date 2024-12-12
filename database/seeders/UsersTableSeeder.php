<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();
        $admin = User::create([
            'uuid' => (string)Str::uuid(),
            'user_creator_id' => 1,
            'name' => 'LATE',
            'firstname' => 'Edem',
            'birthdate' =>'09/09/1989',
            'phone' => '45123256',
            'image' =>NULL,
            'sexe' =>'masculin',
            'online' =>'oui',
            'email' => 'late@late.com',
            'worked' => '1',
            'signature' => NULL,
            'password' => Hash::make('password')
        ]);

        $caissier = User::create([
            'uuid' => (string)Str::uuid(),
            'user_creator_id' => 1,
            'name' => 'KABRE',
            'firstname' => 'Simplice',
            'birthdate' =>'09/09/1999',
            'phone' => '969696969',
            'image' => NULL,
            'sexe' => 'masculin',
            'online' =>'non',
            'email' => 'kabre@kabre.com',
            'worked' => '1',
            'signature' => NULL,
            'password' => Hash::make('password')
        ]);

        $magasinier = User::create([
            'uuid' => (string)Str::uuid(),
            'user_creator_id' => 1,
            'name' => 'KABORE',
            'firstname' => 'Augustine',
            'birthdate' =>'09/09/1989',
            'phone' => '23524163',
            'image' => NULL,
            'sexe' => 'feminin',
            'online' => 'non',
            'email' => 'kabore@kabore.com',
            'worked' => '1',
            'signature' => NULL,
            'password' => Hash::make('password')
        ]);

        $controlleur = User::create([
            'uuid' => (string)Str::uuid(),
            'user_creator_id' => 1,
            'name' => 'SAWADOGO',
            'firstname' => 'Augustin',
            'birthdate' =>'09/09/1989',
            'phone' => '23524163',
            'image' => NULL,
            'sexe' => 'feminin',
            'online' => 'non',
            'email' => 'sawadogo@sawadogo.com',
            'worked' => '1',
            'signature' => NULL,
            'password' => Hash::make('password')
        ]);

        $adminRole = Role::where('name','admin')->first();
        $magasinierRole = Role::where('name','magasinier')->first();
        $caissierRole = Role::where('name','Caissier')->first();
        $controlleurRole = Role::where('name','Contrôlleur')->first();

        $admin->roles()->attach($adminRole);
        $magasinier->roles()->attach($magasinierRole);
        $caissier->roles()->attach($caissierRole);
        $controlleur->roles()->attach($controlleurRole);
    }
}
