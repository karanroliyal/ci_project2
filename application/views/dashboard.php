<?php $title = "Dashboard";
include_once "templates/header.php" ?>

<div class="project-layout-main-wrapper">

    <div class="d-flex natigation_main_wrapper align-items-center bg-primary-my">
        <?php include_once "templates/navigation.php"; ?>
    </div>

    <div class="row sidebar_content_main_wrapper ">

        <div class="col-md-2 sidebar_wrapper">

            <?php include_once "templates/sidebar.php"; ?>


        </div>

        <div class="col-md-10 content_wrapper" >


            <div class="dashboard-container">

                <div class="row mt-2">

                    <div class="col-md-6 col-xl-3 col-sm-6 col-xs-6 mb-4">
                        <a class="card-link" href="<?= base_url() . "pagescontroller/usermaster" ?>">
                            <div class="d-flex dashboard-card rounded">

                                <div class="col-9 ">
                                    User Master
                                    <h4 class="bold-number" id='client'></h4>
                                </div>
                                <div class="col-3 bg-primary rounded text-light d-flex align-items-center justify-content-center"><i class="bi bi-person-fill-add"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-3 col-sm-6 col-xs-6 mb-4">
                        <a class="card-link" href="<?= base_url() . "pagescontroller/clientmaster" ?>">
                            <div class="d-flex dashboard-card rounded">

                                <div class="col-9 ">
                                    Client Master
                                    <h4 class="bold-number" id='user'></h4>
                                </div>
                                <div class="col-3 bg-primary rounded text-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-3 col-sm-6 col-xs-6 mb-4">
                        <a class="card-link" href="<?= base_url() . "pagescontroller/itemmaster" ?>">
                            <div class="d-flex dashboard-card rounded">

                                <div class="col-9 ">
                                    Item Master
                                    <h4 class="bold-number" id='item'></h4>
                                </div>
                                <div class="col-3 bg-primary rounded text-light d-flex align-items-center justify-content-center"><i class="bi bi-cart-plus-fill"></i></div>

                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-3 col-sm-6 col-xs-6 mb-4">
                        <a class="card-link" href="<?= base_url() . "pagescontroller/invoice" ?>">
                            <div class="d-flex dashboard-card rounded">

                                <div class="col-9 ">
                                    Total invoice
                                    <h4 class="bold-number" id='invoice'></h4>
                                </div>
                                <div class="col-3 bg-primary rounded text-light d-flex align-items-center justify-content-center"><i class="bi bi-receipt"></i></div>

                            </div>
                        </a>
                    </div>

                </div>


            </div>




        </div>

    </div>

</div>

<script>
    localStorage.setItem("tabName", "#dashoardTab");
</script>

<?php include_once "templates/footer.php" ?>