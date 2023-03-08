<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientCreateRequest;
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
            ->with('bookings', function ($booking){
                $booking->orderBy('start','desc');
            })
            ->firstOrFail();

        return view('clients.show', ['client' => $client]);
    }

    public function store(ClientCreateRequest $clientCreateRequest)
    {
//      Improvements: Can use a repository and send the required values there to store the data.
        $clientData = $clientCreateRequest->only('name', 'email', 'phone', 'address', 'city', 'postcode');
        $clientData['user_id'] = $clientCreateRequest->user()->id;
        $client = Client::create($clientData);
        return $client;
    }

    public function destroy(Request $request, $clientId)
    {
        $isDeleted = Client::where('id', $clientId)
            ->where('user_id', $request->user()->id)
            ->delete();
        if ($isDeleted) {
            return response()->json(['message' => 'Deleted', 'client_id' => $clientId], 200);
        } else {
            return response()->json(['message' => 'Failed'], 404);
        }
    }
}
