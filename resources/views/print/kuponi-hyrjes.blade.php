<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Kuponi i Hyrjes</title>
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
    </style>
</head>
<body onload="window.print()">

<div class="center bold" style="font-size: 15px;">PARKINGU</div>
<div class="center">Kuponi i Hyrjes</div>
<div class="linje"></div>

<div class="targa-box">{{ $operacioni->targa }}</div>

<div class="rreshti">
    <span>Data:</span>
    <span>{{ \Carbon\Carbon::parse($operacioni->nisja)->format('d/m/Y') }}</span>
</div>
<div class="rreshti">
    <span>Ora Hyrjes:</span>
    <span class="bold">{{ \Carbon\Carbon::parse($operacioni->nisja)->format('H:i') }}</span>
</div>
<div class="rreshti">
    <span>Nr. Biletës:</span>
    <span>#{{ str_pad($operacioni->id, 6, '0', STR_PAD_LEFT) }}</span>
</div>

<div class="linje"></div>
<div class="center" style="font-size: 11px;">Ju lutem ruajeni këtë kupon</div>
<div class="center" style="font-size: 11px;">deri në momentin e daljes</div>

</body>
</html>
