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
                            <img src="{{ $message->embed(public_path('assets/img/Castello-zut.png')) }}"
                                alt="Castello Nekretnine"
                                width="140"
                                style="display:block;margin:0 auto 12px;">
                            <p style="margin:0;font-size:11px;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,0.5);">
                                Castello Nekretnine Vršac
                            </p>
                            <h1 style="margin:8px 0 0;font-size:20px;color:#fec059;font-weight:700;">
                                Nove nekretnine po vašim kriterijumima
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:28px 32px 16px;">
                            <p style="margin:0 0 8px;font-size:15px;color:#444;line-height:1.6;">
                                Zdravo,
                            </p>
                            <p style="margin:0;font-size:15px;color:#444;line-height:1.6;">
                                Pronašli smo
                                <strong>{{ $nekretnine->count() }} {{ $nekretnine->count() === 1 ? 'nekretninu' : 'nekretnine' }}</strong>
                                koje odgovaraju vašim kriterijumima.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 32px 24px;">
                            @foreach($nekretnine as $nekretnina)
                            @php
                            $kvadratura = $nekretnina->vrednostAtributa('Kvadratura');
                            $sobe = $nekretnina->vrednostAtributa('Sobe');
                            @endphp

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="border:1px solid #e8eaf0;margin-bottom:16px;background:#fff;">
                                <tr>
                                    @if($nekretnina->slika)
                                    <td width="140" style="vertical-align:top;">
                                        <img src="{{ $message->embed(public_path('assets/img/' . $nekretnina->slika->putanja)) }}"
                                            alt="{{ $nekretnina->naziv }}"
                                            width="140"
                                            style="display:block;width:140px;height:110px;object-fit:cover;">
                                    </td>
                                    @endif

                                    <td style="padding:14px 16px;vertical-align:top;">
                                        <p style="margin:0 0 4px;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;color:#888;">
                                            {{ $nekretnina->tip->tip ?? '' }}
                                            @if($nekretnina->mesto)
                                            · {{ $nekretnina->mesto->naziv }}
                                            @endif
                                        </p>

                                        <p style="margin:0 0 8px;font-size:15px;font-weight:700;color:#004274;line-height:1.3;">
                                            {{ $nekretnina->naziv }}
                                        </p>

                                        <p style="margin:0 0 12px;font-size:18px;font-weight:800;color:#fec059;">
                                            {{ number_format($nekretnina->cena, 0, ',', '.') }}€
                                            @if($nekretnina->cena_metar == 1)
                                            <span style="font-size:13px;font-weight:400;color:#888;">/m²</span>
                                            @endif
                                        </p>

                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                @if($kvadratura)
                                                <td style="padding-right:16px;">
                                                    <span style="font-size:12px;color:#888;">Kvadratura: </span>
                                                    <span style="font-size:12px;font-weight:600;color:#1a2035;">
                                                        {{ $kvadratura }} m²
                                                    </span>
                                                </td>
                                                @endif

                                                @if($sobe)
                                                <td>
                                                    <span style="font-size:12px;color:#888;">Sobe: </span>
                                                    <span style="font-size:12px;font-weight:600;color:#1a2035;">
                                                        {{ $sobe }}
                                                    </span>
                                                </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="padding:12px 16px;border-top:1px solid #f0f2f8;background:#fafafa;">
                                        <a href="{{ route('prikaziNekretninu', $nekretnina->id) }}"
                                            style="display:inline-block;background:#004274;color:#ffffff;padding:8px 20px;font-size:13px;font-weight:600;text-decoration:none;letter-spacing:0.3px;">
                                            Pogledaj nekretninu →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f8f9fc;padding:16px 32px;border-top:1px solid #e8eaf0;text-align:center;">
                            <p style="margin:0 0 6px;font-size:12px;color:#aaa;">
                                Castello Nekretnine Vršac · Vaska Pope 2
                            </p>
                            <p style="margin:0;font-size:12px;color:#aaa;">
                                <a href="{{ route('pretplatnici.odjava', $filter->token) }}"
                                    style="color:#aaa;text-decoration:underline;">
                                    Odjavi se od obaveštenja
                                </a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>