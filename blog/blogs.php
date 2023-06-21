<?php

include_once("config.php");
   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<?php
include("includes/import.php");
?>

<body>
  <?php include("includes/top-bar.php"); include("includes/header.php"); ?><br>

  <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Latest News</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none" href="">View All</a>
                            </div>
                        </div>


                <div id="cuerpo">
<?php foreach ($posts as $post): ?>


   <div class="col-lg-6">
   <a href="blog.php?id=<?php echo $post['id'] ?>" >
                            <div class="position-relative mb-3">
                                <img class="img-fluid w-100" src="blog-data/<?php echo $post['id'] ?>/img/banner.jpg" style="object-fit: cover;">
                                <div class="bg-white border border-top-0 p-4">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                            href=""><?php echo $post['category'] ?></a>
                                        <a class="text-body" href=""><small><?php echo $post['date'] ?></small></a>
                                    </div>
                                    <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href=""><?php echo $post['title'] ?></a>
                                    <p class="m-0"><?php echo $post['description'] ?></p>
                                </div>
                                <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle mr-2" src="user/<?php echo $post['user'] ?>/avatar.jpg" width="25" height="25" alt="">
                                        <small><?php echo $post['user'] ?></small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <small class="ml-3"><i class="far fa-eye mr-2"></i>12345</small>
                                        <small class="ml-3"><i class="far fa-comment mr-2"></i>123</small>
                                    </div>
                                </div>
                            </div>
                       </a>
                        </div>


	<?php endforeach; ?>
</div>
                            <?php include("includes/footer.php"); ?>
                    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>
</body>
</html>

                <?php
                ?>