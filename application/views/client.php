<?php $title = "Client";
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
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All client</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Add client</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!-- Live search form with users table  -->
                <div class="tab-pane fade show active tab-padding" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                    <div class="w-100">

                        <!-- Live search form start -->
                        <form class="tableDataForm row align-items-center my-bg-b my-color" id="liveSearchForm">

                            <div class="col-md-1 col-sm-6 col-xl-1 mt-2">
                                <label for="searchId" class="form-label">Id</label>
                                <input type="number" id="searchId" name="id" class="form-control">
                            </div>

                            <div class="col-md-2 col-sm-6 col-xl-2 mt-2">
                                <label for="searchName" class="form-label">Name</label>
                                <input type="text" name="name" id="searchName" class="form-control">
                            </div>

                            <div class="col-md-2 col-sm-6 col-xl-2 mt-2">
                                <label for="searchPhone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="searchPhone" class="form-control">
                            </div>

                            <div class="col-md-2 col-sm-6 col-xl-2 mt-2">
                                <label for="searchEmail" class="form-label">Email</label>
                                <input type="text" name="email" id="searchEmail" class="form-control">
                            </div>
                            <div class="col-md-2 col-sm-6 col-xl-2 mt-2">
                                <label for="searchPincode" class="form-label">Pincode</label>
                                <input type="number" name="pincode" id="searchPincode" class="form-control">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xl-3 mt-2">
                                <label for="searchAddress" class="form-label">Address</label>
                                <input type="text" name="address" id="searchAddress" class="form-control">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xl-3 mt-2">
                                <label for="searchState" class="form-label">State</label>
                                <input type="text" name="state_name" id="searchState" class="form-control">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xl-3 mt-2">
                                <label for="searchDistrict" class="form-label">District</label>
                                <input type="text" name="district_name" id="searchDistrict" class="form-control">
                            </div>


                            <div class="col-md-2 col-sm-6 col-xl-2 mt-5 d-flex justify-content-center">
                                <button onclick="resetLoadTable()" type="reset" class="btn btn-danger">reset</button>
                            </div>

                            <input type="hidden" name="table_name" value="client_master">
                            <input type="hidden" name="columnToShow" value="id,name,email,phone,address,state,district,pincode"> 
                             <!-- order also be same as table shown on frontend  -->
                            <input type="hidden" name="join_columns" value="state_master sm , district_master dm">
                            <input type="hidden" name="join_on" value="client_master.state = sm.state_id, client_master.district = dm.district_id">
                            <input type="hidden" name="currentPage" id="pageId" value="1">
                            <input type="hidden" name="pageLimit" id="limit" value="5">
                            <input type="hidden" name="sortOn" id="sortOn" value="id">
                            <input type="hidden" name="sortOrder" id="sortOrder" value="DESC">


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
                                    <th class="sortingClass" data-sort="name">Name <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="email">Email <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="phone">Phone <i class="bi bi-arrow-down-up"></i></th>
                                    <th data-sort="address">Address</th>
                                    <!-- <th class="sortingClass" data-sort="state">State <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="district">District <i class="bi bi-arrow-down-up"></i></th> -->
                                    <th class="sortingClass" data-sort="pincode">Pincode <i class="bi bi-arrow-down-up"></i></th>
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
                            <label for="nameId" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nameId" name="name" maxlength="50">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phoneId" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phoneId" name="phone" maxlength="10">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailId" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="emailId" name="email" maxlength="70">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="addressId" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addressId" name="address" maxlength="100">
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stateId" class="form-label">State <span class="text-danger">*</span></label>
                            <select name="state" id="stateId" class="form-select" onchange="stateChange()" >
                                <option value="">--Select State--</option>
                                <?php
                                    // $this->db->select('state_id' , 'state_name');
                                    $query = $this->db->get('state_master');

                                    foreach($query->result_array() as $row){
                                        echo "<option value='{$row['state_id']}'>{$row['state_name']}</option>";
                                    }
                                
                                ?>
                            </select>
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="districtId" class="form-label">District <span class="text-danger">*</span></label>
                            <select name="district" id="districtId" class="form-select"  >
                                <option value="" id="selected_district">--Select District--</option>
                            </select>
                            <small class="text-danger error"></small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="pincodeId" class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-end" id="pincodeId" name="pincode" maxlength="6">
                            <small class="text-danger error"></small>
                        </div>

                        <input type="hidden" id="userId" name="id">
                        <input type="hidden" name="table" value="client_master">
                        <img src="" id="myUploadView" class="d-none" >

                        <div class="col-md-12 mt-4">
                            <button type="button" class="add-user btn btn-dark" onclick="sendData()"><i class="bi bi-person-add"></i> Add client</button>
                            <button type="button" value="update" name="updateBtn" class="update-user d-none btn btn-dark" onclick="sendData()"><i class="bi bi-arrow-bar-up"></i> Update client</button>
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
    localStorage.setItem("tabName", "#clientMasterTab");
</script>

<?php include_once "templates/footer.php" ?>