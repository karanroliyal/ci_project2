<?php $title = "Invoice";
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
                    <button class="nav-link active" id="nav-home-tab" onclick="removeCloneOnHome()" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All invoice</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Add invoice</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <!-- Live search form with users table  -->
                <div class="tab-pane fade show active tab-padding" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                    <div class="w-100">

                        <!-- Live search form start -->
                        <form class="tableDataForm row align-items-center my-bg-b my-color" id="liveSearchForm">

                            <div class="col-md-1 col-sm-6 col-xl-1 mt-2">
                                <label for="invoiceId" class="form-label">Invoice id</label>
                                <input type="number" id="invoiceId" name="invoice_id" class="form-control" min='1'>
                            </div>

                            <div class="col-md-2 col-sm-6 col-xl-2 mt-2">
                                <label for="searchClientName" class="form-label">Client name</label>
                                <input type="text" name="name" id="searchClientName" class="form-control">
                            </div>

                            <div class="col-md-2 col-sm-6 col-xl-2 mt-2">
                                <label for="searchClientPhone" class="form-label">Client phone</label>
                                <input type="number" name="phone" id="searchClientPhone" class="form-control">
                            </div>

                            <div class="col-md-2 col-sm-6 col-xl-2 mt-2">
                                <label for="searchClientEmail" class="form-label">Client email</label>
                                <input type="text" name="email" id="searchClientEmail" class="form-control">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xl-3 mt-2">
                                <label for="searchInvoiceDate" class="form-label">Invoice date</label>
                                <input type="date" name="invoice_date" id="searchInvoiceDate" class="form-control">
                            </div>


                            <div class="col-md-2 col-sm-6 col-xl-2 mt-5 d-flex justify-content-center">
                                <button onclick="resetLoadTable()" type="reset" class="btn btn-danger">reset</button>
                            </div>

                            <input type="hidden" name="table_name" value="invoice_master">
                            <input type="hidden" name="columnToShow" value="invoice_id,invoice_number,invoice_date,NAME,email,phone,total_amount">
                            <!-- order also be same as table shown on frontend  -->
                            <input type="hidden" name="join_columns" value="client_master cm">
                            <input type="hidden" name="join_on" value="cm.id = invoice_master.client_id">
                            <input type="hidden" name="currentPage" id="pageId" value="1">
                            <input type="hidden" name="pageLimit" id="limit" value="5">
                            <input type="hidden" name="sortOn" id="sortOn" value="invoice_id">
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
                                    <th class="sortingClass" data-sort="invoice_id">Invoice id <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="invoice_number">Invoice no. <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="invoice_date">Invoice date <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortingClass" data-sort="NAME">Client name <i class="bi bi-arrow-down-up"></i></th>
                                    <th data-sort="email">Client email</i></th>
                                    <th>Phone</th>
                                    <th class="sortingClass" data-sort="total_amount">Total <i class="bi bi-arrow-down-up"></i></th>
                                    <th>PDF</th>
                                    <th>MAIL</th>
                                    <th colspan="2" class="text-center">Action</th>
                                </thead>

                                <tbody class="myDynamicTable">
                                    <!-- here my dynamic table will come  -->
                                </tbody>

                            </table>
                            <!-- Showing Data table end  -->

                        </div>
                        <!-- Dynamic table and pagination end  -->


                        <!-- Mail icon trigger modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="myMailForm">
                                            <input type="hidden" id="invoice_id_hidden">
                                            <div class="mb-3">
                                                <label for="recipient_name_id" class="form-label">Recipient name:</label>
                                                <input type="text" name="recipient_name" id="recipient_name_id" class="form-control " readonly>
                                                <small class="text-danger error"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_to_id" class="form-label">To:</label>
                                                <input type="text" name="mail_to" id="mail_to_id" class="form-control" readonly>
                                                <small class="text-danger error"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="subjectId" class="form-label">Subject:</label>
                                                <input type="text" name="subject" id="subjectId" class="form-control " >
                                                <small class="text-danger error"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="messageId" class="form-label">Message:</label>
                                                <textarea type="text" name="message" id="messageId" class="form-control " rows="5" ></textarea>
                                                <small class="text-danger error"></small>
                                            </div>

                                            <div class="mail_send_container">

                                                <button type="button" class="btn btn-success" onclick="sendMail()" >Send mail</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Mail icon trigger modal -->


                    </div>

                </div>
                <!-- Adding Data into database -->
                <div class="tab-pane fade tab-padding" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    <!-- Data form Start  -->
                    <form class="row " id="tableData">

                        <div>

                            <div class="row mb-3">

                                <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                    <label for="invoice_numberId" class="form-label">Invoice no. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="invoice_numberId" name="invoice_number" maxlength="20">
                                    <small class="text-danger error"></small>
                                </div>

                                <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                    <label for="invoiceDateId" class="form-label">Invoice date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="invoiceDateId" name="invoice_date" value="<?php echo date('Y-m-d'); ?>">
                                    <small class="text-danger error"></small>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <input type="hidden" name="client_id" id="client_Id">

                                <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                    <label for="clientNameId" class="form-label">Client name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="clientNameId" name="name" maxlength="50" autocomplete="off">
                                    <small class="text-danger error"></small>
                                </div>

                                <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                    <label for="clientPhoneId" class="form-label">Phone <span class="text-danger">*</span></i></label>
                                    <input type="text" class="form-control " id="clientPhoneId" name="phone" maxlength="10" readonly>
                                    <small class="text-danger error"></small>
                                </div>

                                <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                    <label for="clientEmailId" class="form-label">Email <span class="text-danger">*</span></i></label>
                                    <input type="text" class="form-control " id="clientEmailId" name="email" maxlength="70" readonly>
                                    <small class="text-danger error"></small>
                                </div>
                                <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                    <label for="clientAddressId" class="form-label">Address <span class="text-danger">*</span></i></label>
                                    <input type="text" class="form-control " id="clientAddressId" name="address" readonly>
                                    <small class="text-danger error"></small>
                                </div>

                            </div>

                        </div>

                        <hr class="text-success">

                        <div class="client-detail-container-item">

                            <div class="code-container">

                                <div class="row mb-4 duplicate-row">

                                    <input type="hidden" class="item_id" name="item_id[]">

                                    <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                        <label for="addItemNameId" class="form-label">Item name <span class="text-danger">*</span></i></label>
                                        <input type="text" class="form-control itemAddId" id="addItemNameId" name="item_name[]" maxlength="50" onkeyup="getitems(this)">
                                        <small class="text-danger error"></small>
                                    </div>

                                    <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                        <label for="itemPriceId" class="form-label">Item price (₹) <span class="text-danger">*</span></i></label>
                                        <input type="text" class="form-control itemPriceAddId " id="itemPriceId" name="item_price[]" readonly>
                                        <small class="text-danger error"></small>
                                    </div>

                                    <div class="col-md-2 col-xl-2 col-sm-6 col-xs-6 mb-3">
                                        <label for="itemQuantityId" class="form-label">Quantity <span class="text-danger">*</span></i></label>
                                        <input type="number" class="form-control quantityAddId " id="itemQuantityId" name="quantity[]" min="1">
                                        <small class="text-danger error"></small>
                                    </div>

                                    <div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
                                        <label for="itemAmount" class="form-label">Amount (₹) <span class="text-danger">*</span></i></label>
                                        <input type="text" class="form-control amountAddId " id="itemAmount" name="amount[]" readonly>
                                        <small class="text-danger error"></small>
                                    </div>

                                    <div class="col-md-1 col-xl-1 mt-4">
                                        <button type="button" class="btn btn-danger delete-row"><i class="bi bi-bag-x"></i></button>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 col-xl-6 col-sm-6 col-xs-6 mt-4">
                                    <button class="btn btn-success" onclick="cloneItems()" type="button"><i class="bi bi-bag-plus"></i> Add item</button>
                                </div>
                                <div class="col-md-6 col-xl-6 col-sm-6 col-xs-6 mb-3">
                                    <label for="totalAmount" class="form-label">Total Amount <span class="text-danger">*</span></i></label>
                                    <input type="text" class="form-control" id="totalAmount" name="total_amount" readonly>
                                    <small class="text-danger error"></small>
                                </div>

                            </div>


                        </div>



                        <input type="hidden" id="userIdd" name="invoice_id" value="null">
                        <input type="hidden" name="table" value="invoice_master">
                        <img src="" id="myUploadView" class="d-none">

                        <div class="col-md-12 mt-4">
                            <button type="button" class="add-user btn btn-dark" onclick="sendInvoiceData()"><i class="bi bi-person-add"></i> Add invoice</button>
                            <button type="button" value="update" name="updateBtn" class="update-user d-none btn btn-dark" onclick="sendInvoiceData()"><i class="bi bi-arrow-bar-up"></i> Update invoice</button>
                            <button type="reset" class="btn btn-danger" onclick="resetMainFormData()"><i class="bi bi-arrow-counterclockwise"></i> reset</button>
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
    localStorage.setItem("tabName", "#invoiceTab");
</script>

<?php include_once "templates/footer.php" ?>