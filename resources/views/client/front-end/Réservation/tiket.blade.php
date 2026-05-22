<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }

        .row {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: gray;
        }
    </style>
</head>

<body>

    <!-- Logo -->
    <div class="header">
        <img src="{{ public_path('assets/images/logo.png') }}" class="logo">
        <div class="title"> Ticket Réservation de l'hébergement {{$hebergement->nomHeberg}}</div>
    </div>

    <!-- Content -->
    <div class="card">
        <div class="row">
            <span class="label">Client:</span>
            {{ $reservation->nom_complet}}
        </div>
        <div class="row">
            <span class="label">id carte nationnel :</span>
            {{ $reservation->idCarteNational}}
        </div>
        <div class="row">
            <span class="label">addresse</span>
            {{ $reservation->Raddresee}}
        </div>
        
        

        <div class="row">
            <span class="label">Chambre:</span>
            {{ $reservation->typeChambres }}
        </div>

        <div class="row">
            <span class="label">Date début:</span>
            {{ $reservation->date_debut }}
        </div>

        <div class="row">
            <span class="label">Date fin:</span>
            {{ $reservation->date_fin }}
        </div>

        <div class="row">
            <span class="label">Montant:</span>
            {{ $reservation->amount }} DA
        </div>
        <div class="row">
            <span class="label">status de payment :</span>
            {{ $reservation->payedStatus }} 
        </div>
    </div>

 

</body>
</html>