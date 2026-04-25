<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kontakt Forma - Poruka od posetioca</title>
</head>
<body class="forma-email">
    <div class="container">
        <h1>Poruka od posetioca sajta</h1>

        <p><strong>Ime i prezime:</strong> {{ $mailData['imeIPrezime'] }}</p>
        <p><strong>Broj telefona:</strong> {{ $mailData['brojTelefona'] }}</p>
        <p><strong>Email:</strong> {{ $mailData['email'] }}</p>

        <hr>

        <h2>Poruka:</h2>
        <p>{{$mailData['poruka']}}</p>

        <hr>

        <p>Ovaj email je poslat putem kontakt forme na sajtu.</p>
    </div>
</body>
</html>
