
<?php require_once '../model.php'; ?>

<?php $post = getPostById($_GET['id']); ?>

<html lang="es-ES">
<?php
include("head.php");
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>MrTico - <?php echo $post['title'] ?>
    </title>
</head>
   
<body class="size-960">
    
              <?php
include("cabecera.php");
?>

            <div class="line">
                <div class="item no-bottom-padding white-bg mod-banner">
                    <img class="mod-banner" src="media/blog_1/banner.jpg" alt="">
                </div>
                <div class="box margin-bottom mod-title">
                    <div class="s-12 l-12">
                        <h2><?php echo $post['title'] ?></h2>
                        <p>
                           <?php echo $post['id'] ?><?php echo $post['title'] ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="line">
                <div class="box margin-bottom">
                    <div class="margin">
                        <article class="s-12 l-7">
                            <h1><?php echo $post['date'] ?></h1>
                            <p>
                              	<?php echo $post['content'] ?>
  </p>
                            <br>
                            </div>
   </div>
   </div>

            <?php include("pie.php"); ?>
</body>
</html>
    