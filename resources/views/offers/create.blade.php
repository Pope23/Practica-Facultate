@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Creează ofertă RCA</h1>
        <form method="POST" action="{{ route('offers.store') }}">
            @csrf

            <h4>Date Asigurat</h4>
            <div class="row mb-3">
                <div class="col">
                    <label>Prenume</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col">
                    <label>Nume</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label>CNP</label>
                <input type="text" name="cnp" class="form-control" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label>Telefon</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Adresă</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <h4>Date Vehicul</h4>
            <div class="row mb-3">
                <div class="col">
                    <label>Număr înmatriculare</label>
                    <input type="text" name="license_plate" class="form-control" required>
                </div>
                <div class="col">
                    <label>Marca</label>
                    <input type="text" name="brand" class="form-control" required>
                </div>
                <div class="col">
                    <label>Model</label>
                    <input type="text" name="model" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label>An fabricație</label>
                    <input type="number" name="year" class="form-control" required>
                </div>
                <div class="col">
                    <label>Putere (CP)</label>
                    <input type="number" name="engine_power" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label>Combustibil</label>
                <select name="fuel_type" class="form-control">
                    <option value="benzina">Benzină</option>
                    <option value="diesel">Diesel</option>
                    <option value="electric">Electric</option>
                    <option value="hibrid">Hibrid</option>
                </select>
            </div>

            <h4>Detalii ofertă</h4>
            <div class="mb-3">
                <label>Business Name (Asigurator)</label>
                <input type="text" name="business_name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Generează ofertă</button>
        </form>
    </div>
@endsection

