<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            margin: 0;
            text-align: center;
        }

        .qr-page {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-code {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .qr-code svg {
            display: block;
        }

        .qr-url {
            max-width: 90%;
            margin: 0 auto;
            overflow-wrap: anywhere;
            font-size: 10px;
        }

        @media print {
            @page {
                size: 8cm 12cm;
                margin: 4mm;
            }

            .no-print {
                display: none;
            }

            .qr-page {
                min-height: 0;
                height: auto;
                page-break-inside: avoid;
                break-inside: avoid;
            }

            .qr-page > div {
                padding-top: 4px !important;
                padding-bottom: 4px !important;
            }

            .qr-page h4 {
                margin: 0;
                font-size: 18px;
            }

            .qr-code svg {
                width: 42mm;
                height: 42mm;
            }

            .qr-url {
                margin: 2px auto;
                font-size: 7px;
            }

            .qr-page h6 {
                margin: 0;
                font-size: 12px;
            }

            .qr-page p {
                margin: 4px 0 0;
                font-size: 8px;
                line-height: 1.2;
            }
        }
    </style>
</head>
<body>
    <div class="qr-page">
        <div class="py-3">
            <h4 class="fw-bold">{{ $title }}</h4>
        </div>
        <div class="qr-code">
            {!! $qrCode !!}
        </div>
        <p class="qr-url">{{ $url }}</p>
        <div class="py-3">
            <h6 class="fw-bold text-center">Serasne</h6>
            <p>Belbra Munthe Rencarhome, Jalan Citayam Raya No. 4b, RT.5/RW.2, Jembatan Kembar, Pancoran Mas</p>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
