import { Component } from '@angular/core';
import { NavBarComponent } from '../nav-bar/nav-bar.component';
import { SidebarComponent } from '../sidebar/sidebar.component';

@Component({
  selector: 'app-body',
  imports: [NavBarComponent, SidebarComponent],
  template: `
    <div class="main-container-of-app">
      <app-nav-bar />

      <app-sidebar />

    </div>
  `,
  styles: `
  
.main-container-of-app {
width: 100%;
height: 100%;
position: relative;

}
  
  `,
})
export class BodyComponent { }
