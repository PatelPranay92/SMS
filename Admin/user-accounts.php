<?php include('../includes/config.php')?>
<?php
$error = "";
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5(1234567890);
    $type = $_POST['type'];

    $check_query = mysqli_query($db_connection , "SELECT * FROM user_accounts where email = '$email'");
    if(mysqli_num_rows($check_query) > 0){
        $error = "Email already exists";
    }
    else{
        mysqli_query($db_connection , "INSERT INTO user_accounts (`name` , email , user_type , `password`) VALUES ('$name','$email','$type','$password')") or die(mysqli_error($db_connection));
        $_SESSION['success_msg'] = "User has been succesfuly registered";
        header("Location: user-accounts.php?user=" . $type);
        exit;
    }
}

?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Accounts</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Account</a></li>
                    <li class="breadcrumb-item active"><?php echo ucfirst($_REQUEST['user']) ?></li>
                </ol>
            </div><!-- /.col -->
            <?php
            if(isset($_SESSION['success_msg'])){?>
            <div class="toast-container top-0 end-0 p-3">   
                <div class="toast show fade" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true" >
                    <div class="toast-body">
                        <div class="d-flex gap-4">
                            <span class="text-primary"><i class="fa-solid fa-circle-info fa-lg"></i></span>
                            <div class="d-flex flex-grow-1 align-items-center">
                                <span class="fw-semibold">
                                    <?=$_SESSION['success_msg']?>
                                </span>
                                <button type="button" class="btn-close btn-close-sm btn-close-black ms-auto"
                                    data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                unset($_SESSION['success_msg']);
                }
                ?>
            <div>
            <a href="user-accounts.php?user=<?php echo $_REQUEST['user']; ?>&action=add-new" class="ms-auto btn btn-success btn-sm float-end">Add new</a>
            </div>
        </div><!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <section class="content">
        <div class="container-fluid">
            <?php 
            if(isset($_GET['action']) && $_GET['action']){?>
            <div class="card">
                <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Full Name" name="name" autocomplete="true" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Address" name="email" autocomplete="true" required>
                        <small class="text-danger"><?php echo $error; ?></small>
                    </div>
                    <input type="hidden" name="type" value="<?php echo $_REQUEST['user'] ?>">
                    <button type="submit" name="submit" class="btn btn-primary">Register</button>
                </form>
                </div>
            </div>
            <?php 
            } else{
            ?>
            <!-- Info boxes -->
            <div class="table-responsive">
                <table class="table table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1; 
                            $user_query = 'SELECT * FROM user_accounts WHERE user_type = "'.$_REQUEST['user'].'"';
                            $user_result = mysqli_query($db_connection , $user_query);
                            while($users = mysqli_fetch_object($user_result)){
                            ?>
                        <tr>
                            <td><?=$count++ ?></td>
                            <td><?=$users->name ?></td>
                            <td><?=$users->email ?></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php 
        }
        ?>
            <!-- /.row -->
        </div>
        <!--/. container-fluid -->
    </section>

</div>
<!-- /.content-header -->
<?php include('footer.php'); ?>