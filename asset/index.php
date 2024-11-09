<?php
include 'app.php';
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous" />

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/icon1.png" />
    <title>Klinik XYZ - <?php
                        if (isset($_GET['page'])) {
                            echo ucfirst($_GET['page']);
                        } else {
                            echo 'Dashboard';
                        }
                        ?>
    </title>
</head>

<body>

    <div class="sidebar">
        <div class="logo">
            <img src="img/user.jpg" alt="">
            <p>Klinik XYZ</p>
        </div>
        <ul class="menu">
            <li class="<?php echo ((!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : ''); ?>">
                <a href="index.php?page=dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'transaksi' ? 'active' : ''); ?>">
                <a href="index.php?page=transaksi">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
            </li>

            <li class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'penggajian' ? 'active' : ''); ?>">
                <a href="index.php?page=penggajian">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Penggajihan</span>
                </a>
            </li>

            <li>
                <a href="master/masterdata.php">
                    <i class="fas fa-database"></i>
                    <span>Master Data</span>
                </a>
            </li>


            <li class="logout">
                <a href="#" onclick="confirmLogout()">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main__content">
        <div class="header__wrapper">
            <div class="header__title">
                <span>Primary</span>
                <h4 style="font-weight: 600;">
                    <?php
                    if (isset($_GET['page'])) {
                        echo ucfirst($_GET['page']);
                    } else {
                        echo 'Dashboard';
                    }
                    ?>
                </h4>
            </div>
            <div class="user__info">
                <div class="search__box">
                    <label type="text" placeholder="Search"><?php echo $_SESSION['username'] ?></label>
                </div>

                <img src="img/user.jpg" alt="" />
            </div>
        </div>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            include 'view/' . $page . '.php';
        } else {
            // redirect ke halaman default jika parameter page tidak ada
            include 'view/dashboard.php';
        }
        ?>

    </div>

    <!-- <script src="js/trans.js"></script> -->
    <script src="js/gaji.js"></script>

    <script>
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = '../app/logout.php';
            }
        }
    </script>
</body>

</html>