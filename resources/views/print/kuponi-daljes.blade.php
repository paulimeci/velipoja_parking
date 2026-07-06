<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Kuponi i Daljes</title>
    <style>
        @page { size: 80mm auto; margin: 0; }
        body {
            width: 80mm;
            margin: 0 auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #000;
            padding: 8px;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .linje { border-top: 1px dashed #000; margin: 8px 0; }
        .rreshti { display: flex; justify-content: space-between; margin: 4px 0; }
        .targa-box {
            border: 2px solid #000;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            padding: 6px;
            margin: 10px 0;
            letter-spacing: 1px;
        }
        .totali {
            border: 2px solid #000;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            padding: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body onload="window.print()">

<div class="center bold" style="font-size: 15px;">PARKINGU</div>
<div class="center">Kuponi i Daljes / Faturë</div>
<div class="linje"></div>

<div class="targa-box">{{ $operacioni->targa }}</div>

<div class="rreshti">
    <span>Hyrja:</span>
    <span>{{ \Carbon\Carbon::parse($operacioni->nisja)->format('d/m/Y H:i') }}</span>
</div>
<div class="rreshti">
    <span>Ikja:</span>
    <span class="bold">{{ \Carbon\Carbon::parse($operacioni->ikja)->format('d/m/Y H:i') }}</span>
</div>

<div class="linje"></div>

@if($transaksioni)
    <div class="rreshti">
        <span>Shërbimi:</span>
        <span>{{ $transaksioni->prenotimi->kategoria ?? '-' }}</span>
    </div>

    @if($transaksioni->sasia && $transaksioni->sasia > 0)
        <div class="rreshti">
            <span>Sasia:</span>
            <span>x{{ $transaksioni->sasia }}</span>
        </div>
    @endif

    @if($transaksioni->fashaOrare)
        <div class="rreshti">
            <span>Fasha:</span>
            <span>{{ $transaksioni->fashaOrare->nga }}-{{ $transaksioni->fashaOrare->ne }}</span>
        </div>
    @endif

    <div class="totali">
        {{ number_format($transaksioni->vlera, 2) }} {{ $transaksioni->monedha_kodi ?? '' }}
    </div>
@else
    <div class="center">Pa transaksion të regjistruar.</div>
@endif

<div class="linje"></div>
<div class="center" style="font-size: 11px;">Faleminderit!</div>

</body>
</html>
