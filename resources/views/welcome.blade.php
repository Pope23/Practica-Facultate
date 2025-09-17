<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Oferte RCA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .form-section {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .results-container {
            display: none;
        }
        .loader {
            display: none;
            text-align: center;
            padding: 30px;
        }
        .api-status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            display: none;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
            display: block;
        }
        .status-error {
            background-color: #f8d7da;
            color: #721c24;
            display: block;
        }
        .status-info {
            background-color: #cce5ff;
            color: #004085;
            display: block;
        }
        .debug-info {
            font-size: 12px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            display: none;
        }
        .offer-details {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .token-section {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .login-section {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="header text-center">
    <div class="container">
        <h1 class="display-4">Sistem de Oferte RCA</h1>
        <p class="lead">Cheap and convenient offers!</p>
    </div>
</div>

<div class="container">
    <div id="api-status" class="api-status"></div>

    <!-- Formular pentru autentificare -->
    <div class="login-section" id="login-form">
        <h4>Autentificare API</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Cont</label>
                <input type="text" class="form-control" id="api-account" placeholder="Introdu contul">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Parolă</label>
                <input type="password" class="form-control" id="api-password" placeholder="Introdu parola">
            </div>
        </div>
        <button id="login-btn" class="btn btn-success">Autentificare</button>
    </div>

    <!-- Formular pentru token -->
    <div class="token-section" id="token-form" style="display: none;">
        <h4>Token API</h4>
        <div class="mb-3">
            <label class="form-label">Token API (obținut automat)</label>
            <input type="text" class="form-control" id="api-token" readonly>
        </div>
    </div>

    <!-- Formular pentru datele asiguratului și vehiculului -->
    <div class="form-section" id="offer-form" style="display: none;">
        <h3 class="mb-4">Datele pentru oferta RCA</h3>
        <form id="insurance-form">
            <div class="row">
                <div class="col-md-6">
                    <h4>Date Asigurat</h4>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Prenume</label>
                            <input type="text" name="first_name" class="form-control" required value="Vasile">
                        </div>
                        <div class="col">
                            <label class="form-label">Nume</label>
                            <input type="text" name="last_name" class="form-control" required value="Pop">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CNP</label>
                        <input type="text" name="cnp" class="form-control" required value="5020101122718">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data nașterii</label>
                        <input type="date" name="birthdate" class="form-control" required value="2002-01-01">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Telefon</label>
                            <input type="text" name="phone" class="form-control" required value="0744444444">
                        </div>
                        <div class="col">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required value="email@email.ro">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresă</label>
                        <input type="text" name="address" class="form-control" required value="Calea Manastur 2-6, Cluj-Napoca">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Județ</label>
                            <input type="text" name="county" class="form-control" required value="CJ">
                        </div>
                        <div class="col">
                            <label class="form-label">Oraș</label>
                            <input type="text" name="city" class="form-control" required value="Cluj-Napoca">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cod oraș</label>
                        <input type="number" name="city_code" class="form-control" required value="54984">
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Date Vehicul</h4>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Număr înmatriculare</label>
                            <input type="text" name="license_plate" class="form-control" required value="CJ01ABC">
                        </div>
                        <div class="col">
                            <label class="form-label">Marca</label>
                            <input type="text" name="brand" class="form-control" required value="Audi">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" class="form-control" required value="A5">
                        </div>
                        <div class="col">
                            <label class="form-label">An fabricație</label>
                            <input type="number" name="year" class="form-control" required value="2020">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Putere (CP)</label>
                            <input type="number" name="engine_power" class="form-control" value="85">
                        </div>
                        <div class="col">
                            <label class="form-label">Combustibil</label>
                            <select name="fuel_type" class="form-control">
                                <option value="benzina">Benzină</option>
                                <option value="diesel" selected>Diesel</option>
                                <option value="electric">Electric</option>
                                <option value="hibrid">Hibrid</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data start asigurare</label>
                        <input type="date" name="start_date" class="form-control" required
                               value="2025-09-30" min="2025-09-15">
                    </div>
                </div>
            </div>

            <h4 class="mt-4">Detalii ofertă</h4>
            <div class="mb-3">
                <label class="form-label">Asigurator</label>
                <select name="business_name" class="form-control" id="insurer-select">
                    <option value="allianz">Allianz</option>
                    <option value="asirom">Asirom</option>
                    <option value="axeria" selected>Axeria</option>
                    <option value="generali">Generali</option>
                    <option value="groupama">Groupama</option>
                    <option value="omniasig">Omniasig</option>
                </select>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="debug-toggle">
                <label class="form-check-label" for="debug-toggle">
                    Afișează informații debug
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-lg mt-3">Generează oferte</button>
        </form>
    </div>

    <!-- Loader pentru timpul de procesare -->
    <div class="loader" id="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Se încarcă...</span>
        </div>
        <p class="mt-2">Generăm ofertele tale. Această operațiune poate dura câteva momente.</p>
    </div>

    <!-- Rezultatele ofertelor -->
    <div class="results-container" id="results-container">
        <h3 class="mb-4">Rezultatele Ofertelor RCA</h3>

        <div class="offer-details">
            <p><strong>Status:</strong> Conectat la API-ul real. Datele afișate provin direct de la server.</p>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Ofertă generată cu succes</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Asigurator:</strong> <span id="result-insurer"></span></p>
                        <p><strong>Preț total:</strong> <span id="result-price"></span> RON</p>
                        <p><strong>Preț net:</strong> <span id="result-net-price"></span> RON</p>
                        <p><strong>Bonus Malus:</strong> <span id="result-bonus"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Număr înmatriculare:</strong> <span id="result-license"></span></p>
                        <p><strong>Perioadă valabilitate:</strong> <span id="result-validity"></span></p>
                        <p><strong>Excluderi carte verde:</strong> <span id="result-exclusions"></span></p>
                    </div>
                </div>
                <div id="debug-info" class="debug-info">
                    <h6>Informații Debug:</h6>
                    <pre id="debug-payload"></pre>
                    <pre id="debug-response"></pre>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button id="new-offer-btn" class="btn btn-primary">Ofertă nouă</button>
            <a id="download-pdf-btn" class="btn btn-success" href="#" target="_blank">Descarcă PDF</a>
            <button id="view-pdf-btn" class="btn btn-info">Vezi PDF în fereastră nouă</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('insurance-form');
        const loader = document.getElementById('loader');
        const resultsContainer = document.getElementById('results-container');
        const newOfferBtn = document.getElementById('new-offer-btn');
        const downloadPdfBtn = document.getElementById('download-pdf-btn');
        const viewPdfBtn = document.getElementById('view-pdf-btn');
        const apiStatus = document.getElementById('api-status');
        const debugToggle = document.getElementById('debug-toggle');
        const debugInfo = document.getElementById('debug-info');
        const debugPayload = document.getElementById('debug-payload');
        const debugResponse = document.getElementById('debug-response');
        const apiTokenInput = document.getElementById('api-token');
        const loginBtn = document.getElementById('login-btn');
        const loginForm = document.getElementById('login-form');
        const tokenForm = document.getElementById('token-form');
        const offerForm = document.getElementById('offer-form');

        let apiResponse = null;
        let pdfUrl = null;
        let offerId = null;
        let apiToken = '';

        // Autentificare cu cont și parolă
        loginBtn.addEventListener('click', function() {
            const account = document.getElementById('api-account').value.trim();
            const password = document.getElementById('api-password').value.trim();

            if (!account || !password) {
                showApiStatus('Te rog completează ambele câmpuri de autentificare.', 'error');
                return;
            }

            showApiStatus('Se conectează la server...', 'info');

            // Facem autentificarea folosind contul și parola
            authenticate(account, password)
                .then(token => {
                    apiToken = token;
                    apiTokenInput.value = token;
                    showApiStatus('Autentificare reușită! Token salvat.', 'success');
                    loginForm.style.display = 'none';
                    tokenForm.style.display = 'block';
                    offerForm.style.display = 'block';
                })
                .catch(error => {
                    showApiStatus('Eroare la autentificare: ' + error.message, 'error');
                });
        });

        // Eveniment pentru toggle-ul de debug
        debugToggle.addEventListener('change', function() {
            debugInfo.style.display = this.checked ? 'block' : 'none';
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Verifică dacă există un token
            if (!apiToken) {
                showApiStatus('Te rog autentifică-te mai întâi.', 'error');
                loginForm.style.display = 'block';
                return;
            }

            // Ascunde formularul și afișează loader-ul
            offerForm.style.display = 'none';
            loader.style.display = 'block';
            apiStatus.style.display = 'none';

            // Pregătește datele pentru API
            const formData = {
                first_name: form.first_name.value,
                last_name: form.last_name.value,
                cnp: form.cnp.value,
                birthdate: form.birthdate.value,
                phone: form.phone.value,
                email: form.email.value,
                address: form.address.value,
                license_plate: form.license_plate.value,
                brand: form.brand.value,
                model: form.model.value,
                year: form.year.value,
                engine_power: form.engine_power.value,
                fuel_type: form.fuel_type.value,
                start_date: form.start_date.value,
                business_name: form.business_name.value,
                county: form.county.value,
                city: form.city.value,
                city_code: form.city_code.value
            };

            // Construiește payload-ul pentru API
            const payload = buildApiPayload(formData);

            // Afișează payload-ul pentru debug (dacă este cazul)
            if (debugToggle.checked) {
                debugPayload.textContent = JSON.stringify(payload, null, 2);
            }

            // Trimite cererea către API-ul real
            createOffer(payload)
                .then(response => {
                    apiResponse = response;
                    offerId = response.data.offers[0].offerId;

                    // Afișează răspunsul pentru debug (dacă este cazul)
                    if (debugToggle.checked) {
                        debugResponse.textContent = JSON.stringify(response, null, 2);
                    }

                    displayResults(response, formData);
                })
                .catch(error => {
                    showApiStatus('Eroare la comunicarea cu API-ul: ' + error.message, 'error');
                    loader.style.display = 'none';
                    offerForm.style.display = 'block';
                });
        });

        newOfferBtn.addEventListener('click', function() {
            resultsContainer.style.display = 'none';
            offerForm.style.display = 'block';
            apiResponse = null;
            pdfUrl = null;
            offerId = null;
        });

        viewPdfBtn.addEventListener('click', function() {
            if (pdfUrl) {
                window.open(pdfUrl, '_blank');
            } else {
                alert('Nu există niciun PDF disponibil pentru vizualizare.');
            }
        });

        // Funcție pentru autentificare
        async function authenticate(account, password) {
            const authUrl = 'https://rca-qa.api.lifeishard.ro/auth';

            try {
                const response = await fetch(authUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        account: account,
                        password: password
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Eroare autentificare: ${response.status} ${response.statusText}. Detalii: ${errorText}`);
                }

                const data = await response.json();

                if (data.error || !data.data || !data.data.token) {
                    throw new Error(data.message || 'Tokenul lipsește din răspuns');
                }

                return data.data.token;
            } catch (error) {
                console.error('Eroare la autentificare:', error);
                throw error;
            }
        }

        function buildApiPayload(formData) {
            // Construiește payload-ul conform cerințelor API-ului
            return {
                "provider": {
                    "organization": {
                        "businessName": formData.business_name
                    },
                    "authentication": {
                        "account": "",
                        "password": "",
                        "code": ""
                    }
                },
                "product": {
                    "motor": {
                        "startDate": formData.start_date,
                        "termTime": 12,
                        "installmentCount": 1,
                        "commissionPercentLimit": 10
                    },
                    "policyholder": {
                        "firstName": formData.first_name,
                        "lastName": formData.last_name,
                        "isForeignPerson": false,
                        "taxId": formData.cnp,
                        "nationality": "RO",
                        "citizenship": "RO",
                        "gender": "m",
                        "birthdate": formData.birthdate, // Folosim data din formular
                        "email": formData.email,
                        "mobileNumber": formData.phone,
                        "identification": {
                            "idType": "CI",
                            "idNumber": "CJ123456",
                            "issueAuthority": "SPCLEP Cluj",
                            "issueDate": "2022-11-24"
                        },
                        "drivingLicense": {
                            "issueDate": "2022-11-24"
                        },
                        "address": {
                            "country": "RO",
                            "county": formData.county,
                            "city": formData.city,
                            "cityCode": parseInt(formData.city_code),
                            "street": formData.address,
                            "houseNumber": "2-6",
                            "building": "A1",
                            "staircase": "1",
                            "apartment": "12",
                            "floor": "3",
                            "postcode": "400356"
                        },
                        "hasDisability": false,
                        "isRetired": false
                    },
                    "vehicle": {
                        "owner": {
                            "firstName": formData.first_name,
                            "lastName": formData.last_name,
                            "isForeignPerson": false,
                            "taxId": formData.cnp,
                            "nationality": "RO",
                            "citizenship": "RO",
                            "gender": "m",
                            "birthdate": formData.birthdate, // Folosim data din formular
                            "email": formData.email,
                            "mobileNumber": formData.phone,
                            "identification": {
                                "idType": "CI",
                                "idNumber": "CJ123456",
                                "issueAuthority": "SPCLEP Cluj",
                                "issueDate": "2022-11-24"
                            },
                            "address": {
                                "country": "RO",
                                "county": formData.county,
                                "city": formData.city,
                                "cityCode": parseInt(formData.city_code),
                                "street": "Principala",
                                "houseNumber": "19-21",
                                "building": "A1",
                                "staircase": "1",
                                "apartment": "12",
                                "floor": "3",
                                "postcode": "400356"
                            }
                        },
                        "driver": [
                            {
                                "lastName": formData.last_name,
                                "firstName": formData.first_name,
                                "taxId": formData.cnp,
                                "identification": {
                                    "idNumber": "CJ123456"
                                },
                                "mobileNumber": formData.phone
                            }
                        ],
                        "licensePlate": formData.license_plate,
                        "brand": formData.brand,
                        "model": formData.model,
                        "yearOfConstruction": parseInt(formData.year),
                        "enginePower": parseInt(formData.engine_power) || 85,
                        "fuelType": formData.fuel_type,
                        "usageType": "personal",
                        "registrationType": "registered",
                        "vin": "WA1YF3ZE6CGGR8158",
                        "vehicleType": "M1",
                        "engineDisplacement": 600,
                        "totalWeight": 3000,
                        "seats": 4,
                        "firstRegistration": "2025-08-05",
                        "identification": {
                            "idNumber": "H123456"
                        },
                        "currentMileage": 20000,
                        "hasMobilityModifications": false,
                        "isLeased": false
                    },
                    "additionalData": {
                        "product": {
                            "motor": {
                                "hasCasco": true
                            },
                            "coordinatorId": 76241,
                            "recommenderTaxId": "1900105125781",
                            "protocolId": 222,
                            "extraCoverage": true,
                            "vehicle": {
                                "expirationDatePti": "2026-02-08"
                            }
                        }
                    }
                }
            };
        }

        // Funcție pentru a crea o ofertă folosind API-ul real
        async function createOffer(payload) {
            // URL-ul API-ului pentru crearea ofertei
            const apiUrl = 'https://rca-qa.api.lifeishard.ro/offer';

            try {
                showApiStatus('Se conectează la API pentru a crea oferta...', 'info');

                // Headers pentru cerere
                const headers = {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Token': apiToken
                };

                // Realizează cererea POST către API
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify(payload)
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Eroare API: ${response.status} ${response.statusText}. Detalii: ${errorText}`);
                }

                const data = await response.json();

                if (data.error) {
                    throw new Error(data.message || 'Eroare din partea serverului');
                }

                showApiStatus('Ofertă creată cu succes!', 'success');
                return data;
            } catch (error) {
                console.error('Eroare la crearea ofertei:', error);
                showApiStatus(`Eroare: ${error.message}`, 'error');
                throw error;
            }
        }

        function displayResults(response, formData) {
            // Ascunde loader-ul și afișează rezultatele
            loader.style.display = 'none';
            resultsContainer.style.display = 'block';

            // Verifică dacă răspunsul conține oferte
            if (!response.data || !response.data.offers || response.data.offers.length === 0) {
                showApiStatus('API-ul nu a returnat nicio ofertă. Verificați datele introduse.', 'error');
                return;
            }

            // Extrage oferta din răspuns
            const offer = response.data.offers[0];

            // Actualizează detaliile în interfață
            document.getElementById('result-insurer').textContent = formData.business_name;
            document.getElementById('result-price').textContent = offer.premiumAmount;
            document.getElementById('result-net-price').textContent = offer.premiumAmountNet;
            document.getElementById('result-bonus').textContent = offer.bonusMalusClass;
            document.getElementById('result-license').textContent = formData.license_plate;

            // Formatează datele pentru afișare
            const startDate = new Date(offer.startDate).toLocaleDateString();
            const endDate = new Date(offer.endDate).toLocaleDateString();
            document.getElementById('result-validity').textContent = `De la ${startDate} până la ${endDate}`;

            document.getElementById('result-exclusions').textContent = offer.greenCardExclusions;

            // Setează URL-ul pentru descărcarea PDF-ului
            pdfUrl = offer.pid;
            downloadPdfBtn.href = pdfUrl;

            showApiStatus('Oferta a fost generată cu succes! PDF-ul este disponibil pentru descărcare.', 'success');
        }

        function showApiStatus(message, type) {
            apiStatus.textContent = message;
            apiStatus.className = 'api-status';

            if (type === 'success') {
                apiStatus.classList.add('status-success');
            } else if (type === 'error') {
                apiStatus.classList.add('status-error');
            } else {
                apiStatus.classList.add('status-info');
            }

            apiStatus.style.display = 'block';
        }
    });
</script>
</body>
</html>
