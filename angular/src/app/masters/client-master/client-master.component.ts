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
  name: string,
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
  data: responseData = { table: [{ id: '', name: '', phone: '', email: '', address: '' , state:'' , district:'' , pincode:'' }], pagination: { totalPages: 1, current_page_opened: 1 }, query: '' };

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

  getData() {
    this.tableApi.tableApi('tablecontroller', '', this.myLiveForm.value).subscribe((res: any) => {
      this.data = res;
    });
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
    const solveUpdate = this.myDataForm.get('action')?.value == 'update';
    console.log(solveUpdate, 'update request')
    

    //changing sweet alert text 
    if (solveUpdate) {
      this.Action = 'Updated'
    } else {
      this.Action = 'Added';
    }


    this.myDataForm.markAllAsTouched();
    console.log(this.myDataForm.valid , 'valid or not ')
    console.log(this.myDataForm.errors , 'errors of form')
    if (this.myDataForm.valid) {
      this.insertData();
    }
  }


  insertData() {
    const formData = new FormData();

    if (this.file) {
      formData.append('image', this.file); // Append file directly
    }
    formData.append('data', JSON.stringify(this.myDataForm.value)); // Send additional form data
    this.tableApi.tableApi('insertcontroller', 'insert', formData).subscribe((res: any) => {
      if (res.error) {
        this.showError(res.error);
      } else {
        this.searchtab('search');
        this.getData();
        Swal.fire({
          title: `User ${this.Action} Successfully!`,
          icon: "success",
          draggable: false,
        });
        this.preserveField()
        this.myDataForm.get('action')?.setValue('');
      }
    })

  }

  // reset form fileds
  preserveField() {
    this.myDataForm.reset({
      table: this.myDataForm.get('table')?.value, // Preserve this field
      id: this.myDataForm.get('id')?.value, // Preserve this field
      // uploadImage: this.myDataForm.get('uploadImage')?.value, // Preserve this field
      action: this.myDataForm.get('action')?.value, // Preserve this field
    });
  }




  updateBtn = false;

  // Edit data functions
  editData(value: any) {

    this.updateBtn = true;

    this.myDataForm.controls['action'].setValue('update');
    this.myDataForm.controls['table'].setValue('client_master');

    const formData = new FormData();
    formData.append('id', value);
    formData.append('table', 'client_master');
    formData.append('key', 'id');
    this.tableApi.tableApi('InsertController', 'edit', formData).subscribe((res: any) => {
      if (res.image) {
        // console.log(res.image,'imagepath');
        this.imageUrl = 'http://localhost/ci_project2/profiles/' + res.image;
        this.imageDiv = false;
        delete res.image;
      }
      if(res.password){
        delete res.password;
      }
      Object.entries(res).forEach(([key, value]) => {
        if (this.myDataForm.get(key)) {
          this.myDataForm.get(key)?.setValue(value);
        }
        if(key == 'state'){
          this.getDistrict(value);
        }
        // console.log(key, value);
      });
    })

  }

  // Delete data function 
  deleteData(value: string) {
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
      .fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
      })
      .then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          });
          const formData = new FormData();
          formData.append('deleteid', value);
          formData.append('tableName', 'client_master');
          formData.append('key', 'id');

          this.tableApi.tableApi('TableController', 'delete', formData).subscribe((res:any) => {
            if(res === 1){
              this.getData();
              console.log('i am not deleteted')
            }
          },(error: any) => {  // Catch API errors (like 500)
            swalWithBootstrapButtons.fire({
              title: "Cancelled",
              text: "You cannot delete!",
              icon: "error",
            });
          })
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire({
            title: "Cancelled",
            text: "Your data is safe :)",
            icon: "error",
          });
        }
      });

  }


  resetLiveForm(){
    this.myLiveForm.controls['id'].setValue('');
    this.myLiveForm.controls['NAME'].setValue('');
    this.myLiveForm.controls['email'].setValue('');
    this.myLiveForm.controls['phone'].setValue('');
    setTimeout(()=>{this.getData()},100);
  }

  showError(error: any) {

    console.log(error, 'error')
    console.log("get any error")

    Object.entries(error).forEach(([key, value]) => {

      let err = key;
      console.log(key)
      // this.myDataForm.controls['email']
      if (key === 'email') {
        console.log(key);
      }
      if (key == 'image') {
        this.myDataForm.controls['phone'].addValidators([Validators.nullValidator]);
      }

      Swal.fire({
        title: `${value}`,
        icon: "error",
        draggable: false,
      });

    });


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
    state: new FormControl('' , Validators.required),
    district: new FormControl('' , Validators.required),
    // uploadImage: new FormControl('./profiles'),
    id: new FormControl(''),
    action: new FormControl(''),
    pincode: new FormControl('' , [Validators.required , Validators.minLength(6) , Validators.maxLength(6)])
  })

  stateArray = [{state_id:1,state_name:''}];

  // state function
  state(){
    this.tableApi.tableApi('tablecontroller','state',"").subscribe((res:any)=>{
      this.stateArray.pop();
      this.stateArray = res.state;
    })
  }

  districtArray = [{district_id:1,district_name:''}];

  // district function
  getDistrict(stateId:any){

    const formData = new FormData();

    formData.append('state_id', stateId);

    this.tableApi.tableApi('dropdowncontroller','district',formData).subscribe((res:any)=>{
      console.log(res);
      this.districtArray.pop();
      this.districtArray = res.district_options;
    })

  }

  ngOnInit(): void {
    this.getData();
    this.state()
    // console.log('total Page ', this.data.table);
  }

  // chnaging limit value function
  changeMyLimit(limit: string) {
    this.myLiveForm.controls['pageLimit'].setValue(limit)
    this.getData();
  }
}
