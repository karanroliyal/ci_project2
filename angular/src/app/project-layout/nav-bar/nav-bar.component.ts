import { Component } from '@angular/core';

@Component({
  selector: 'app-nav-bar',
  imports: [],
  template: 
  `
  <div class="navigation-wrapper row mx-0">
        <div class="logo-wrapper col-md-2 col-xl-2 col-sm-2 col-xs-2">
          <img width="100%" src="../assets/images/logo.png" />
        </div>
        <div class="col-md-10 col-xl-10 col-sm-10 navigation-container">
          <i class="bi bi-list toggle-sidebar-btn sidebar-toggle-btn"></i>
          <div class="d-flex align-items-center gap-2">
            <h6 class="user-name-navigation px-2">heej rawat</h6>
            <img
              class="user-profile-navigation"
              src="../assets/images/images.jpg"
              alt=""
            />
          </div>
        </div>
  </div>
  `
  ,
  styles: `
  
  .navigation-wrapper {
        height: 45px;
        padding: 5px;
        box-shadow: 0px 3px 5px 0px rgba(56, 56, 56, 0.25);
        -webkit-box-shadow: 0px 3px 5px -1px rgba(56, 56, 56, 0.25);
        -moz-box-shadow: 0px 3px 5px -1px rgba(56, 56, 56, 0.25);
        z-index: 200;
        position: relative;

        .navigation-container{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sidebar-toggle-btn{
            font-size: 20px;
        }
        .user-name-navigation{
            margin-bottom: 0px;
            white-space: nowrap;
        }
        .user-profile-navigation{
            width: 35px; 
            height: 35px;
            border-radius: 50%;
            object-fit: contain;
        }
    }
  
  `
})
export class NavBarComponent {

}
