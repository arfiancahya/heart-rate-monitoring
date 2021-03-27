<?php
$judul = "Smart Care";
$pecahjudul = explode(" ", $judul);
$acronym = "";

foreach ($pecahjudul as $w) {
  $acronym .= $w[0];
}
?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html"><?php echo $judul; ?></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html"><?php echo $acronym; ?></a>
    </div>
    <ul class="sidebar-menu">
      <li <?php echo ($page == "Dashboard") ? "class=active" : ""; ?>><a class="nav-link" href="index.php"><i class="fas fa-heartbeat"></i><span>Dashboard</span></a></li>
      <li class="menu-header">Menu</li>

      <li <?php echo ($page == "Profile") ? "class=active" : ""; ?>><a class="nav-link" href="user.php"><i class="fas fa-user"></i> <span>Profile</span></a></li>
      <li <?php echo ($page == "History" || @$page1 == "det") ? "class=active" : ""; ?>><a class="nav-link" href="history.php"><i class="fas fa-calendar-alt"></i> <span>History</span></a></li>

    
  </aside>
</div>