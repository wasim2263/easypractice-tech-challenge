<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
//      Eager loading: it will make only 2 queries when the previous one used to make n+1 queries.
        $clients = $request->user()->clients()->with('bookings')->withCount('bookings')->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Request $request, $clientId)
    {
        $client = Client::where('id', $clientId)
            ->where('user_id', $request->user()->id)
            ->with('bookings')
            ->firstOrFail();

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy(Request $request, $clientId)
    {
        $isDeleted = Client::where('id', $clientId)
            ->where('user_id', $request->user()->id)
            ->delete();
        if ($isDeleted) {
            return response()->json(['message' => 'Deleted', 'client_id'=>$clientId], 200);
        } else {
            return response()->json(['message' => 'Failed'], 404);
        }
    }
}
