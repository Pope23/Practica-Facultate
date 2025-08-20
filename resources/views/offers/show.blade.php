@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Rezultatul Ofertei RCA</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm mb-3">
                    <h5 class="text-primary">Detalii ofertă</h5>
                    <p><strong>Furnizor:</strong> {{ $offer->business_name }}</p>
                    <p><strong>Bonus-Malus:</strong> {{ $offer->response_payload['bonusMalus'] ?? '-' }}</p>
                    <p><strong>Excluderi carte verde:</strong> {{ $offer->response_payload['greenCardExclusions'] ?? '-' }}</p>
                    <p><strong>Cost total asigurare:</strong> {{ number_format($offer->response_payload['totalPrice'] ?? 0, 2) }} RON</p>
                    <p><strong>Cost net asigurare:</strong> {{ number_format($offer->response_payload['netPrice'] ?? 0, 2) }} RON</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm mb-3">
                    <h5 class="text-primary">Date asigurat</h5>
                    <p><strong>Nume:</strong> {{ $offer->request_payload['policyholder']['firstName'] }} {{ $offer->request_payload['policyholder']['lastName'] }}</p>
                    <p><strong>CNP:</strong> {{ $offer->request_payload['policyholder']['taxId'] }}</p>
                    <p><strong>Contact:</strong> {{ $offer->request_payload['policyholder']['mobileNumber'] }} | {{ $offer->request_payload['policyholder']['email'] }}</p>
                    <p><strong>Adresă:</strong> {{ $offer->request_payload['policyholder']['address'] }}</p>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('offers.create') }}" class="btn btn-primary">Ofertă nouă</a>
            <a href="{{ route('offers.pdf', $offer->id) }}" class="btn btn-outline-primary">Descarcă PDF</a>
        </div>
    </div>
@endsection

