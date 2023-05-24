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
    </header>
    <!-- End of NavBar-->

    <main>

        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-danger text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <div>
                                <h2 class="fw-bold mb-2 text-uppercase">REGISTRASI</h2>
                                <p class="text-white-50 mb-5">Masukkan nama, email, telp, dan password anda.</p>
                                <form action="{{ url('postregistrasi') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="typeEmailX">Nama</label>
                                        <input type="text" name='name' class="form-control form-control-lg" required />
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="typeEmailX">Email</label>
                                        <input type="email" name='email' class="form-control form-control-lg" required />
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="typeEmailX">Telp</label>
                                        <input type="text" name='telp' class="form-control form-control-lg" required />
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="typePasswordX">Password</label>
                                        <input type="password" name='password' class="form-control form-control-lg" />
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="http://localhost/bfitgudang/login" class="btn btn-outline-light btn-lg px-4" name="cancel">Cancel</a>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <button class="btn btn-outline-light btn-lg px-4" type="submit" name="kirim" value="kirim">Register</button>
                                        </div>
                                    </div>
                                </form>
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
