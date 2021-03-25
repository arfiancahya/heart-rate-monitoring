<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $page = "Profile";
    session_start();
    include 'auth/connect.php';
    include "part/head.php";
    include "part_func/tgl_ind.php";
    include "part_func/umur.php";

    $sessionid = $_SESSION['id_user'];

    if (!isset($sessionid)) {
        header('location:auth');
    }
    $nama = mysqli_query($conn, "SELECT * FROM user WHERE id=$sessionid");
    $output = mysqli_fetch_array($nama);

    $tampilPeg    = mysqli_query($conn, "SELECT * FROM history WHERE id_user=$sessionid");
    $peg    = mysqli_fetch_array($tampilPeg);

    if (isset($_POST['submit'])) {
        $id = $_POST['iduser'];
        $user = $_POST['username'];
        $mail  = $_POST['email'];
        $nama = $_POST['nama'];
        $tgl = $_POST['tgl'];
        $gend = $_POST['gender'];
        $blood = $_POST['blood'];
        $alamt = $_POST['alamat'];
        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];

        if ($old_pass == "" && $new_pass == "") {
            $up1 = mysqli_query($conn, "UPDATE user SET username='$user', email='$mail', nama='$nama', tgl='$tgl', gender='$gend', blood='$blood', alamat='$alamt' WHERE id='$id'");
            echo '<script>
			setTimeout(function() {
				swal({
					title: "Data Diubah",
					text: "Data berhasil diubah!",
					icon: "success"
					});
					}, 500);
					</script>';
        } elseif ($old_pass != "" && $new_pass != "") {
            $cekpass = mysqli_query($conn, "SELECT * FROM user WHERE id_user=$sessionid AND password='" . md5($old_pass) . "'");
            $cekada = mysqli_num_rows($cekpass);
            if ($cekada == 0) {
                echo '<script>
						setTimeout(function() {
							swal({
								title: "Password salah",
								text: "Password salah, cek kembali form password anda!",
								icon: "error"
								});
								}, 500);
								</script>';
            } else {
                $up2 = mysqli_query($conn, "UPDATE user SET UPDATE user SET username='$user', email='$mail', nama='$nama', tgl='$tgl', gender='$gend', blood='$blood', alamat='$alamt'  password='" . md5($new_pass) . "', alamat='$alam' WHERE id='$id'");
                echo '<script>
				setTimeout(function() {
					swal({
					title: "Data Diubah",
					text: "Data atau Password berhasil diubah!",
					icon: "success"
					});
					}, 500);
				</script>';
            }
        }
    }

    ?>
    <style>
        #link-no {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="loading">
        <div class="load">
            <div class="heart-rate">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="150px" height="73px" viewBox="0 0 150 73" enable-background="new 0 0 150 73" xml:space="preserve">
                    <polyline fill="none" stroke="#009B9E" stroke-width="3" stroke-miterlimit="10" points="0,45.486 38.514,45.486 44.595,33.324 50.676,45.486 57.771,45.486 62.838,55.622 71.959,9 80.067,63.729 84.122,45.486 97.297,45.486 103.379,40.419 110.473,45.486 150,45.486" />
                </svg>
                <div class="fade-in"></div>
                <div class="fade-out"></div>
            </div>
            <h1>Loading to my website.... </h1>
        </div>
    </div>

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <?php
            include 'part/navbar.php';
            include 'part/sidebar.php';
            ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Profile</h1>
                    </div>
                    <div class="row">
                        <div class="cont-prof text-center">
                            <?php $nama = mysqli_query($conn, "SELECT * FROM user WHERE id=$sessionid");
                            while ($row = mysqli_fetch_array($nama)) {
                            ?>
                                <div class="profile text-left ">
                                    <img class="gambar" src="./assets/img/template_share_sayhihalf_avatoon_background_default_1607649318255 1.svg">
                                    <div class="main-sty">
                                        <h4><?php echo ucwords($row['nama']); ?></h4>
                                        <h4><?php echo ucwords($row['email']); ?></h4>
                                        <h4><?php echo ucwords($row['alamat']); ?></h4>
                                    </div>
                                    <!-- <h4><?php echo ucwords($row['tgl']); ?></h4>
                                    <h4><?php
                                        //if ($row['gender'] == '1') {
                                        // echo '<div class="badge badge-pill badge-primary mb-1">Laki-laki';
                                        // } //else {
                                        // echo '<div class="badge badge-pill badge-success mb-1">Perempuan';
                                        //} 
                                        ?></h4>
                                    <h4><?php if ($row['tgl'] == "") {
                                            // echo "-";
                                        } //else {
                                        //umur($row['tgl']);
                                        //} 
                                        ?></h4> -->

                                </div>

                                <span data-target="#editUser" data-toggle="modal" data-id="<?php echo $row['id']; ?>" data-user="<?php echo $row['username']; ?>" data-mail="<?php echo $row['email']; ?>" data-nama="<?php echo $row['nama']; ?>" data-tgl="<?php echo $row['tgl']; ?>" data-gend="<?php echo $row['gender']; ?>" data-blood="<?php echo $row['blood']; ?>" data-alamt="<?php echo $row['alamat']; ?>">
                                    <a class="btn btn-primary btn-action mr-1 mrg-btn-btm btn-shw" title="Edit" data-toggle="tooltip">Edit Profile</a>
                                </span>
                        </div>
                        <div class="cont-prof text-center mrg-left-10">
                            <div class="profile text-left">
                                <h2 class="pad-20 rest-mrg">My Information</h2>
                                <hr class="rest-mrg">
                                <div class="main-sty">
                                    <h4>Sex : <?php if ($row['gender'] == '1') {
                                                    echo 'Laki-Laki';
                                                } else {
                                                    echo 'Perempuan';
                                                } ?></h4>
                                    <h4>Age : <?php if ($row['tgl'] == "") {
                                                    echo "-";
                                                } else {
                                                    umur($row['tgl']);
                                                } ?></h4>
                                    <h4>Blood : <?php echo ucwords($row['blood']); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </section>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="editUser">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" class="needs-validation" novalidate="">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control" name="iduser" required="" id="getId">
                                    <input type="text" class="form-control" name="username" required="" id="getUser">
                                    <div class="invalid-feedback">
                                        Mohon data diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" required="" id="getEmail">
                                    <div class="invalid-feedback">
                                        Mohon data diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama" required="" id="getNama">
                                    <div class="invalid-feedback">
                                        Mohon data diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal lahir</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control datepicker" id="getTgl" name="tgl">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control selectric" name="gender" id="getGender">
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Blood</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="blood" required="" id="getBlood">
                                    <div class="invalid-feedback">
                                        Mohon data diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" required="" name="alamat" id="getAlamat"></textarea>
                            </div>
                            <div class="alert alert-light text-center">
                                Jika password tidak diganti, form dibawah dikosongi saja.
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Password Lama</label>
                                <div class="col-sm-9">
                                    <input type="password" name="old_password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'part/footer.php'; ?>
    </div>

    <?php include "part/all-js.php"; ?>

    <script src="./assets/js/loading.js"></script>
    <script>
        $('#editUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user = button.data('user')
            var mail = button.data('mail')
            var nama = button.data('nama')
            var tgl = button.data('tgl')
            var gend = button.data('gend')
            var blood = button.data('blood')
            var alamt = button.data('alamt')
            var id = button.data('id')
            var modal = $(this)
            modal.find('#getId').val(id)
            modal.find('#getUser').val(user)
            modal.find('#getEmail').val(mail)
            modal.find('#getNama').val(nama)
            modal.find('#getTgl').val(tgl)
            modal.find('#getGend').val(gend)
            modal.find('#getBlood').val(blood)
            modal.find('#getAlamat').val(alamt)
        })
    </script>
</body>

</html>