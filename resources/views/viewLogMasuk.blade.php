<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Barang Gudang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

</head>
<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

    body {
        font-family: 'Quicksand', sans-serif;
        height: 100vh;
        margin: 0;
    }

    header.navbar-container {
        max-width: 1200px;
        width: 100%;
        margin-inline: auto;
        display: flex;
        justify-content: space-around;
        align-items: center;

        padding-block: 1rem;
        z-index: 999;
    }

    header.navbar-container .logo img {
        width: 150px;
    }

    header.navbar-container .nav-list ul {
        padding-left: 0;
        display: flex;
        justify-content: center;
        gap: 2rem 1rem;
    }

    header.navbar-container .nav-list li {
        list-style-type: none;
    }

    header.navbar-container .nav-list li a {
        text-decoration: none;
        font-size: 1.05rem;
        font-weight: 500;
        color: black;
        padding: .5rem 1.5rem;
        border-radius: 999px;
        transition: all .2s ease-in-out;
    }

    header.navbar-container .nav-list li:hover a {
        background-color: #ffff01;
        color: black;
    }

    main {
        max-width: 1200px;
        width: 100%;
        margin-inline: auto;
        padding: 2rem 4rem;
        flex: 1;

        display: flex;
        flex-direction: column;
        align-items: center;
    }

    main .tabelGudang {
        max-width: 1000px;
        width: 100%;
        padding: 0rem 4rem;

        border-radius: 20px;
    }
</style>

<body>
    <header class="navbar-container">
        <div class="logo">
            <img src="http://localhost/program/img/logo-bfit.png" alt="Bfit Indonesia">
        </div>
        <nav class="nav-list">
            <ul>
                <li><a href="http://localhost/bfitgudang/viewBarang/">Barang</a></li>
                <li><a href="http://localhost/bfitgudang/viewLogMasuk/">Baru / Retur</a></li>
                <li><a href="http://localhost/bfitgudang/viewLogKeluar/">Keluar</a></li>
            </ul>
        </nav>
    </header>
    <!-- End of NavBar-->

    <main>
        <h2>Log Barang Masuk</h2>

        <table id="date_search" cellspacing="5" cellpadding="5" border="0">
            <tbody>
                <tr>
                    <td>Tanggal Awal:</td>
                    <td>Tanggal Akhir:</td>
                </tr>
                <tr>
                    <td><input type="text" id="min" name="min"></td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>
            </tbody>
        </table>

        <div class="tabelGudang">
            <table border="1" class="table table-striped" style="width: 100%" id="tabel_barang">
                <thead>
                    <tr>
                        <th scope="col">ID Barang</th>
                        <th scope="col">Jumlah Barang</th>
                        <th scope="col">Status Barang</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($log as $row)
                        <tr>
                            <td>{{ $row->id_barang }}</td>
                            <td>{{ $row->jumlah_barang }}</td>
                            <td>{{ $row->status_barang }}</td>
                            <td>{{ $row->tanggal_log }}</td>
                            <td>{{ $row->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script type="text/javascript">
        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date(data[3]);

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });

            var table_barang = $('#tabel_barang').DataTable({
                order: [
                    [3, 'desc']
                ]
            });

            // Refilter the table
            $('#min, #max').on('change', function() {
                table_barang.draw();
            });
        });
    </script>
</body>

</html>
