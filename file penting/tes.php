<!DOCTYPE html>
<html>
<head>
    <title>Absensi Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="style.css">

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

            $('#nim-input').on('autocompleteselect', function(event, ui) {
                var selectedNIM = ui.item.value.split(' - ')[0];
                var selectedNama = ui.item.value.split(' - ')[1];
                $('#nim-input').val(selectedNIM);
                $('#nama-input').val(selectedNama);
            });

            $('.absensi-button').on('click', function() {
                $('.absensi-button').removeClass('selected');
                $(this).addClass('selected');
                var selectedValue = $(this).text();
                $('#absensi-input').val(selectedValue);

                if (selectedValue === 'Izin') {
                    $('#alasan-input-container').show();
                } else {
                    $('#alasan-input-container').hide();
                }
            });

            $('form').on('submit', function(e) {
                var selectedValue = $('#absensi-input').val();
                var alasan = $('#alasan-input').val();
                if (selectedValue === 'Izin' && alasan === '') {
                    e.preventDefault();
                    alert('Mohon isi alasan untuk absensi Izin.');
                }

                // // Check if selectedNIM is empty or not found in the suggestions
                // var selectedNIM = $('#nim-input').val();
                // var suggestions = $('#nim-input').autocomplete('option', 'source');
                // if (selectedNIM === '' || suggestions.indexOf(selectedNIM) === -1) {
                //     e.preventDefault();
                //     alert('NIM atau Nama Mahasiswa tidak valid.');
                // }
            });
        });
    </script>
    <style>
        .absensi-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #ccc;
            border: none;
            cursor: pointer;
        }

        .absensi-button.selected {
            background-color: #99ff99;
        }
    </style>
</head>
<body>
    <!-- Tombol untuk mencetak laporan -->
    <a href="generate_report.php" target="_blank" class="print-button">Cetak Laporan</a>
    <h1>Absensi Mahasiswa</h1>
    <form action="save_absensi.php" method="POST">
        <div style="display: flex; flex-direction: column; align-items: center;">
            <label for="nim-input">Pilih NIM atau Nama Mahasiswa:</label>
            <input type="text" id="nim-input" name="selectedNIM" autocomplete="off">
            <input type="hidden" id="nama-input" name="nama">

            <div id="nim-suggestions"></div>

            <label>Tipe Absensi:</label>
            <div>
                <button type="button" class="absensi-button">Hadir</button>
                <button type="button" class="absensi-button">Absen</button>
                <button type="button" class="absensi-button">Izin</button>
                <button type="button" class="absensi-button">Sakit</button>
            </div>

            <div id="alasan-input-container" style="display: none;">
                <label for="alasan-input">Alasan:</label>
                <input type="text" id="alasan-input" name="alasan">
            </div>

            <input type="hidden" id="absensi-input" name="absensi">
            <input type="submit" value="Submit">

            
        </div>
        
    </form>
    
</body>
</html>