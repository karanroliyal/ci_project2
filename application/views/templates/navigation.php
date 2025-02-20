<div class="col-md-2">
            <img src="<?= base_url() . "assets/images/logo.png" ?>" class="logo" width="75%"  alt="logo">
        </div>
        <div class="col-md-10 row justify-content-between align-items-center">
            <div class="col-md-2">
                <i class="bi bi-list text-light " onclick="hideSideBar()"></i>
            </div>
            <div class="col-md-2 d-flex align-items-center profile_section">
                <small class="text-light user-name"><b><?=$_SESSION['name']?></b></small>
                <img class="user-profile-image rounded-circle" title="karan rawat" src="<?= base_url()."profiles/".$_SESSION['image']?>" alt="<?="karan"?>">
            </div>
        </div>