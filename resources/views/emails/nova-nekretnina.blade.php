<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #004274; padding: 20px; text-align: center;">
        <h1 style="color: #fec059; margin: 0; font-size: 22px;">Castello Nekretnine</h1>
        <p style="color: rgba(255,255,255,0.7); margin: 5px 0 0;">Nova nekretnina je dostupna!</p>
    </div>

    <div style="padding: 30px 20px; border: 1px solid #eee;">
        <h2 style="color: #004274;">{{ $nekretnina->naziv }}</h2>
        <p style="color: #666;">Pronašli smo nekretninu koja odgovara vašim kriterijumima.</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr style="background: #f8f8f8;">
                <td style="padding: 10px; border: 1px solid #eee; color: #888; font-size: 13px;">Cena</td>
                <td style="padding: 10px; border: 1px solid #eee; font-weight: bold; color: #fec059;">
                    {{ number_format($nekretnina->cena, 0, ',', '.') }}€
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #eee; color: #888; font-size: 13px;">Tip</td>
                <td style="padding: 10px; border: 1px solid #eee;">{{ $nekretnina->tip->tip }}</td>
            </tr>
        </table>

        <a href="{{ url('/nekretnine/' . $nekretnina->id) }}"
            style="display: inline-block; background: #fec059; color: #1b1b1b; padding: 12px 28px;
                  text-decoration: none; font-weight: bold; margin-top: 10px;">
            Pogledaj nekretninu
        </a>
    </div>

    <div style="padding: 16px 20px; background: #f8f8f8; font-size: 12px; color: #999; text-align: center;">
        <a href="{{ url('/pretplatnici/odjava/' . $pretplatnik->token) }}"
            style="color: #999;">Odjavite se od obaveštenja</a>
    </div>
</body>

</html>