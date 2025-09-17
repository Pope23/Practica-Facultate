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
        $offers = Offer::latest()->get();
        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'cnp'           => 'required|string',
            'phone'         => 'required|string',
            'email'         => 'required|email',
            'address'       => 'required|string',
            'license_plate' => 'required|string',
            'brand'         => 'required|string',
            'model'         => 'required|string',
            'year'          => 'required|integer',
            'engine_power'  => 'nullable|integer',
            'fuel_type'     => 'nullable|string',
            'start_date'    => 'required|date',
        ]);

        // Lista asiguratorilor
        $insurers = ['allianz', 'asirom', 'axeria', 'generali', 'groupama',
            'hellas_autonom', 'hellas_nextins', 'omniasig', 'grawe',
            'eazy_insure', 'dallbogg'];

        $offers = [];

        foreach ($insurers as $insurer) {
            try {
                $payload = $this->buildPayload($validated, $insurer);
                $response = $this->callInsuranceApi($payload, $insurer);

                if ($response->successful()) {
                    $responseData = $response->json();

                    if (isset($responseData['error']) && !$responseData['error']) {
                        $offer = Offer::create([
                            'insurer' => $insurer,
                            'request_payload' => $payload,
                            'response_payload' => $responseData,
                            'premium_amount' => $responseData['data']['offers'][0]['premiumAmount'] ?? 0,
                            'premium_amount_net' => $responseData['data']['offers'][0]['premiumAmountNet'] ?? 0,
                            'bonus_malus' => $responseData['data']['offers'][0]['bonusMalusClass'] ?? '-',
                            'green_card_exclusions' => $responseData['data']['offers'][0]['greenCardExclusions'] ?? '-',
                        ]);

                        $offers[] = $offer;
                    }
                }
            } catch (\Exception $e) {
                // Loghează eroarea sau gestionează altfel
                continue;
            }
        }

        // Salvează ofertele în sesiune pentru afișare
        session(['latest_offers' => collect($offers)->pluck('id')->toArray()]);

        return redirect()->route('offers.results');
    }

    private function buildPayload($data, $insurer)
    {
        return [
            "provider" => [
                "organization" => [
                    "businessName" => $insurer
                ],
                "authentication" => [
                    "account" => "",
                    "password" => "",
                    "code" => ""
                ]
            ],
            "product" => [
                "motor" => [
                    "startDate" => $data['start_date'],
                    "termTime" => 12,
                    "installmentCount" => 1,
                    "commissionPercentLimit" => 10
                ],
                "policyholder" => [
                    "lastName" => $data['last_name'],
                    "firstName" => $data['first_name'],
                    "isForeignPerson" => false,
                    "taxId" => $data['cnp'],
                    "nationality" => "RO",
                    "citizenship" => "RO",
                    "gender" => "m", // Poți adapta în funcție de CNP
                    "birthdate" => $this->getBirthdateFromCnp($data['cnp']),
                    "email" => $data['email'],
                    "mobileNumber" => $data['phone'],
                    "address" => [
                        "country" => "RO",
                        "county" => "B", // Presupunem București, adaptează
                        "city" => "București",
                        "street" => $data['address'],
                        "houseNumber" => "1", // Adaptează
                    ],
                    "hasDisability" => false,
                    "isRetired" => false
                ],
                "vehicle" => [
                    "owner" => [
                        "lastName" => $data['last_name'],
                        "firstName" => $data['first_name'],
                        "isForeignPerson" => false,
                        "taxId" => $data['cnp'],
                        "nationality" => "RO",
                        "citizenship" => "RO",
                        "gender" => "m",
                        "birthdate" => $this->getBirthdateFromCnp($data['cnp']),
                        "email" => $data['email'],
                        "mobileNumber" => $data['phone'],
                        "address" => [
                            "country" => "RO",
                            "county" => "B",
                            "city" => "București",
                            "street" => $data['address'],
                            "houseNumber" => "1",
                        ]
                    ],
                    "driver" => [
                        [
                            "lastName" => $data['last_name'],
                            "firstName" => $data['first_name'],
                            "taxId" => $data['cnp'],
                            "mobileNumber" => $data['phone']
                        ]
                    ],
                    "licensePlate" => $data['license_plate'],
                    "brand" => $data['brand'],
                    "model" => $data['model'],
                    "yearOfConstruction" => $data['year'],
                    "enginePower" => $data['engine_power'] ?? 0,
                    "fuelType" => $data['fuel_type'] ?? 'benzina',
                    "usageType" => "personal",
                    "currentMileage" => 50000 // Valoare implicită
                ]
            ]
        ];
    }

    private function callInsuranceApi($payload, $insurer)
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . env('API_TOKEN'),
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->post(env('API_URL') . '/Products/getOffer', $payload);
    }

    private function getBirthdateFromCnp($cnp)
    {
        // Implementează logica de extragere a datei de naștere din CNP
        // Aceasta este o implementare simplificată
        $year = substr($cnp, 1, 2);
        $month = substr($cnp, 3, 2);
        $day = substr($cnp, 5, 2);

        return "19{$year}-{$month}-{$day}";
    }

    public function results()
    {
        $offerIds = session('latest_offers', []);
        $offers = Offer::whereIn('id', $offerIds)->get();

        return view('offers.results', compact('offers'));
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

        return $pdf->download("oferta_rca_{$offer->insurer}_{$offer->id}.pdf");
    }
}

