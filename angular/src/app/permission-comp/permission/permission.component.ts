import { Component } from '@angular/core';
import { ApiService } from '../../api.service';
import { FormArray, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import Swal from 'sweetalert2';


interface user { name: string, id: number };
interface permisssion_data { id: string, menu_name: string, menu_priority: string, user_id: string, add_p: string, update_p: string, view_p: string, delete_p: string };

@Component({
  selector: 'app-permission',
  imports: [ReactiveFormsModule, NgFor],
  templateUrl: './permission.component.html',
  styleUrl: './permission.component.css'
})
export class PermissionComponent {

  constructor(private http: ApiService) {
    this.getUsers();
    this.getPermission();
  }

  userData: user[] = [{ name: '', id: 1 }];

  getUsers() {

    this.http.tableApi('User_permission', 'get_user_name', '').subscribe((res: any) => {

      this.userData = res.data;

    })

  }

  edit_permission : boolean = true;
  delete_permission : boolean = true;
  view_permission : boolean = true;
  add_permission : boolean = true;

  getPermission(){

    this.http.tableApi('User_permission' , 'get_login_user_permission' , '').subscribe((res:any)=>{
      console.log(res);

      this.edit_permission = this.booleanReturn(res.data.edit_permission);
      this.delete_permission = this.booleanReturn(res.data.delete_permission);
      this.view_permission = this.booleanReturn(res.data.view_permission);
      this.add_permission = this.booleanReturn(res.data.add_permission);

    })

  }


    
  booleanReturn(val:number){
    if(val == 0){
      return false;
    }else{
      return true;
    }
  }

  show_permission_table: boolean = false;
  user_permission_data: permisssion_data[] = [{ id: '', menu_name: '', menu_priority: '', user_id: '', add_p: '', update_p: '', view_p: '', delete_p: '' }]

  selectedId : string = '';

  openPermissionTable(selected_user_id: string) {

    if (selected_user_id !== 'novalue') {
      this.show_permission_table = true;

      this.selectedId = selected_user_id;

      const formData = new FormData();

      formData.append('user_id', selected_user_id);

      this.http.tableApi('User_permission', 'get_user_permission_data', formData).subscribe((res: any) => {

        console.log(res.data.menu_name, 'my data');

        this.user_permission_data = res.data;

        this.permission_fields.clear();

        this.user_permission_data.forEach((ele, index) => {

          this.permission_fields.push(this.permission_array());

          this.permission_fields.at(index).patchValue({
            'menu_name': ele.menu_name,
            'user_id': selected_user_id,
            'menu_id': ele.id,
            'add_p': this.permission_checker(ele.add_p),
            'update_p': this.permission_checker(ele.update_p),
            'delete_p': this.permission_checker(ele.delete_p),
            'view_p': this.permission_checker(ele.view_p),
          })

        })

        // this.insert_permissions();

      })
    } 
    else {
      this.show_permission_table = false;
    }

  }

  permission_checker(val: string) {

    if (val == '1') {
      return 1;
    } else {
      return 0;
    }

  }


  User_permission = new FormGroup({

    permission_fields: new FormArray([
      this.permission_array()
    ])

  })

  permission_fields = this.User_permission.get('permission_fields') as FormArray;


  permission_array(): FormGroup {
    return new FormGroup({
      user_id: new FormControl(''),
      add_p: new FormControl(''),
      update_p: new FormControl(''),
      delete_p: new FormControl(''),
      view_p: new FormControl(''),
      menu_id: new FormControl(''),
      menu_name: new FormControl(''),
    })
  }

  insert_permissions() {

    const formData = new FormData();

    formData.append('user_id' , this.selectedId );

    formData.append('data' , JSON.stringify(this.User_permission.value));

    this.http.tableApi('User_permission' , 'insert_user_permission' , formData).subscribe((res:any)=>{

      if(res == 1){

        Swal.fire({
          text: 'User permission saved successfully',
          icon: 'success',
          draggable: false
        })

      }else{
        Swal.fire({
          text: 'Unable to save user permission',
          icon: 'error',
          draggable: false
        })
      }

    } , (error:any)=>{

      Swal.fire({
        text: 'Unable to save user permission',
        icon: 'error',
        draggable: false
      })
    });

  }



}
