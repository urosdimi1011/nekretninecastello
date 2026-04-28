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
                            <p style="margin:0;font-size:11px;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,0.5);">
                                Castello Nekretnine Vršac
                            </p>
                            <h1 style="margin:8px 0 0;font-size:22px;color:#fec059;font-weight:700;">
                                Pretplata je aktivna
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:15px;color:#444;line-height:1.6;">
                                Zdravo,
                            </p>

                            <p style="margin:0 0 24px;font-size:15px;color:#444;line-height:1.6;">
                                Uspešno ste potvrdili svoju email adresu i vaša pretplata na obaveštenja je sada aktivna.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f9fc;border:1px solid #e8eaf0;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px;">
                                        <p style="margin:0 0 12px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#888;">
                                            Vaši kriterijumi
                                        </p>

                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding:6px 0;font-size:13px;color:#888;width:40%;">Tip nekretnine</td>
                                                <td style="padding:6px 0;font-size:13px;color:#1a2035;font-weight:600;">
                                                    {{ $filter->tip?->tip ?? 'Nije definisano' }}
                                                </td>
                                            </tr>

                                            @if($filter->cena_min || $filter->cena_max)
                                            <tr>
                                                <td style="padding:6px 0;font-size:13px;color:#888;">Cena</td>
                                                <td style="padding:6px 0;font-size:13px;color:#1a2035;font-weight:600;">
                                                    {{ $filter->cena_min ? number_format($filter->cena_min, 0, ',', '.') . '€' : 'bez min' }}
                                                    –
                                                    {{ $filter->cena_max ? number_format($filter->cena_max, 0, ',', '.') . '€' : 'bez max' }}
                                                    {{ $filter->cena_po_metru ? '/m²' : '' }}
                                                </td>
                                            </tr>
                                            @endif

                                            @if($filter->kvadratura_min || $filter->kvadratura_max)
                                            <tr>
                                                <td style="padding:6px 0;font-size:13px;color:#888;">Kvadratura</td>
                                                <td style="padding:6px 0;font-size:13px;color:#1a2035;font-weight:600;">
                                                    {{ $filter->kvadratura_min ?? 'bez min' }} – {{ $filter->kvadratura_max ?? 'bez max' }} m²
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 16px;font-size:14px;color:#6b5520;line-height:1.6;">
                                        Obaveštenja se šalju jednom dnevno u 17:00h, i to samo ako ima novih nekretnina koje odgovaraju vašim kriterijumima.
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('pretplatnici.odjava', $filter->token) }}"
                                            style="display:inline-block;background:#fec059;color:#0f1f3d;padding:14px 36px;font-size:15px;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;">
                                            Isključi obaveštenja
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:24px 0 0;font-size:13px;color:#888;line-height:1.6;">
                                Ako u bilo kom trenutku više ne želite da primate obaveštenja, možete se odjaviti klikom na dugme iznad.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f8f9fc;padding:16px 32px;border-top:1px solid #e8eaf0;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#aaa;">
                                Castello Nekretnine Vršac · Vaska Pope 2 ·
                                <a href="{{ route('pretplatnici.odjava', $filter->token) }}"
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