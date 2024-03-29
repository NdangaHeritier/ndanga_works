<?php 
session_start();
include '../connection.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>School Details</title>
	<link rel="stylesheet" type="text/css" href="../styles/details.css">
</head>
<body>
<div class="main">
	<div class="head">
		<img src="../images/dots.png" width="3" height="13"> Manage School Details
	</div>
    <div class="boxes">
    	
        <div class="part">
            <div class="banner">
                <img src="../images/hehe.png" width="20" height="30">
                <a>Search Classes's Information</a>
            </div>
            <div class="detail">
                <div class="form">
                <form method="POST">
                    <div class="input-field">
                        <input type="text" name="search-field3" placeholder="Type Class Name To Search">
                        <button type="submit" name="search-button3">
                            <img src="../images/search.png" width="30" height="30">
                        </button>
                    </div>
                </form>
                <div class="search-results">
                    <?php 
                        if (isset($_POST['search-button3'])) {
                            $search_field=substr($_POST['search-field3'], 7);
                            $qry=mysqli_query($con,"select classes.*, teachers.* from classes, teachers where classes.ClassName='$search_field' And teachers.teacher_ID=classes.ClassTeacher");
                            
                            $fetch_query=mysqli_fetch_array($qry);
                            if (is_array($fetch_query)) {
                                $class=$fetch_query['class_ID'];
                                $qry2=mysqli_query($con,"select count(*) as nc from lessons where class_ID='$class'");
                                $qry3=mysqli_query($con,"select * from lessons where class_ID='$class'");
                                $fetch_query2=mysqli_fetch_array($qry2);
                                $cur_year=date('Y');
                                ?>
                                <div class="details padd">
                                    <div class="fullname">
                                        <img src="../images/home.png" width="30" height="30">
                                        Senior <?php echo $fetch_query['ClassName']; ?>
                                    </div>
                                    <div class="other padd">
                                        <p><b>Available Lessons: </b><a class="title"><?php echo $fetch_query2['nc']; ?></a> modules.</p>
                                        <p><b>Class Teacher: </b><?php echo $fetch_query['FullName']; ?></p>
                                        <div class="top">
                                            <div class="li title">
                                                Lessons taught In S<?php echo $fetch_query['ClassName']; ?>
                                            </div>
                                           <?php
                                                while ($fetch_query3=mysqli_fetch_array($qry3)) {
                                                    ?>
                                                    <div class="li">
                                                        <img src="../images/right.png" width="35" height="30">
                                                        <div class="contents padd">
                                                            <b><?php echo $fetch_query3['Title']; ?></b> With <b><?php echo $fetch_query3['Credits']; ?></b> Credits.
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                           ?>
                                        </div>
                                    </div>
                                    <div class="go li top">
                                        <a href="edit-class-info.php?tid=<?php echo $fetch_query['class_ID'];?>">edit</a>
                                        <a href="delete-class-info.php?tid=<?php echo $fetch_query['class_ID'];?>">delete</a>
                                    </div>
                                </div>
                                
                                <?php
                            }else{
                                echo "<i> <b>Class Not found!</b> No data matches with your seach <b><< $search_field >></b></i>";
                            }
                        }
                    ?>
                    <div class="li top color2">

                        <div class="all w2">All Registered Teachers</div>
                        <div class="btn">
                            <button onclick="window.print()" class="print-btn no">print</button>
                        </div>
                    </div>
                    <div class="li">
                <?php 
                    $second=mysqli_query($con,"select classes.*,teachers.* from classes,teachers where teachers.teacher_ID=classes.ClassTeacher");
                    if (mysqli_num_rows($second)> 0) {
                        ?>
                        <table border='1'>
                            <tr>
                                <thead class="color2">
                                    <th>No</th>
                                    <th>Names</th>
                                    <th>Class Teacher</th>
                                    <th>Lessons</th>
                                    <th class="no"></th>
                                </thead>
                            </tr>
                            <?php 
                                $n=1;
                                while($fetch_second=mysqli_fetch_array($second)){
                            ?>
                            <tr class="color padd medium">
                                <td><?php echo $n;?></td>
                                <td>Level <?php echo $fetch_second['ClassName'];?></td>
                                <td>
                                    <?php echo $fetch_second['FullName'];?>
                                </td>
                                <td>
                                   <?php
                                        $cla=$fetch_second['class_ID'];  
                                        $sel=mysqli_query($con,"select count(*) as nn from lessons where class_ID='$cla'");
                                        $fsel=mysqli_fetch_array($sel);
                                        echo $fsel['nn'];
                                    ?> 
                                </td>
                                <td class="no">
                                    <a class="button small" href="edit-class-info.php?tid=<?php echo $fetch_second['class_ID'];?>">edit</a>
                                    <a class="button small color3" href="delete-class-info.php?tid=<?php echo $fetch_second['class_ID'];?>">delete</a>
                                </td>
                            </tr>
                            <?php
                            $n++;
                                }
                            ?>
                        </table>
                        <?php
                    }else{
                        echo "No data found!";
                    }
                ?>
            </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>