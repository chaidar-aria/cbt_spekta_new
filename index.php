<?php
session_start();
if ($_SESSION) {
    if ($_SESSION['level'] == "admin") {
        header("Location: page/admin/");
    }
    if ($_SESSION['level'] == "user") {
        header("Location: page/cbt/");
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css">

    <title>CBT SPEKTA | Sistem Pencatatan Keuangan dan Keanggotaan Pramuka</title>
</head>

<body>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-5 text-center">
                            <div class="mb-4">
                                <h3>Login <strong>CBT SPEKTA</strong></h3>
                                <p class="mb-4">Silahkan masukkan username dan password</p>
                            </div>
                            <form action="config/auth.php" method="post">
                                <div class="form-group first">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
                                    <div class="valid-feedback">
                                        Masukkan Username
                                    </div>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                                    <div class="valid-feedback">
                                        Masukkan password
                                    </div>
                                </div>

                                <input type="submit" value="Log In" class="btn text-white btn-block btn-primary" name="logBtn">
                                <h6 class="subtitle text-center text-black-50 mt-5">Berjalan Optimal Di Chrome dan
                                    Firefox PC</h6>
                                <h6 class="subtitle text-center text-black-50">Tidak disarankan untuk menggunakan di
                                    <i>smartphone</i>
                                </h6>
                            </form>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>SPEKTA</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- End Footer -->
    <!-- End Footer -->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        var isNS = (navigator.appName == "Netscape") ? 1 : 0;
        if (navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN || Event.MOUSEUP);

        function mischandler() {
            return false;
        }

        function mousehandler(e) {
            var myevent = (isNS) ? e : event;
            var eventbutton = (isNS) ? myevent.which : myevent.button;
            if ((eventbutton == 2) || (eventbutton == 3)) return false;
        }
        document.oncontextmenu = mischandler;
        document.onmousedown = mousehandler;
        document.onmouseup = mousehandler;
    </script>
    <?php
    if (isset($_GET['mes'])) {
        if ($_GET['mes'] == 'gagal') {
    ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'LOGIN GAGAL !',
                    text: "Saat ini sistem sedang sibuk atau sedang ada perbaikan, mohon untuk mengulangi dalam 5 menit",
                    timer: 3000
                }).then((result) => {
                    window.location.href = "/";
                });
            </script>
        <?php
        } elseif ($_GET['mes'] == "logout") {
        ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'BERHASIL LOGOUT !',
                    text: "Terima kasih",
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    window.location.href = "/";
                });
            </script>
        <?php
        } elseif ($_GET['mes'] == "gagalLogin") {
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'LOGIN GAGAL',
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    window.location.href = "/";
                });
            </script>
    <?php
        }
    }
    ?>
</body>

</html>