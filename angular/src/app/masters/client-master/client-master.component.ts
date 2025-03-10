import { Component, Injectable, OnInit } from '@angular/core';
import { FormGroup, FormControl, ReactiveFormsModule, Validators } from '@angular/forms';
import { PagginationComponent } from "../../project-layout/paggination/paggination.component";
import { ValidationModule } from "../../validation/validation.module";
import { FormValidationComponent } from "../../validation/form-validation/form-validation.component";
import { ApiService } from '../../api.service';
import Swal from 'sweetalert2';
import { NgClass } from '@angular/common';
import { HttpResponse } from '@angular/common/http';

interface tableData {
  id: string,
  NAME: string,
  phone: string,
  email: string,
  address: string,
  state: string,
  district: string,
  pincode: string
}

interface responseData {
  table: tableData[],
  pagination: { totalPages: number, current_page_opened: number },
  query: string
}

@Component({
  selector: 'app-client-master',
  imports: [ReactiveFormsModule, PagginationComponent, FormValidationComponent, ValidationModule, NgClass],
  templateUrl: './client-master.component.html',
  styleUrl: './client-master.component.css'
})
export class ClientMasterComponent {

  // all table data
  data: responseData = { table: [{ id: '', NAME: '', phone: '', email: '', address: '', state: '', district: '', pincode: '' }], pagination: { totalPages: 1, current_page_opened: 1 }, query: '' };

  // bootstrapTab change function 
  activeTab: string = 'search';


  searchtab(activeTab: string) {
    this.activeTab = activeTab;
    this.myDataForm.get('action')?.setValue('');
    this.preserveField();
    this.updateBtn = false;
    this.imageDiv = true;
    this.districtArray = [];
  }

  result(activeTab: string) {
    this.activeTab = activeTab;
  }

  constructor(private tableApi: ApiService) {
  }

  opened_page = this.data.pagination.totalPages;
  Total_pages = this.data.pagination.current_page_opened;


  edit_permission: boolean = true;
  delete_permission: boolean = true;
  view_permission: boolean = true;
  add_permission: boolean = true;


  getPermission(){

    this.tableApi.tableApi('User_permission' , 'user_permission' , '' ).subscribe((res:any)=>{

      this.edit_permission = this.booleanReturn(res.permission.edit_permission);
      this.delete_permission = this.booleanReturn(res.permission.delete_permission);
      this.view_permission = this.booleanReturn(res.permission.view_permission);
      this.add_permission = this.booleanReturn(res.permission.add_permission);

    })

  }

  getData() {
    const formData = new FormData();

    formData.append('data', JSON.stringify(this.myLiveForm.value));

    this.tableApi.tableApi('Client_Master_Controller', 'client_table', formData).subscribe((res: any) => {

      if (res.statusCode == 403) {
        Swal.fire({
          text: res.message,
          icon: 'error',
        })
        this.data.table = [];
        return;
      }

      this.data = res;


    }, (error: any) => {
      Swal.fire({
        title: 'Something went wrong',
        icon: "error",
        draggable: false,
      });
      this.data.table = [];
    });
  }



  booleanReturn(val: number) {
    if (val == 0) {
      return false;
    } else {
      return true;
    }
  }


  // Insert data functions 

  file: File | null = null;
  fileBase64: string | null = null;
  imageUrl: any;
  imageDiv: boolean = true;

  onChange(event: any) {
    const file: File = event.target.files[0];
    let reader = new FileReader();
    if (file) {
      this.file = file;
      console.log(this.file);
      this.imageUrl = this.file
      reader.readAsDataURL(file);
      reader.onload = () => {
        this.imageUrl = reader.result;
      };
      this.imageDiv = false;
    }
    else {
      this.imageDiv = true;
      reader.onload = () => {
        this.imageUrl = "";
      };
    }
  }



  Action = 'Added';

  onSubmitData() {
    this.tableApi.onSubmitData(this.myDataForm, this.imageUrl, this.insertData.bind(this))
  }


  insertData(action: string) {
    this.tableApi.insertData(this.myDataForm, this.showError.bind(this), this.searchtab.bind(this), this.getData.bind(this), null, this.preserveField.bind(this), action, 'insert_client_data', 'Client_Master_Controller', 'update_client_data');
  }


  // reset form fileds
  preserveField() {
    this.tableApi.preserveField(this.myDataForm, ['table', 'id', 'action'], null);
  }

  numberOnly(event: any): boolean {
    return this.tableApi.numberOnly(event);

  }

  updateBtn = false;

  // Edit data functions
  async editData(value: any) {
    try {
      const [updatedImageUrl, updatedUpdateBtn, updatedDiv] = await this.tableApi.editData(
        value,
        this.updateBtn,
        this.imageUrl,
        this.imageDiv,
        this.myDataForm,
        'client_master',
        'id',
        this.getDistrict.bind(this),
        '',
        'Client_Master_Controller',
        'client_edit'
      );

      // Update the component properties with the returned values
      this.imageUrl = updatedImageUrl;
      this.updateBtn = updatedUpdateBtn;
      this.imageDiv = updatedDiv;

      console.log('Updated imageUrl:', this.imageUrl);
      console.log('Updated updateBtn:', this.updateBtn);
      console.log('Updated updateImagediv:', this.imageDiv);
    } catch (error) {
      console.error('Error editing data:', error);
    }
  }

  // Delete data function 
  deleteData(value: string) {
    this.tableApi.deleteData(value, this.getData.bind(this), 'id', 'client_master' , 'Client_Master_Controller' , 'client_delete' )
  }


  resetLiveForm() {
    this.tableApi.resetLiveForm(this.myLiveForm, ['id', 'NAME', 'email', 'phone'], this.getData.bind(this))
  }


  showError(error: any) {
    this.tableApi.showError(error, this.myDataForm);
  }

  myLiveForm = new FormGroup({
    id: new FormControl(''),
    NAME: new FormControl(''),
    phone: new FormControl(''),
    email: new FormControl(''),
    table_name: new FormControl("client_master"),
    columnToShow: new FormControl('id,name,phone,email,address,state,district,pincode'),
    currentPage: new FormControl(1),
    pageLimit: new FormControl('5'),
    sortOn: new FormControl('id'),
    sortOrder: new FormControl('DESC'),
    join_columns: new FormControl('state_master sm , district_master dm'),
    join_on: new FormControl('client_master.state = sm.state_id, client_master.district = dm.district_id'),

  })

  myDataForm = new FormGroup({
    NAME: new FormControl('', [Validators.required, Validators.minLength(3), Validators.maxLength(40), Validators.pattern(/^[a-zA-Z ]+$/)]),
    email: new FormControl('', [Validators.email, Validators.required, Validators.maxLength(50)]),
    address: new FormControl('', [Validators.required]),
    phone: new FormControl('', [Validators.required, Validators.maxLength(10), Validators.pattern(/^[0-9]{10}$/)]),
    table: new FormControl('client_master'),
    state: new FormControl('', Validators.required),
    district: new FormControl('', Validators.required),
    // uploadImage: new FormControl('./profiles'),
    id: new FormControl(''),
    action: new FormControl(''),
    pincode: new FormControl('', [Validators.required, Validators.minLength(6), Validators.maxLength(6)])
  })

  stateArray = [{ state_id: 1, state_name: '' }];

  // state function
  state() {
    this.tableApi.tableApi('Client_Master_Controller', 'state_master_option', "").subscribe((res: any) => {
      this.stateArray.pop();
      this.stateArray = res.state;
    }, (error: any) => {
      Swal.fire({
        title: 'Unable to get state',
        icon: "error",
        draggable: false,
      });
    });
  }

  districtArray = [{ district_id: 1, district_name: '' }];

  // district function
  getDistrict(stateId: any) {

    const formData = new FormData();

    formData.append('state_id', stateId);

    this.tableApi.tableApi('Client_Master_Controller', 'district_master_option', formData).subscribe((res: any) => {
      console.log(res);
      this.districtArray.pop();
      this.districtArray = res.district_options;
    }, (error: any) => {
      Swal.fire({
        title: 'Unable to get district data',
        icon: "error",
        draggable: false,
      });
    });

  }

  ngOnInit(): void {
    this.getData();
    this.state();
    this.getPermission();
    // console.log('total Page ', this.data.table);
  }

  // chnaging limit value function
  changeMyLimit(limit: string) {
    this.myLiveForm.controls['pageLimit'].setValue(limit)
    this.getData();
  }
}
