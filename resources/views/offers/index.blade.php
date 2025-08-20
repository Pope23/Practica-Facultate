
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Oferte salvate</h1>
        <a href="{{ route('offers.create') }}" class="btn btn-success mb-3">Ofertă nouă</a>
        <ul class="list-group">
            @foreach($offers as $offer)
                <li class="list-group-item">
                    <a href="{{ route('offers.show', $offer->id) }}">
                        {{ $offer->business_name }} - {{ $offer->created_at->format('d/m/Y H:i') }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
