<?php
require_once 'includes/content/header.php';

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>Profile</small>
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
            <li class="active">Admin</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Main row -->
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="img/users/<?php echo (empty($user->data()->pic)) ? 'avatar-male.png' : $user->data()->pic ?>" alt="User profile picture">

                        <h3 class="profile-username text-center"><?php echo $user->data()->name ?></h3>
                        <p class="text-center" style="margin:-10px 0px 0px"><small><?php echo $user->data()->email?></small></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Date Joined</b> <span class="pull-right text-primary"><?php $date = new DateTime($user->data()->created); echo $date->format('d-M-Y');?></span>
                            </li>
                        </ul>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <form class="form-horizontal" method="post" action="updateuser" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputPhone" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" name="name" placeholder="name" value="<?php echo $user->data()->name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="<?php echo $user->data()->email; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password1" class="col-sm-2 control-label">New Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password1" name="password1" placeholder="new password" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password2" class="col-sm-2 control-label">Re-enter Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Re-enter password" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhoto" class="col-sm-2 control-label">Photo</label>

                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="inputPhoto" name="pic">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger" name="updateuser" value="update">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require_once 'includes/content/footer.php';
?>
