<!DOCTYPE html>
<html>
<head>
<title>Greška - 500 Internal Server Error</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        color: #333;
    }
    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 40px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    h1 {
        font-size: 32px;
        margin-bottom: 20px;
    }
    p {
        font-size: 18px;
        line-height: 1.5;
    }
    .button {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
    }
    .button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Greška - 500 Internal Server Error</h1>
    <p>Došlo je do interne server greške. Nažalost, ne možemo prikazati traženi sadržaj u ovom trenutku.</p>
    <p>Molimo vas da pokušate ponovo kasnije.</p>
    <p>Poruka o grešci: <strong>{{ $exception->getMessage() }}</strong></p>
    <a href="{{ URL::previous() }}" class="button">Povratak na prethodnu stranicu</a>
</div>
</body>
</html>
