<!DOCTYPE html>
<html lang="cn">
  <head>
    <meta charset="utf-8">
    <!--
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
-->
    <title>Blog Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="Public/css/blog.css" rel="stylesheet">
  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item <?= ACTION_CLASS == 'Index' ? 'active' : ''; ?>" href="index.php?s=/Index/index">Home</a>
          <a class="blog-nav-item" href="#">New features</a>
          <a class="blog-nav-item" href="#">Press</a>
          <a class="blog-nav-item" href="#">New hires</a>
          <a class="blog-nav-item <?= ACTION_CLASS == 'About' ? 'active' : ''; ?>" href="index.php?s=/About/index">About</a>
        </nav>
      </div>
    </div>

      
    <?php
    $content = APP_TEMPLATE_PATH . '/' . ACTION_CLASS . '/' . ACTION_METHOD . '.template.php'; 
    include $content;
    //var_dump($content);
    ?>
      
      
    <div class="blog-footer">
      <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="Public/js/jquery.js"></script>
    <script src="Public/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
  </body>
</html>