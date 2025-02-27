<div class="sidebar row my-bg-b" >
                <div class="d-flex flex-column master-links">
                    <a href="<?=base_url()."pagescontroller"?>" id="dashoardTab"><i class="bi bi-collection-fill"></i> Dashboard</a>
                    <a href="<?=base_url()."pagescontroller/usermaster"?>" id="userMasterTab"><i class="bi bi-person-fill-add" ></i> User master</a>
                    <a href="<?=base_url()."pagescontroller/clientmaster"?>" id="clientMasterTab"><i class="bi bi-people-fill" ></i> Client master</a>
                    <a href="<?=base_url()."pagescontroller/itemmaster"?>" id="itemMasterTab"><i class="bi bi-cart-plus-fill" ></i> Item master</a>
                    <a href="<?=base_url()."pagescontroller/invoice"?>" id="invoiceTab"><i class="bi bi-receipt"></i> Invoice</a>
                </div>
                 <div class="logout-link">
                    <a  onclick="logout()" ><i class="bi bi-box-arrow-left"></i> Logout</a>
                 </div>
            </div>   