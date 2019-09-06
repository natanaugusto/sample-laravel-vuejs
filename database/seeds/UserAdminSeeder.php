<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $user = new User();
    $user->name = 'Administrador';
    $user->email = 'admin@mail.com';
    $user->password = Hash::make('qwerty');
    $user->save();

    $user->assignRole('admin');
  }
}
