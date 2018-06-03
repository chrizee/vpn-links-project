<?php
require_once 'includes/content/header.php';

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>New Admin</small>
        </h1>
        <?php if(Session::exists('home')) {
            echo "<p class='text text-center text-danger'>".Session::flash('home')."</p>";
        }
        if(Session::exists('errors')) {
            $arr = explode("::", Session::flash('errors'));
            foreach ($arr as  $value) {
                echo "<p class='text text-center'>$value</p>";
            }
        }
        ?>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Register</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <div class="box box-primary big">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter details  </h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="adduser" id="admin" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo escape(Input::get('name'))?>">
                                    <div class="input-group-addon">
                                        <i class="text-success fa fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo escape(Input::get('email'))?>">
                                    <div class="input-group-addon">
                                        <i class="text-success fa fa-envelope"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password1">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password1" name="password1" value="<?php echo escape(Input::get('password1'))?>">
                                    <div class="input-group-addon">
                                        <i class="text-success fa fa-lock"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password2">Re-enter password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password2" name="password2" value="<?php echo escape(Input::get('password2'))?>">
                                    <div class="input-group-addon">
                                        <i class="text-success fa fa-lock"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pic">Profile Pic</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="pic" name="pic" value="">
                                    <div class="input-group-addon">
                                        <i class="text-success fa fa-photo"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="staff" value="Submit">
                        </div>
                    </form>

                </div>
                <!-- /.box -->
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require_once 'includes/content/footer.php';
?>
