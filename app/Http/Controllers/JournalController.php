<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalCreateRequest;
use App\Models\Client;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function create(Request $request, Client $client)
    {
        return view('journals.create', compact('client'));
    }

    public function store(JournalCreateRequest $request, Client $client)
    {
        $journalData = $request->only('date', 'text');
        $journalData['client_id'] = $client->id;
        $journal = null;

        if($client->user_id == $request->user()->id){
            $journal = Journal::create($journalData);
        }

        if ($journal) {
            return response()->json(['message' => 'Created', 'url' => route('clients.show', ['client'=>$client->id])], 200);
        } else {
            return response()->json(['message' => 'Failed'], 422);
        }

    }

    public function destroy(Request $request, $clientId, $journalId)
    {
        $isDeleted = Journal::join('clients', 'clients.id', '=', 'journals.client_id')
            ->where('client_id', $clientId)
            ->where('clients.user_id', $request->user()->id)
            ->where('journals.id', $journalId)
            ->forceDelete();
        if ($isDeleted) {
            return response()->json(['message' => 'Deleted', 'journal_id' => $journalId], 200);
        } else {
            return response()->json(['message' => 'Failed'], 404);
        }
    }
}
