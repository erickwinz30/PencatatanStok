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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
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

    .nav-list ul li a.logout {
        text-decoration: none;
        font-size: 1.05rem;
        font-weight: 500;
        color: black;
        padding: .5rem 1.5rem;
        border-radius: 999px;
        transition: all .2s ease-in-out;
        background-color: red;
    }

    .nav-list ul li a.logout:hover {
        background-color: blue;
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

    .btn:hover {
        background-color: #ffff01;
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
                <li><a href="http://localhost/bfitgudang/login/" class="logout">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- End of NavBar-->

    <main>

        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-danger text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">INPUT BARANG</h2>
                                <p class="text-white-50 mb-5">Masukkan data barang masuk</p>

                                @foreach ($barang as $row)
                                    <form action="/bfitgudang/viewBarang/barangMasuk/edit" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-outline form-white mb-4">
                                            <label class="form-label" for="typeEmailX">ID Barang</label>
                                            <input style="pointer-events: none; filter: brightness(80%);" type="input" name='id_barang'
                                                class="form-control form-control-lg" value="{{ $row->id_barang }}"/>
                                        </div>

                                        <div class="form-outline form-white mb-4">
                                            <label class="form-label" for="typePasswordX">Jumlah barang yang
                                                ditambahkan</label>
                                            <input type="number" name='jumlah_barang'
                                                class="form-control form-control-lg" />
                                        </div>

                                        <div class="form-outline form-white mb-4">
                                            <label class="form-label" for="typePasswordX">Berat<p class="text-white-50">Biarkan jika tidak perlu</p></label>
                                            <input type="input" name='berat_barang' class="form-control form-control-lg" value="{{ $row->berat_barang }}" />
                                        </div>

                                        <div class="form-outline form-white mb-4">
                                            <label class="form-label" for="typeSatuanX">Status</label>
                                            <select name="status_barang" id="status_barang" class="form-control form-control-lg">
                                                <option value="Baru">Baru</option>
                                                <option value="Retur">Retur</option>
                                            </select>
                                        </div>

                                        <div class="form-outline form-white mb-4">
                                            <label class="form-label" for="typePasswordX">Keterangan</label>
                                            <input type="input" name='keterangan'
                                                class="form-control form-control-lg" />
                                        </div>

                                        <div class="col text-center">
                                            <input class="btn btn-outline-light btn-lg px-5" type="submit"
                                                value="Simpan">
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
</body>

</html>
