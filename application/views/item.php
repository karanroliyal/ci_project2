<?php $title = "Item";
include_once "templates/header.php" ?>

<div class="project-layout-main-wrapper">

    <div class="d-flex natigation_main_wrapper align-items-center bg-primary-my">
        <?php include_once "templates/navigation.php"; ?>
    </div>

    <div class="row sidebar_content_main_wrapper ">

        <div class="col-md-2 sidebar_wrapper">

            <?php include_once "templates/sidebar.php"; ?>


        </div>

        <div class="col-md-10 content_wrapper">

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All item</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Add item</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!-- Live search form with users table  -->
                <div class="tab-pane fade show active tab-padding" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                    <div class="w-100">

                        <!-- Live search form start -->
                        <form class="tableDataForm row align-items-center my-bg-b my-color" id="liveSearchForm">


                            <div class="col-md-3 col-sm-6 col-xl-3 mt-2">
                                <label for="searchName" class="form-label">Item name</label>
                                <input type="text" name="item_name" id="searchName" class="form-control">
                            </div>

                            <div class="col-md-2 col-sm-6 col-xl-2 mt-5 d-flex justify-content-center">
                                <button onclick="resetLoadTable()" type="reset" class="btn btn-danger">reset</button>
                            </div>

                            <input type="hidden" name="table_name" value="item_master">
                            <input type="hidden" name="columnToShow" value="id,item_name,item_description,item_price,image"> <!-- order also be same as table shown on frontend -->
                            <input type="hidden" name="currentPage" id="pageId" value="1">
                            <input type="hidden" name="pageLimit" id="limit" value="5">
                            <input type="hidden" name="sortOn" id="sortOn" value="id">
                            <input type="hidden" name="sortOrder" id="sortOrder" value="DESC">
                            <input type="hidden" name="imagePath" id="imagePathId" value="items" >


                        </form>
                        <!-- Live search form end -->

                        <!-- pagination and limit of records select start  -->
                        <div class="d-flex justify-content-between align-items-end mb-3 mt-3">

                            <!-- select limit  -->
                            <div>
                                <label for="rowId" class="form-label">Select no. of rows</label>
                                <select id="rowId" class="form-select-sm">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <!-- select limit  -->

                            <!-- pagination  -->
                            <div class="dynamicPagination">
                                <!-- dynamic pagination comes here  -->
                                js
                            </div>
                            <!-- pagination  -->

                        </div>
                        <!-- pagination and limit of records select end  -->

                        <!-- Dynamic table and pagination start  -->
                        <div class="table-container mt-4">

                            <!-- Showing Data table start  -->
                            <table class="table">

                                <thead>
                                    <th>Sno.</th>
                                    <th class="sortingClass" data-sort="id">Id <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="item_name">Item name <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="item_description">Item description <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="item_price">Price <i class="bi bi-arrow-down-up"></i></th>
                                    <th>Image </th>
                                    <th colspan="2" class="text-center">Action</th>
                                </thead>

                                <tbody class="myDynamicTable">
                                    <!-- here my dynamic table will come  -->
                                </tbody>

                            </table>
                            <!-- Showing Data table end  -->

                        </div>
                        <!-- Dynamic table and pagination end  -->



                    </div>

                </div>
                <!-- Adding Data into database -->
                <div class="tab-pane fade tab-padding" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    <!-- Data form Start  -->
                    <form class="row " id="tableData">

                        <div class="col-md-6 mb-3">
                            <label for="itemNameId" class="form-label">Item name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="itemNameId" name="item_name" maxlength="50">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="descriptionId" class="form-label">Item description <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="descriptionId" name="item_description" maxlength="150">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="priceId" class="form-label">Item price (₹)<span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-end" id="priceId" name="item_price" maxlength="10">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="imageId" class="form-label">Item image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="imageId" name="image" accept=".jpg, .jpeg, .png, .gif">
                            <small class="text-danger error"></small>
                            <div>
                                <img class="mt-3" id="myUploadView" width="10%" src="">
                            </div>
                        </div>

                        <input type="hidden" id="userId" name="id">
                        <input type="hidden" name="table" value="item_master">
                        <input type="hidden" id="imagePath" name="upload-path-of-image" value="./items">

                        <div class="col-md-12 mt-4">
                            <button type="button" class="add-user btn btn-dark" onclick="sendData()"><i class="bi bi-bag-plus-fill"></i> Add item</button>
                            <button type="button" value="update" name="updateBtn" class="update-user d-none btn btn-dark" onclick="sendData()"><i class="bi bi-bag-plus-fill"></i> Update item</button>
                            <button type="reset" class="btn btn-danger" onclick="resetMainFormData()" ><i class="bi bi-arrow-counterclockwise"></i> reset</button>
                        </div>

                        <!-- Backend Alerts  -->
                        <div class="alert alert-success my-backend-success d-none" style="position: absolute;width: 35%;right: 10px; top:10px" role="alert">
                        </div>
                        <div class="alert alert-danger my-backend-error d-none" style="position: absolute;width: 35%;right: 10px; top:10px" role="alert">
                        </div>
                        <!-- Backend Alerts  -->

                    </form>
                    <!-- Data form End  -->

                </div>
            </div>




        </div>

    </div>

</div>

<script>
    localStorage.setItem("tabName", "#itemMasterTab");
</script>

<?php include_once "templates/footer.php" ?>