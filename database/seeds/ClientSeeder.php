<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::first() ?? factory(User::class)->create();
        factory(Client::class, 150)->create([
//            'user_id' => $user->id,
        ]);
        $users = User::all();
        foreach ($users as $user) {
            $numberOfClients = rand(0, 5);
            factory(Client::class, $numberOfClients)->create([
                 'user_id' => $user->id,
            ]);
        }

    }
}
