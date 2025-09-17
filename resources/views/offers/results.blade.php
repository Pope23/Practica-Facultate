@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Rezultatele Ofertelor RCA</h1>

        <div class="row">
            @foreach($offers as $offer)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ ucfirst($offer->insurer) }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Bonus-Malus:</strong> {{ $offer->bonus_malus }}</p>
                            <p><strong>Excluderi carte verde:</strong> {{ $offer->green_card_exclusions }}</p>
                            <p><strong>Cost total asigurare:</strong> {{ number_format($offer->premium_amount, 2) }} RON</p>
                            <p><strong>Cost net asigurare:</strong> {{ number_format($offer->premium_amount_net, 2) }} RON</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-info btn-sm">Detalii</a>
                            <a href="{{ route('offers.pdf', $offer->id) }}" class="btn btn-outline-primary btn-sm">Descarcă PDF</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            <a href="{{ route('offers.create') }}" class="btn btn-primary">Ofertă nouă</a>
            <a href="{{ route('offers.index') }}" class="btn btn-secondary">Vezi istoric</a>
        </div>
    </div>
@endsection
