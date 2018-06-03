<?php
require_once 'includes/content/header.php';
if(!empty($Qstring)) {
    $vpn = $vpnObj->get(['id', '=', escape($Qstring)]);
    if(empty($vpn)) {
        Session::flash('home', "Select a valid VPN");
        Redirect::to('dashboard');    
    }
}else {
    Session::flash('home', "Select a valid VPN");
    Redirect::to('dashboard');
}
$vpn = $vpn[0];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>Control panel</small>
        </h1>
        <?php if(Session::exists('home')) {
            echo "<p class='text text-center'>".Session::flash('home')."</p>";
        }
        if(Session::exists('errors')) {
            $arr = explode("::", Session::flash('errors'));
            foreach ($arr as  $value) {
                echo "<p class='text text-center'>$value</p>";
            }
        }
        ?>
        <p class="text text-center text-info msg hidden"></p>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">VPN</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit VPN</h3>
                    </div>
                    <div class="box-body">
                        <form role="form" class="" method="post" action="addvpn">
                            <div class="form-group">
                                <label for="url">Url</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="url" name="url" value="<?php echo escape($vpn->url)?>" required>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $Qstring ?>">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo escape($vpn->username)?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo escape($vpn->password)?>" required>
                                </div>
                            </div>

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" name="vpnEdit" value="Edit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require_once 'includes/content/footer.php';
?>