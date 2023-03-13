<?php

use App\Models\Client;
use App\Models\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $numberOfJournals = rand(0, 5);
            factory(Journal::class, $numberOfJournals)->create([
                 'client_id' => $client->id,
            ]);
        }

    }
}
