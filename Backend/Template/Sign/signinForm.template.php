<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Signin - Feel Blog</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= PUBLIC_URL ;?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= PUBLIC_URL ;?>/css/signin.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">        
      <form class="form-signin" role="form" action="<?=U('Sign/signin');?>" method="post">
         
        <h2 class="form-signin-heading">Please sign in</h2>
        <?= isset($alert) ? $alert : '' ;?>
        <input type="email" name="email" value="<?=isset($email)?$email:'';?>" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" name="remember_me" value="remember_me" <?=isset($remember_me)?'checked':'';?>> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

    <script src="<?= PUBLIC_URL; ?>/js/jquery.js"></script>
    <script src="<?= PUBLIC_URL; ?>/js/sha1.js"></script>
    <script>
        $(".form-signin").on("submit", function () {
           var pwd = $("input[name=password]", this);
           pwd.val(SHA1(pwd.val()));
           return true;
        });
    </script>
  </body>
</html>
