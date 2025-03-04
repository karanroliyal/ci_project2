import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'project-cms';

  // menuArray = [{"menu_name":"login","route":"/login"}]

  constructor(){
    // localStorage.setItem('menu' , JSON.stringify(this.menuArray));
  }
  
}
