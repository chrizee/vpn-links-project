<?php
require_once 'includes/content/header.php';
$vpn = $vpnObj->get(['status', '=', '1']);
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
            <div class="col-md-3">
                <button class="btn btn-primary btn-block margin-bottom add_new">Add new vpn</button>
            </div>

            <div class="col-md-9 default">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">All VPNs (<?php echo Vpn::getTotal(); ?>)</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-group">
                        <?php 
                          foreach ($vpn as $key => $value) { ?>
                            <li class="list-group-item">
                              <p class="text text-success text-bold"><strong>URL:</strong> <?php echo escape($value->url) ?></p>
                              <p class="text text-info text-bold"><strong>Username:</strong> <?php echo escape($value->username) ?></p>
                              <p class="text text-danger text-bold"><strong>Password:</strong> <?php echo escape($value->password) ?></p>
                              <p>
                                <div class="row">
                                    <div class="col-md-9"></div>
                                    <div class="col-md-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      <a href="editvpn=<?php echo $value->id?>"><button class="btn btn-info btn-sm">Edit</button></a>
                                      <a href="deletevpn=<?php echo $value->id?>" class="delete"><button class="btn btn-danger btn-sm">Delete</button></a>
                                  </div>
                              </div>
                              </p>
                            </li>
                        <?php } 
                        ?>
                      </ul>
                    </div>
                    <!-- /. box -->
                </div>
            </div>

            <div class="col-md-9 create hidden">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">New VPN</h3>
                    </div>
                    <div class="box-body">
                        <form role="form" class="" method="post" action="addvpn" id="create">
                            <div class="form-group">
                                <label for="url">Url</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="url" name="url" value="<?php echo escape(Input::get('url'))?>" required>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo escape(Input::get('username'))?>" required>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="password" name="password" required>

                                </div>
                            </div>

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" name="vpn" value="Add">
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
    <script type="text/javascript" src="plugins/jQueryUI/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('div.input-group').css("width", "100%");
        $(document).on('click', "button.add_new", function() {
          if($("div.create").hasClass('hidden')) {
            $('div.create').removeClass('hidden');
            $('div.default').addClass('hidden');
          }else {
            $('div.default').removeClass('hidden');
            $('div.create').addClass('hidden');
          }
        }).on('click', "a.delete", function(e) {
          var pass = confirm("Are you sure you want delete this vpn?");
          if(!pass) {
            e.preventDefault();
          }
        })
    })
</script>
<?php
require_once 'includes/content/footer.php';
?>