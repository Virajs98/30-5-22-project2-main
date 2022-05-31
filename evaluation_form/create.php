<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user_master_id'])) {
    $page_title = "admin_team";
    $Dashboard = "ADMIN";
    $Department = "DEPARTMENT";
    $Employee = "EMPLOYEE";
    $Dashboard_link = "../admin/admin-dashboard.php";
    $Department_link = "../department/create_dept.php";
    $All_Employee = "ALL EMPLOYEES";
    $My_Team = "MY TEAM";
    $AllEmployee_link = "../admin/allEmployee.php";
    $MyTeam_link = "../admin/admin_myteam.php";
    $Parameter = "PARAMETER";
    $Parameter_link = "../parameter/view_para.php";
    include "../master/db_conn.php";
    include "../master/pre-header.php";
    include "../master/close_header.php";
?>

    <?php
    include "../master/header.php";
    include "../master/navbar_admin.php";
    include "../master/breadcrumbs.php";
    ?>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('assets/images/others/login-3.png')">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    <div class="row align-items-center w-100">
                        <div class="col-md-7 col-lg-11 m-h-auto">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between m-b-30">
                                        <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                                    </div>
                                    <form action="insert.php" method="POST">
                                        <input type='hidden' id='form_id' name='form_id' value='
                                        <?php echo uniqid();
                                        ?>
                                        '>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <div class="form-group">
                                                <input type="date" class="form-control" id="myDate" name="myDate" disabled />
                                            </div>
                                        </div>
                                        <?php if (isset($_GET['error'])) { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?= $_GET['error'] ?>
                                            </div>
                                        <?php } ?>
                                        <!-- form-task-start -->
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="title">Task Title:</label>
                                            <div class="input-affix">
                                                <select class="form-control" id="title" name="title">
                                                    <option value="" disabled selected hidden>Please Select</option>
                                                    <?php
                                                    //$id = $_SESSION['user_master_id'];
                                                    $sql = "SELECT task_id,task_title FROM task_master WHERE is_deleted=0  ORDER BY task_id ASC ";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = $result->fetch_assoc()) :
                                                    ?>
                                                        <option value="<?php echo $row['task_id']; ?>"> <?php echo $row['task_title']; ?></option>
                                                    <?php
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- form-task-end -->
                                        <!-- form-evaluation-start -->
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="desc">Evaluation:</label>
                                            <div class="input-affix">
                                                <i class="prefix-icon anticon anticon-user"></i>
                                                <input type="text" class="form-control" id="desc" name="desc" placeholder="task_eval" required>
                                            </div>
                                        </div>
                                        <!-- form-evaluation-end -->
                                        <!-- form-para drop list-start 
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" for="para">Parameter</label>
                                            <select class="form-control" id="para" name="para">
                                                <option value="" disabled selected hidden>Please Select</option>
                                                <?php
                                                /*$sql = "SELECT para_id,para_title FROM para_master WHERE is_deleted = 0 ORDER BY para_id ASC ";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = $result->fetch_assoc()) :
                                                ?>
                                                    <option value="<?php echo $row['para_id']; ?>"> <?php echo $row['para_title']; ?></option>
                                                <?php
                                                endwhile;
                                                */ ?>
                                            </select>
                                        </div>
                                         form-para drop list-end -->


                                        <!-- form-checkbox -start -->
                                        <div class="form-group">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"><label >parameters</label></th>
                                                        <th scope="col"><label >Min-Rate</label></th>
                                                        <th scope="col"><label >Max-Rate</label></th>
                                                        <th scope="col"><label >Your-Rate</label></th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $sql = "SELECT para_id,para_title,min_rating,max_rating FROM para_master WHERE is_deleted = 0 ";
                                                $result = mysqli_query($conn, $sql);
                                                $para = array();?>
                                                <tbody>
                                                    <?php
                                                while ($row = $result->fetch_assoc()) : ?>
                                                    
                                                        <tr>
                                                            <?php

                                                            $id = $row['para_id'];
                                                            //$query = "SELECT min_rating,max_rating FROM para_master WHERE para_id=$id";
                                                            //$res = mysqli_query($conn, $query);
                                                            //$row1 = mysqli_fetch_assoc($res)
                                                            ?>
                                                            <td><input type="checkbox" name = "parameter_<?php echo $row['para_id']; ?>" value="<?php echo $row['para_id'];?>">
                                                                <label  ><?php echo $row['para_title']; ?></label>
                                                                </td>
                                                            <td>
                                                                <input type="text" disabled maxlength="2" size='3' name=" min_rating" value="<?php echo $row['min_rating']; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" disabled maxlength="2" size='3' name="max_rating" value="<?php echo $row['max_rating']; ?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="2" size='3' name="rating_<?php echo $row['para_id']; ?>">
                                                            </td>
                                                        </tr>

                                                    
                                                <?php
                                                endwhile;
                                                ?>
                                                </tbody>
                                            </table>


                                        </div>
                                        <!-- form-checkbox 
                                        -------------------------Range Slider start-----------------------------
                                        <h6>Rating</h6>
                                        <div class="slidecontainer">
                                            <input type="range" min="1" max="100" class="slider" id="myRange">
                                            <p>Value: <span id="demo"></span></p>
                                        </div>

                                        <script>
                                            var slider = document.getElementById("myRange");
                                            var output = document.getElementById("demo");
                                            output.innerHTML = slider.value;

                                            slider.oninput = function() {
                                                output.innerHTML = this.value;
                                            }
                                        </script>
                                        --------------------------Range Slider end -------------------------------------------------------
                                         form-employee -start -->

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" for="employee">Employee</label>
                                            <select class="form-control" id="employee" name="employee">
                                                <option value="" disabled selected hidden>Please Select</option>
                                                <?php
                                                $id = $_SESSION['user_master_id'];
                                                $sql = "SELECT user_master_id,name FROM user_master WHERE is_deleted=0 AND manager_id = $id ORDER BY user_master_id ASC ";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = $result->fetch_assoc()) :
                                                ?>
                                                    <option value="<?php echo $row['user_master_id']; ?>"> <?php echo $row['name']; ?></option>
                                                <?php
                                                endwhile;
                                                ?>
                                            </select>
                                        </div>
                                        <!-- form-employee -end -->
                                        <!-- form-submit -start -->
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <button class="btn btn-primary" name="submit" value='submit' id='submit'>Submit</button>
                                            </div>
                                        </div>
                                        <!-- form-submit -end -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        function SetDate() {
            var date = new Date();

            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

            if (month < 10) month = "0" + month;
            if (day < 10) day = "0" + day;

            var today = year + "-" + month + "-" + day;


            document.getElementById('myDate').value = today;
        }
    </script>
    </head>

    <body onload="SetDate();">
    <?php } else {
    header("Location:../login.php");
}
include "../master/footer.php";
include "../master/after-footer.php";
