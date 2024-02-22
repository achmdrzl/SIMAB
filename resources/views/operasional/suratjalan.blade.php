<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .details {
            margin-bottom: 20px;
        }

        .details table {
            width: 100%;
        }

        .details td {
            padding: 8px;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .items th, .items td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .items th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
    <title>Surat Jalan</title>
</head>
<body>

    <div class="container">

        <div class="header">
            <img srcset="data:image/png;base64,<base64_encoded_data> 1x, https://ik.imagekit.io/dxofqajmq/cvsurya_MvrKKMFGH.png?updatedAt=1708412725864 2x" alt="Logo" class="logo">
            <h2>Surat Jalan</h2>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td>Nama Proyek :</td>
                    <td><strong>{{ ucfirst($data->proyek->proyek_nama) }}</strong></td>
                </tr>
                <tr>
                    <td>Tanggal :</td>
                    <td>{{ date('d M, Y', strtotime($data->suratjalan_tgl)) }}</td>
                </tr>
                <tr>
                    <td>Driver :</td>
                    <td>{{ ucfirst($data->suratjalan_driver) }}</td>
                </tr>
                <tr>
                    <td>Pengawas Lapangan :</td>
                    <td>{{ ucfirst($data->suratjalan_pengawaslapangan) }}</td>
                </tr>
            </table>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->detailsurat as $row)
                    <tr>
                        <td>{{ ucfirst($row->alat->alat_nama) }}</td>
                        <td>{{ $row->alat_jml }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih atas kerjasamanya</p>
        </div>

    </div>

</body>
</html>
