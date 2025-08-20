<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Oferta RCA</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
<h1>Rezultatul Ofertei RCA</h1>

<div class="section">
    <h3>Detalii ofertă</h3>
    <p><span class="label">Furnizor:</span> {{ $offer->business_name }}</p>
    <p><span class="label">Bonus-Malus:</span> {{ $offer->response_payload['bonusMalus'] ?? '-' }}</p>
    <p><span class="label">Excluderi carte verde:</span> {{ $offer->response_payload['greenCardExclusions'] ?? '-' }}</p>
    <p><span class="label">Cost total asigurare:</span> {{ number_format($offer->response_payload['totalPrice'] ?? 0, 2) }} RON</p>
    <p><span class="label">Cost net asigurare:</span> {{ number_format($offer->response_payload['netPrice'] ?? 0, 2) }} RON</p>
</div>

<div class="section">
    <h3>Date asigurat</h3>
    <p><span class="label">Nume:</span> {{ $offer->request_payload['policyholder']['firstName'] }} {{ $offer->request_payload['policyholder']['lastName'] }}</p>
    <p><span class="label">CNP:</span> {{ $offer->request_payload['policyholder']['taxId'] }}</p>
    <p><span class="label">Telefon:</span> {{ $offer->request_payload['policyholder']['mobileNumber'] }}</p>
    <p><span class="label">Email:</span> {{ $offer->request_payload['policyholder']['email'] }}</p>
    <p><span class="label">Adresă:</span> {{ $offer->request_payload['policyholder']['address'] }}</p>
</div>
</body>
</html>

