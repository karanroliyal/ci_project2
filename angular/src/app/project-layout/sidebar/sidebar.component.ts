import { Component, inject } from '@angular/core';
import { RouterLink, RouterLinkActive, RouterOutlet , Router } from '@angular/router';

@Component({
  selector: 'app-sidebar',
  imports: [RouterLink, RouterOutlet, RouterLinkActive],
  template: `
    <div class="sidebar-content-wrapper row mx-0">
      <div class="sidebar-wrapper  col-md-2 col-xl-2 col-sm-2">
        <div class="d-flex flex-column h-100">
          <div>
            <a class="sidebar-btn" routerLink="/dash/dashboard" routerLinkActive="active-link" >
              <i class="bi bi-grid"></i> Dashboard
            </a>
            <a class="sidebar-btn" routerLink="/dash/user-master" routerLinkActive="active-link">
              <i class="bi bi-person"></i> User master
            </a>
            <a class="sidebar-btn" routerLink="/dash/client-master" routerLinkActive="active-link">
              <i class="bi bi-people"></i> Client master
            </a>
            <a class="sidebar-btn" routerLink="/dash/item-master" routerLinkActive="active-link">
              <i class="bi bi-bag-plus"></i> Item master
            </a>
            <a class="sidebar-btn" routerLink="/dash/invoice" routerLinkActive="active-link">
              <i class="bi bi-journal-text"></i> Invoice
            </a>
          </div>

          <a class="logout-btn-sidebar sidebar-btn bg-danger text-light"
          (click)="logout()">
            <i class="bi bi-box-arrow-in-left"></i> Logout
          </a>
        </div>
      </div>
      <div class="content-wrapper col">

        <router-outlet></router-outlet>
         
      </div>
    </div>
  `,
  styles: `

.sidebar-content-wrapper {

position: relative;
height: calc(100vh - 45px);

@media screen and (max-width: 962px){
  .sidebar-wrapper{
    display:none
  }
}

.sidebar-wrapper {
    padding: 10px 15px;
    box-shadow: rgba(0, 0, 0, 0.17) 2.4px 2.4px 3.2px;
    position: relative;
    height: calc(100vh - 45px);

    .sidebar-btn {
        position: relative;
        white-space: nowrap;
        padding: 7px 14px;
        text-align: start;
        background-color: transparent;
        border-radius: 3px;
        margin-bottom: 10px;
        display: block;
        text-decoration: none;
        font-weight: 600;
        color: #2674a5;
    }
    .logout-btn-sidebar{
        margin-top: auto;
        cursor:pointer
    }
    .sidebar-btn:hover {
        background-color: #cdeafc;
            color: black;
    }
    .active-link{
      background-color: #cdeafc;
      color: black;
    }
}
.content-wrapper {
    padding: 10px;
    height: calc(100vh - 45px);
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 100
}


}
  
  `,
})
export class SidebarComponent {

  private router = inject(Router);

  logout(){

    this.router.navigate(['/login'])
    localStorage.setItem('secure_token','');

  }

 }
