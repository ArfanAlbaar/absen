<!DOCTYPE html>
<html>
<head>
    <title>Absensi Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 0;
            order: -1; /* Menempatkan tulisan Absensi Mahasiswa di atas */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
        }

        input[type="text"],
        select {
            padding: 5px;
            margin-bottom: 10px;
        }

        #alasan-input-container {
            display: none;
        }

        input[type="submit"] {
            padding: 10px 20px;
        }

        .print-button {
            margin-top: 10px;
            align-self: flex-end;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.13.1/themes/ui-lightness/jquery-ui.css">
    <script>
        $(document).ready(function() {
            $('#nim-input').on('input', function() {
                var term = $(this).val();
                if (term.length >= 3) {
                    $.ajax({
                        url: 'get_suggestions.php',
                        method: 'GET',
                        data: { term: term },
                        dataType: 'json',
                        success: function(response) {
                            var suggestions = [];
                            $.each(response, function(index, item) {
                                suggestions.push(item.nim + ' - ' + item.nama);
                            });
                            $('#nim-input').autocomplete({
                                source: suggestions,
                                select: function(event, ui) {
                                    var selectedNIM = ui.item.value.split(' - ')[0];
                                    $('#nim-input').val(selectedNIM);
                                    $('#nama-input').val(ui.item.value.split(' - ')[1]);
                                    return false;
                                }
                            });
                        }
                    });
                }
            });

            $('#absensi-input').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'Izin') {
                    $('#alasan-input-container').show();
                } else {
                    $('#alasan-input-container').hide();
                }
            });
        });
    </script>
</head>
<body>
    <h1>Absensi Mahasiswa</h1>
    <form action="save_absensi.php" method="POST">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <label for="nim-input">Pilih NIM Mahasiswa:</label>
            <input type="text" id="nim-input" name="selectedNIM" autocomplete="off">
            <input type="hidden" id="nama-input" name="nama">

            <div id="nim-suggestions"></div>

            <label for="absensi-input">Tipe Absensi:</label>
            <select id="absensi-input" name="absensi">
                <option value="Hadir">Hadir</option>
                <option value="Absen">Absen</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>

            <div id="alasan-input-container">
                <label for="alasan-input">Alasan:</label>
                <input type="text" id="alasan-input" name="alasan">
            </div>

            <input type="submit" value="Submit">

            <!-- Tombol untuk mencetak laporan -->
            <a href="generate_report.php" target="_blank" class="print-button">Cetak Laporan</a>
        </div>
    </form>
</body>
</html>
