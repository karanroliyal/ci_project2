import { Component, Injectable, OnInit } from '@angular/core';
import { FormGroup, FormControl, ReactiveFormsModule, Validators } from '@angular/forms';
import { PagginationComponent } from "../../project-layout/paggination/paggination.component";
import { ValidationModule } from "../../validation/validation.module";
import { FormValidationComponent } from "../../validation/form-validation/form-validation.component";
import { ApiService } from '../../api.service';
import Swal from 'sweetalert2';
import { NgClass } from '@angular/common';

interface tableData {
  id: string,
  name: string,
  phone: string,
  email: string,
  image: string
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
  data: responseData = { table: [{ id: '', name: '', phone: '', email: '', image: '' }], pagination: { totalPages: 1, current_page_opened: 1 }, query: '' };

  // bootstrapTab change function 
  activeTab: string = 'search';


  searchtab(activeTab: string) {
    this.activeTab = activeTab;
    this.myDataForm.get('action')?.setValue('');
    this.preserveField();
    this.updateBtn = false;
    this.imageDiv = true;
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
  resetLiveForm(){
    this.myLiveForm.controls['id'].setValue('');
    this.myLiveForm.controls['name'].setValue('');
    this.myLiveForm.controls['email'].setValue('');
    this.myLiveForm.controls['phone'].setValue('');
    setTimeout(()=>{this.getData()},100);
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

  clearImage() {
    this.myDataForm.get('image')?.setValue('');
    this.imageUrl = '';
    this.imageDiv = true;
  }

  Action = 'Added';

  onSubmitData() {
    const solveUpdate = this.myDataForm.get('action')?.value == 'update';
    console.log(solveUpdate, 'update request')
    if (solveUpdate && this.imageUrl !== '') {
      this.myDataForm.controls['image'].clearValidators()
      this.myDataForm.controls['image'].updateValueAndValidity()
    }
    else {
      this.myDataForm.controls['image'].setValidators([Validators.required])
      this.myDataForm.controls['image'].updateValueAndValidity()
    }
    if (solveUpdate && (this.myDataForm.get('password')?.value || '').trim() === '') {
      console.log(this.myDataForm.get('password')?.value, 'top')
      this.myDataForm.controls['password'].clearValidators()
      this.myDataForm.controls['password'].updateValueAndValidity()
    } else {
      console.log(this.myDataForm.get('password')?.value, 'bottom')
      this.myDataForm.controls['password'].setValidators([Validators.required, Validators.minLength(8), Validators.maxLength(15), Validators.pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/)]);
      this.myDataForm.controls['password'].updateValueAndValidity()
    }

    //changing sweet alert text 
    if (solveUpdate) {
      this.Action = 'Updated'
    } else {
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
        this.myDataForm.get('action')?.setValue('');
      }
    })

  }

  // reset form fileds
  preserveField() {
    this.myDataForm.reset({
      table: this.myDataForm.get('table')?.value, // Preserve this field
      id: this.myDataForm.get('id')?.value, // Preserve this field
      uploadImage: this.myDataForm.get('uploadImage')?.value, // Preserve this field
      action: this.myDataForm.get('action')?.value, // Preserve this field
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
      if (res.image) {
        // console.log(res.image,'imagepath');
        this.imageUrl = 'http://localhost/ci_project2/profiles/' + res.image;
        this.imageDiv = false;
        delete res.image;
      }
      delete res.password;
      Object.entries(res).forEach(([key, value]) => {
        if (this.myDataForm.get(key)) {
          this.myDataForm.get(key)?.setValue(value);
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
          formData.append('tableName', 'user_master');
          formData.append('key', 'id');

          this.tableApi.tableApi('TableController', 'delete', formData).subscribe((res: any) => {
            console.log(res);
            this.getData();
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
    columnToShow: new FormControl('id,name,phone,email,image'),
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

