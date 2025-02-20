<?php $title = "Layout";
include_once "templates/header.php" ?>

<div class="project-layout-main-wrapper">

    <div class="d-flex natigation_main_wrapper align-items-center bg-primary-my">
        <?php include_once "templates/navigation.php"; ?>
    </div>

    <div class="row sidebar_content_main_wrapper ">

        <div class="col-md-2 sidebar_wrapper">
            
            <?php  include_once "templates/sidebar.php"; ?> 


        </div>

        <div class="col-md-10 content_wrapper">
            layout
        </div>

    </div>

</div>



<?php include_once "templates/footer.php" ?>