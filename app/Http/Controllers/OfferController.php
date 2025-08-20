<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class OfferController extends Controller
{
    public function index()
    {
        // listă oferte salvate
        $offers = Offer::latest()->get();
        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        // formular pentru o ofertă nouă
        return view('offers.create');
    }

    public function store(Request $request)
    {
        // validăm câteva câmpuri de bază
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'cnp' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'license_plate' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'engine_power' => 'nullable|integer',
            'fuel_type' => 'nullable|string',
            'business_name' => 'required|string',
        ]);

        // construim payload-ul JSON (simplificat, îl poți extinde)
        $payload = [
            "businessName" => $validated['business_name'],
            "policyholder" => [
                "firstName" => $validated['first_name'],
                "lastName" => $validated['last_name'],
                "taxId" => $validated['cnp'],
                "email" => $validated['email'],
                "mobileNumber" => $validated['phone'],
                "address" => $validated['address'],
            ],
            "vehicle" => [
                "licensePlate" => $validated['license_plate'],
                "brand" => $validated['brand'],
                "model" => $validated['model'],
                "yearOfConstruction" => $validated['year'],
                "enginePower" => $request->engine_power,
                "fuelType" => $request->fuel_type,
            ]
        ];

        // apel API extern (pune URL-ul corect aici)
        $response = Http::post('https://rca-qa.api.lifeishard.ro/', $payload);

        // salvăm în DB
        $offer = Offer::create([
            'business_name'   => $validated['business_name'],
            'request_payload' => $payload,
            'response_payload'=> $response->json(),
        ]);

        return redirect()->route('offers.show', $offer->id);
    }

    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        return view('offers.show', compact('offer'));
    }
    public function downloadPdf($id)
    {
        $offer = Offer::findOrFail($id);

        $pdf = Pdf::loadView('offers.pdf', compact('offer'));

        return $pdf->download("oferta_rca_{$offer->id}.pdf");
    }
}

