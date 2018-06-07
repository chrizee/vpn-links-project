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
                        <form role="form" class="" method="post" action="addvpn" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="url">Url</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="url" name="url" value="<?php echo escape($vpn->url)?>" required>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo escape($Qstring) ?>">
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

                            <div class="form-group">
                                <label for="file"><?php echo (!empty($vpn->file_url)) ? 'Change': 'Add' ?> Config File</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="file" name="file" >
                                </div>
                            </div>

                            <div class="form-group add-extra">
                                <div class="input-group">
                                    <i style="cursor: pointer" class="text-danger fa fa-plus"><small> edit extra fields</small></i>
                                </div>
                            </div>

                            <div class="extra hidden">
                                <div class="form-group">
                                    <label for="name">Server Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo escape($vpn->server_name)?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="country" name="country" value="<?php echo escape($vpn->country)?>">
                                    </div>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('div.input-group').css("width", "100%");
            $(document).on('click', "div.add-extra", function() {
                if($('div.extra').hasClass('hidden')) {
                    $("div.extra").removeClass('hidden');
                    $('div.add-extra').find('small').text(" close");
                }else {
                    $("div.extra").addClass('hidden');
                    $('div.add-extra').find('small').text(" add extra fields");
                }
            })
        })
    </script>
<?php
require_once 'includes/content/footer.php';
?>