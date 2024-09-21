<?php include('../includes/config.php') ?>

<?php
if (isset($_POST['submit'])) {
    $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';
    $section_id = isset($_POST['section_id']) ? $_POST['section_id'] : '';
    $teacher_id = isset($_POST['teacher_id']) ? $_POST['teacher_id'] : '';
    $lecture_id = isset($_POST['lecture_id']) ? $_POST['lecture_id'] : '';
    $day_name = isset($_POST['day_name']) ? $_POST['day_name'] : '';
    $subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : '';
    $date_add = date('Y-m-d g:i:s');
    $status = 'publish';
    $author = 1;
    $type = 'timetable';

    $query = mysqli_query($db_connection, "INSERT INTO `posts` (`type`,`author`,`status`,`publish_date`) VALUES ('$type','$author','$status','$date_add') ");

    if ($query) {
        $item_id = mysqli_insert_id($db_connection);
    }

    $metadata = array(
        'class_id' => $class_id,
        'section_id' => $section_id,
        'teacher_id' => $teacher_id,
        'lecture_id' => $lecture_id,
        'day_name' => $day_name,
        'subject_id' => $subject_id,
    );

    foreach ($metadata as $key => $value) {
        $query = mysqli_query($db_connection, "INSERT INTO `metadata` (`item_id`,`meta_key`,`meta_value`) VALUES ('$item_id','$key','$value') ");
    }
    header('Location: tt.php');
}
?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Time Table

                    <a href="?action=add" class="btn btn-success btn-sm">Add New</a>
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Time Table</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <section class="content">
        <div class="container-fluid">

            <?php if (isset($_GET['action']) && $_GET['action'] == 'add') { ?>
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="from-group">
                                        <label for="class_id">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-select">
                                            <option value="" selected disabled>--Select Class--</option>
                                            <?php
                                            $args = array('type' => 'class', 'status' => 'publish', );
                                            $classes = get_posts($args);
                                            foreach ($classes as $key => $class) { ?>
                                                <option value="<?php echo $class->id ?>"><?php echo $class->title ?>
                                                </option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group" id="section-container">
                                        <label for="section_id">Select Section</label>
                                        <select name="section_id" id="section_id" class="form-select">
                                            <option value="" selected disabled>--Select Section--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group" id="section-container">
                                        <label for="teacher_id">Select Teacher</label>
                                        <select name="teacher_id" id="teacher_id" class="form-select">
                                            <option value="" selected disabled>--Select Teacher--</option>
                                            <?php 
                                                 
                                                $args=array('user_type'=>'teacher');
                                                $teacher = get_users($args);
                                                print_r($teacher);
                                                foreach ($teacher as $teacher_name) { ?> 
                                                    <option value="<?php echo $teacher_name -> id ?>"><?php echo $teacher_name -> name ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group" id="section-container">
                                        <label for="lecture_id">Select Lecture</label>
                                        <select name="lecture_id" id="lecture_id" class="form-select">
                                            <option value="" selected disabled>--Select Lecture--</option>
                                            <?php
                                            $args = array('type' => 'lecture', 'status' => 'publish', );
                                            $lecture = get_posts($args);
                                            foreach ($lecture as $key => $lectur) { ?>
                                                <option value="<?php echo $lectur->id ?>"><?php echo $lectur->title ?>
                                                </option>
                                            <?php }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group" id="section-container">
                                        <label for="day_name">Select Day</label>
                                        <select name="day_name" id="day_name" class="form-select">
                                            <option value="" selected disabled>--Select Day--</option>
                                            <?php
                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                            foreach ($days as $key => $day) { ?>
                                                <option value="<?php echo $day ?>"><?php echo ucwords($day) ?>
                                                </option>
                                            <?php }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group" id="section-container">
                                        <label for="subject_id">Select Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-select">
                                            <option value="" selected disabled>--Select Subject--</option>
                                            <option value="70">Math</option>
                                            <option value="71">English</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <label for="">&nbsp;</label>
                                        <input type="submit" value="submit" name="submit"
                                            class="btn btn-success form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                <div class="card">
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="from-group">
                                        <label for="class">Select Class</label>
                                        <select name="class" id="class" class="form-select">
                                            <option value="" selected disabled>--Select Class--</option>
                                            <?php
                                            $args = array('type' => 'class', 'status' => 'publish', );
                                            $classes = get_posts($args);
                                            foreach ($classes as $key => $class) { ?>
                                                <option value="<?php echo $class->id ?>"><?php echo $class->title ?>
                                                </option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" id="section-container">
                                        <label for="Section">Select Section</label>
                                        <select name="section" id="Section" class="form-select">
                                            <option value="" selected disabled>--Select Section--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Timing</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <!-- <th>Sunday</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                //lecture -> periodes to change
                                <?php
                                $args = array('type' => 'lecture', 'status' => 'publish');
                                $lecture = get_posts($args);
                                foreach ($lecture as $lectur) {
                                    $from = get_metadata($lectur->id, 'from')[0]->meta_value;

                                    $to = get_metadata($lectur->id, 'to')[0]->meta_value;
                                    ?>
                                    <tr>
                                        <td><?php echo date('h:i A', strtotime($from)) ?> -
                                            <?php echo date('h:i A', strtotime($to)) ?>
                                        </td>

                                        <?php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                        foreach ($days as $day) {
                                            $query = mysqli_query($db_connection, "SELECT * FROM posts as p 
                                                        INNER JOIN metadata as md ON (md.item_id = p.id) 
                                                        INNER JOIN metadata as mp ON (mp.item_id = p.id) 
                                                        WHERE 
                                                        p.type ='timetable' AND p.status = 'publish' 
                                                        AND md.meta_key = 'day_name' AND md.meta_value = '$day' 
                                                        AND mp.meta_key = 'lecture_id' AND mp.meta_value =   $lectur->id");

                                            if (mysqli_num_rows($query) > 0) {
                                                while ($timetable = mysqli_fetch_object($query)) {
                                                        
                                                    ?>
                                                    <td>
                                                        
                                                        <p>
                                                            <b>Teacher: </b>
                                                            <?php
                                                            $teacher_id = get_metadata($timetable->item_id, 'teacher_id', )[0]->meta_value;
                                                            echo get_user_data($teacher_id)->name;
                                                            ?> <br>
                                                            <b>Class: </b> <?php
                                                                $class_id = get_metadata($timetable->item_id, 'class_id', )[0]->meta_value;
                                                                echo get_post(array('id'=>$class_id))->title;
                                                            ?> <br>
                                                            <b>Section: </b>
                                                            <?php  $section_id = get_metadata($timetable->item_id, 'section_id', )[0]->meta_value;
                                                            echo get_post(array('id'=>$section_id))->title; ?> 
                                                            <br>
                                                            <b>Subject: </b> 
                                                                <?php  $subject_id = get_metadata($timetable->item_id, 'subject_id', )[0]->meta_value;
                                                                echo get_post(array('id'=>$subject_id))->title; ?>  
                                                            <br>
                                                        </p>
                                                    </td>
                                                <?php }
                                            } else { ?>
                                                <td>
                                                    Unscheduled !
                                                </td>
                                            <?php }
                                        } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php } ?>
        </div>
        <!--/. container-fluid -->
    </section>

</div>
<!-- /.content-header -->
<script>
    // SUBJECTS 

    jQuery(document).ready(function () {

        jQuery('#class_id').change(function () {
            // alert(jQuery(this).val());
            jQuery.ajax({
                url: 'ajax.php',
                type: 'POST',
                data: { 'class_id': jQuery(this).val() },
                dataType: 'json',
                success: function (response) {

                    if (response.length > 1) {
                        jQuery('#section-container').show();
                        // for(let i=0 ; i<response.length ; i++){
                        //     const element =response[i+1];
                        //     jQuery('#Section').append(element);
                        // }
                        jQuery('#section_id').html(response);
                    }
                    else {
                        jQuery('#section-container').hide();
                    }
                }
            })
        })

    })
</script>
<?php include('footer.php'); ?>