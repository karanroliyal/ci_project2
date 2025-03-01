import { Component, inject } from '@angular/core';
import { RouterLink, RouterLinkActive, RouterOutlet, Router } from '@angular/router';
import { OnInit } from '@angular/core';
import { ApiService } from '../../api.service';

interface menuData {

  priority: number,
  menu_name: string,
  route: string,
  icon_class: string

}


@Component({
  selector: 'app-sidebar',
  imports: [RouterLink, RouterOutlet, RouterLinkActive],
  template: `
    <div class="sidebar-content-wrapper row mx-0">
      <div class="sidebar-wrapper  col-md-2 col-xl-2 col-sm-2">
        <div class="d-flex flex-column h-100">
          <div>

            @for(menu of myMenu ; track $index){

              <a class="sidebar-btn" routerLink={{menu.route}} routerLinkActive="active-link" >
                <i class={{menu.icon_class}} ></i> {{menu.menu_name}}
              </a>

            }
            
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
export class SidebarComponent implements OnInit {

  private router = inject(Router);

  private http = inject(ApiService);

  logout() {

    this.router.navigate(['/login'])
    localStorage.setItem('secure_token', '');
    localStorage.setItem('auth_token', '');

  }

  myMenu : menuData[]  = [{menu_name:'' , priority: 1 , route : '' , icon_class: ''}] ;

  // sidebar menu getter 
  menuGet() {
    this.http.tableApi('Menu', 'get_menu', '').subscribe((res: any) => {
      if(res.statusCode == 200){
        console.log(res.data);
        this.myMenu = res.data;
      }
    })
  }

  ngOnInit(): void {
    this.menuGet();
  }


}
