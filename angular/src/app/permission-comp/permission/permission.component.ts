import { Component } from '@angular/core';
import { ApiService } from '../../api.service';


interface user {name: string , id: number};

@Component({
  selector: 'app-permission',
  imports: [],
  templateUrl: './permission.component.html',
  styleUrl: './permission.component.css'
})
export class PermissionComponent {

  constructor( private http: ApiService){
    this.getUsers()
  }

  userData : user[] = [{name: '' , id: 1}];

  getUsers(){

    this.http.tableApi('User_permission','get_user_name' , '').subscribe((res:any)=>{

      this.userData = res.data;

    })

  }

  show_permission_table : boolean = false;

  openPermissionTable(selected_user_id: string){

    if(selected_user_id !== 'novalue'){
      this.show_permission_table = true;

      this.http.tableApi('User_permission','get_menu_data' , '').subscribe((res:any)=>{

        console.log(res);

      })


    }else{
      this.show_permission_table = false;
    }

  }


}
