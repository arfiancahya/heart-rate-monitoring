<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $page = "History";
    session_start();
    include 'auth/connect.php';
    include "part/head.php";
    include 'part_func/tgl_ind.php';

    $sessionid = $_SESSION['id_user'];

    if (!isset($sessionid)) {
        header('location:auth');
    }
    $nama = mysqli_query($conn, "SELECT * FROM user WHERE id=$sessionid");
    $output = mysqli_fetch_array($nama);

    $tampilPeg    = mysqli_query($conn, "SELECT * FROM history WHERE id_user=$sessionid");
    $peg    = mysqli_fetch_array($tampilPeg);

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
            <!-- Main Content -->
			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1><?php echo $page; ?></h1>
					</div>

					<div class="section-body">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4><?php echo $page; ?></h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped" id="table-1">
												<thead>
													<tr>
														<th class="text-center">
															#
														</th>
														<th>Date</th>
														<th>Pulse</th>
														<th>Status ECG</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sql    = mysqli_query($conn, "SELECT * FROM history WHERE id_user=$sessionid");;
													$i = 0;
													while ($row = mysqli_fetch_array($sql)) {
														$i++;
													?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo ucwords($row['tgl']); ?></td>
															<td><?php echo ucwords($row['sensor_value']); ?> BPM</td>
															<td>sehat
										</div>
										</td>
										<td>
											<a class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus" data-confirm="Hapus Data|Apakah anda ingin menghapus data ini?" data-confirm-yes="window.location.href = 'auth/delete.php?type=history&id=<?php echo $row['id']; ?>'" ;><i class="fas fa-trash"></i></a>
										</td>
										</tr>
									<?php } ?>
									</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			</section>
		</div>
            <?php include 'part/footer.php'; ?>
        </div>
    </div>

    <?php include "part/all-js.php"; ?>

    <script src="./assets/js/loading.js"></script>
</body>

</html>