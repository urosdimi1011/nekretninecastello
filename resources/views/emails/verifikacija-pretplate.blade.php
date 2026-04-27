<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0;padding:0;background:#f1f3f8;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f3f8;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;max-width:560px;width:100%;">

                    <tr>
                        <td style="background:#004274;padding:24px 32px;text-align:center;">
                            <p style="margin:0;font-size:11px;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,0.5);">Castello Nekretnine Vršac</p>
                            <h1 style="margin:8px 0 0;font-size:22px;color:#fec059;font-weight:700;">Potvrdite pretplatu</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:15px;color:#444;line-height:1.6;">
                                Zdravo,
                            </p>
                            <p style="margin:0 0 24px;font-size:15px;color:#444;line-height:1.6;">
                                Primili smo zahtev za prijavu na obaveštenja o novim nekretninama. Kliknite na dugme ispod da potvrdite vašu email adresu i aktivirate pretplatu.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fc;border:1px solid #e8eaf0;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px;">
                                        <p style="margin:0 0 12px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#888;">Vaši kriterijumi</p>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding:6px 0;font-size:13px;color:#888;width:40%;">Tip nekretnine</td>
                                                <td style="padding:6px 0;font-size:13px;color:#1a2035;font-weight:600;">
                                                    {{ $filter->tip?->tip ?? 'Nije definisano' }}
                                                </td>
                                            </tr>
                                            @if($pretplatnik->cena_min || $pretplatnik->cena_max)
                                            <tr>
                                                <td style="padding:6px 0;font-size:13px;color:#888;">Cena</td>
                                                <td style="padding:6px 0;font-size:13px;color:#1a2035;font-weight:600;">
                                                    {{ $pretplatnik->cena_min ? number_format($pretplatnik->cena_min, 0, ',', '.') . '€' : 'bez min' }}
                                                    –
                                                    {{ $pretplatnik->cena_max ? number_format($pretplatnik->cena_max, 0, ',', '.') . '€' : 'bez max' }}
                                                    {{ $pretplatnik->cena_po_metru ? '/m²' : '' }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($pretplatnik->kvadratura_min || $pretplatnik->kvadratura_max)
                                            <tr>
                                                <td style="padding:6px 0;font-size:13px;color:#888;">Kvadratura</td>
                                                <td style="padding:6px 0;font-size:13px;color:#1a2035;font-weight:600;">
                                                    {{ $pretplatnik->kvadratura_min ?? 'bez min' }} – {{ $pretplatnik->kvadratura_max ?? 'bez max' }} m²
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('pretplatnici.verifikuj', $pretplatnik->token) }}"
                                            style="display:inline-block;background:#fec059;color:#0f1f3d;padding:14px 36px;font-size:15px;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;">
                                            Potvrdi pretplatu
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:24px 0 0;font-size:13px;color:#888;line-height:1.6;">
                                Ako niste vi poslali ovaj zahtev, jednostavno ignorišite ovaj mejl.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f8f9fc;padding:16px 32px;border-top:1px solid #e8eaf0;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#aaa;">
                                Castello Nekretnine Vršac · Vaska Pope 2·
                                <a href="{{ route('pretplatnici.odjava', $pretplatnik->token) }}"
                                    style="color:#aaa;">Odjavi se</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>