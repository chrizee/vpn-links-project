 <?php
  require_once 'core/init.php';
  $user = new User();
  if($user->isLoggedIn()) {
    $user->logout();
  }
  $errors = array();
  if(Input::exists() && isset($_POST['login']) ) {
    
    if(Token::check(Input::get('token'))) {
      
      $validate = new Validate();

      $validation = $validate->check($_POST, array(
        'email' => array('required' => true),
        'password' => array('required' => true),
      ));

      if($validation->passed()) {
        $remember = (Input::get('remember') === 'on') ? true : false;
        $login = $user->login(Input::get('email'), Input::get('password'), $remember);

        if($login) {
          print_r($_POST);
          Redirect::to('dashboard');
        } else {
          foreach ($user->errors() as $error) {
            $errors[] = $error;
          }
        }
      } else {
        foreach($validation->errors() as $error) {
          $errors[] = $error;
          //echo $error. '<br>';
        }
      }
    } 
  }

  if($errors) {
    $err = implode('<br>', $errors);
    Session::flash('home', $err);
    //Redirect::to('login');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo Config::get('app/title') ?> | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/Admin.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b><?php echo str_replace('|', '', Config::get('app/name')) ?></b>
    <P class="text-center text-sm text-danger"><?php
    if(Session::exists('home')) echo Session::flash('home');
    ?></P>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start application</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email" required="required" autocomplete="off" autofocus="on">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">

        <!-- /.col -->
        <div class="col-xs-4 pull-right">
          <input type="submit" name="login" class="btn btn-primary btn-block btn-flat" value="Sign In">
        </div>
        <!-- /.col -->
      </div>
      <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
    </form>

    <!--<a href="forgotpassword">I forgot my password</a><br>-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../scripts/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
