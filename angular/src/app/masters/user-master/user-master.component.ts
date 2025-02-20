import { HttpClient } from '@angular/common/http';
import { Component, inject, Injectable, OnInit } from '@angular/core';
import { FormGroup, FormControl, ReactiveFormsModule, Validators, FormBuilder } from '@angular/forms';
import { PagginationComponent } from "../../project-layout/paggination/paggination.component";
import { ValidationModule } from "../../validation/validation.module";
import { FormValidationComponent } from "../../validation/form-validation/form-validation.component";
import { ApiService } from '../../api.service';
import Swal from 'sweetalert2';
import { Route, Router } from '@angular/router';
import { formatDate, NgClass } from '@angular/common';

interface tableData {
  id: string,
  name: string,
  phone: string,
  email: string
}

interface responseData {
  table: tableData[],
  pagination: { totalPages: number, current_page_opened: number },
  query: string
}

@Component({
  imports: [ReactiveFormsModule, PagginationComponent, FormValidationComponent, ValidationModule, NgClass],
  templateUrl: './user-master.component.html',
  styleUrl: './user-master.component.css',
})


@Injectable({
  providedIn: 'root'
})

export class UserMasterComponent implements OnInit {

  // all table data
  data: responseData = { table: [{ id: '', name: '', phone: '', email: '' }], pagination: { totalPages: 1, current_page_opened: 1 }, query: '' };

  // bootstrapTab change function 
  activeTab: string = 'search';


  searchtab(activeTab: string) {
    this.activeTab = activeTab;
    this.preserveField();
    this.updateBtn = false;
  }

  result(activeTab: string) {
    this.activeTab = activeTab;
  }

  constructor(private tableApi: ApiService, private router: Router) {
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

  onChange(event: any) {
    const file: File = event.target.files[0];

    if (file) {
      this.file = file;

    }
  }

  Action = 'Added';

  onSubmitData() {
    if (this.myDataForm.get('action')?.value == 'update') {
      this.myDataForm.controls['password'].setValidators([Validators.minLength(8), Validators.maxLength(15), Validators.pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/)])
      this.myDataForm.controls['password'].updateValueAndValidity()
      this.myDataForm.controls['image'].setValidators([])
      this.myDataForm.controls['image'].updateValueAndValidity()
      this.Action='Updated'
    }else{
      this.Action = 'Added';
    }


    this.myDataForm.markAllAsTouched();
    console.log(this.myDataForm.valid)
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
      }
    })

  }

  preserveField() {
    this.myDataForm.reset({
      table: this.myDataForm.get('table')?.value, // Preserve this field
      id: this.myDataForm.get('id')?.value, // Preserve this field
      uploadImage: this.myDataForm.get('uploadImage')?.value, // Preserve this field
      // action: this.myDataForm.get('action')?.value, // Preserve this field
    });
  }
  

  updateBtn = false;

  // Edit data functions
  editData(value: any) {

    this.updateBtn = true;

    this.myDataForm.controls['action'].setValue('update');
    this.myDataForm.controls['table'].setValue('user_master');

    const formData = new FormData();
    formData.append('id', value);
    formData.append('table', 'user_master');
    formData.append('key', 'id');
    this.tableApi.tableApi('InsertController', 'edit', formData).subscribe((res: any) => {
      delete res.image;
      delete res.password;
      Object.entries(res).forEach(([key, value]) => {
        if (this.myDataForm.get(key)) {
          this.myDataForm.get(key)?.setValue(value);
        }
        console.log(key, value);
      });
    })

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
    name: new FormControl(''),
    phone: new FormControl(''),
    email: new FormControl(''),
    table_name: new FormControl("user_master"),
    columnToShow: new FormControl('id,name,phone,email'),
    currentPage: new FormControl(1),
    pageLimit: new FormControl('5'),
    sortOn: new FormControl('id'),
    sortOrder: new FormControl('DESC'),
  })

  myDataForm = new FormGroup({
    name: new FormControl('', [Validators.required, Validators.minLength(3), Validators.maxLength(40), Validators.pattern(/^[a-zA-Z ]+$/)]),
    email: new FormControl('', [Validators.email, Validators.required, Validators.maxLength(50)]),
    image: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required, Validators.minLength(8), Validators.maxLength(15), Validators.pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/)]),
    phone: new FormControl('', [Validators.required, Validators.maxLength(10), Validators.pattern(/^[0-9]{10}$/)]),
    table: new FormControl('user_master'),
    uploadImage: new FormControl('./profiles'),
    id: new FormControl(''),
    action: new FormControl(''),
  })



  ngOnInit(): void {
    this.getData()
    // console.log('total Page ', this.data.table);
  }





  // chnaging limit value function
  changeMyLimit(limit: string) {
    this.myLiveForm.controls['pageLimit'].setValue(limit)
    this.getData()
  }






}
function updateValueAndValidity() {
  throw new Error('Function not implemented.');
}

