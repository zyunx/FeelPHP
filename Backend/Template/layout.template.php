<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>FeelBlog Dashboard</title>

        <!-- Bootstrap core CSS -->
        <link href="<?= PUBLIC_URL; ?>/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?= PUBLIC_URL; ?>/css/dashboard.css" rel="stylesheet">
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">FeelBlog Backend</a>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="<?= ACTION_CLASS == 'Index' ? 'active' : ''; ?>"><a href="<?= U('/Index/index'); ?>">Overview</a></li>
                        <li class="<?= ACTION_CLASS == 'User' ? 'active' : ''; ?>">
                            <a href="<?= U('User/index'); ?>">
                                <span class="glyphicon glyphicon-user"></span> User
                            </a>
                        </li>
                        <li><a href="<?= U('Post/index');?>">Post</a></li>
                        <li><a href="#">Comment</a></li>
                        <li><a href="#">Categroy</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?=U('Sign/logout');?>">Logout</a></li>
                        <!--
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Help</a></li>-->
                    </ul>
                    <!--
                    <form class="navbar-form navbar-right">
                        <input type="text" class="form-control" placeholder="Search...">
                    </form>-->
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <?php include APP_TEMPLATE_PATH . '/' . ACTION_CLASS . '/menu.template.php'; ?>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= empty($alert) ? '' : $alert; ?>
                        </div>
                        <div class="col-sm-12">
                            <?php include $layout_content ?>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?= PUBLIC_URL; ?>/js/jquery.js"></script>
        <script src="<?= PUBLIC_URL; ?>/js/bootstrap.min.js"></script>
        <script src="<?= PUBLIC_URL; ?>/js/docs.min.js"></script>

        
        <script>
            $('.anchor').on("click", function() {
                if ($(this).data('anchor-href') !== undefined) {
                    document.location = $(this).data('anchor-href');
                }
            });
        </script>
        
        <script src="<?= PUBLIC_URL; ?>/js/sha1.js"></script>
    <script>
        $("form").on("submit", function () {  
           var pwd = $("input[name=password]", this);
           pwd.val(SHA1(pwd.val()));
           return true;
        });
    </script>

    </body>
</html>
