import { Component } from '@angular/core';
import { FormGroup, FormControl, ReactiveFormsModule, Validators, FormArray, FormsModule } from '@angular/forms';
import { PagginationComponent } from "../../project-layout/paggination/paggination.component";
import { ValidationModule } from "../../validation/validation.module";
import { FormValidationComponent } from "../../validation/form-validation/form-validation.component";
import { ApiService } from '../../api.service';
import { NgClass, NgFor } from '@angular/common';
import { OnInit } from '@angular/core';
import { AutocompleteComponent } from "../autocomplete/autocomplete.component";

interface tableData {
  invoice_id: string,
  invoice_number: string,
  invoice_date: string,
  NAME: string,
  email: string,
  phone: string,
  total_amount: string,
}
interface responseData {
  table: tableData[],
  pagination: { totalPages: number, current_page_opened: number },
  query: string
}

@Component({
  selector: 'app-invoice',
  imports: [ReactiveFormsModule, PagginationComponent, FormValidationComponent, ValidationModule, NgClass, NgFor, FormsModule, AutocompleteComponent],
  templateUrl: './invoice.component.html',
  styleUrl: './invoice.component.css'
})
export class InvoiceComponent implements OnInit {

  options = ['karan', 'hero ', 'zero'];



  // all table data
  data: responseData = { table: [{ invoice_id: '', invoice_number: '', invoice_date: '', NAME: '', email: '', phone: '', total_amount: '' }], pagination: { totalPages: 1, current_page_opened: 1 }, query: '' };

  // bootstrapTab change function 
  activeTab: string = 'search';



  searchtab(activeTab: string) {
    this.activeTab = activeTab;
    this.myDataForm.get('action')?.setValue('');
    this.preserveField();
    this.updateBtn = false;
    this.imageDiv = true;
    this.clearItemForm()
  }

  result(activeTab: string) {
    this.activeTab = activeTab;
  }

  constructor(private tableApi: ApiService) { }


  opened_page = this.data.pagination.totalPages;
  Total_pages = this.data.pagination.current_page_opened;

  getData() {
    this.tableApi.tableApi('tablecontroller', '', this.myLiveForm.value).subscribe((res: any) => {
      this.data = res;
    });
  }


  resetLiveForm() {
    this.tableApi.resetLiveForm(this.myLiveForm, ['invoice_number'], this.getData.bind(this))
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

  // clearImage() {
  //   this.myDataForm.get('image')?.setValue('');
  //   this.imageUrl = '';
  //   this.imageDiv = true;
  // }

  Action = 'Added';

  onSubmitData() {
    this.tableApi.onSubmitData(this.myDataForm, null, this.insertData.bind(this))
  }


  insertData(action: string) {
    this.tableApi.insertData(this.myDataForm, this.showError.bind(this), this.searchtab.bind(this), this.getData.bind(this), null, this.preserveField.bind(this), action)
  }

  // reset form fileds
  preserveField() {
    this.tableApi.preserveField(this.myDataForm, ['table', 'invoice_id', 'uploadImage', 'action'], null);
  }


  clearItemForm() {
    const itemsFormArray = this.myDataForm.get('items_container') as FormArray;

    // Ensure at least one item remains
    while (itemsFormArray.length > 1) {
      itemsFormArray.removeAt(1); // Always remove the second item, keeping the first
    }
  }



  numberOnly(event: any): boolean {
    return this.tableApi.numberOnly(event);
  }

  decimalNumberOnly(event: any): boolean {
    return this.tableApi.decimalNumberOnly(event);
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
        'invoice_master',
        'id',
        null
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
    this.tableApi.deleteData(value, this.getData.bind(this), 'invoice_id', 'invoice_master')
  }

  showError(error: any) {
    this.tableApi.showError(error, this.myDataForm);
  }

  myLiveForm = new FormGroup({
    invoice_number: new FormControl(''),
    table_name: new FormControl("invoice_master"),
    columnToShow: new FormControl('invoice_id,invoice_number,invoice_date,NAME,email,phone,total_amount'),
    currentPage: new FormControl(1),
    pageLimit: new FormControl('5'),
    sortOn: new FormControl('id'),
    sortOrder: new FormControl('DESC'),
    join_columns: new FormControl('client_master cm'),
    join_on: new FormControl('cm.id = invoice_master.client_id'),
  })

  myDataForm = new FormGroup({
    invoice_number: new FormControl('', [Validators.required, Validators.minLength(3), Validators.maxLength(40), Validators.pattern(/^[a-zA-Z0-9 ]+$/)]),
    invoice_date: new FormControl('', [Validators.required, Validators.minLength(3)]),
    total_amount: new FormControl('', [Validators.required, Validators.pattern(/^[0-9.]+$/)]),
    NAME: new FormControl('', [Validators.required]),
    item_id: new FormControl('', [Validators.required, Validators.pattern(/^[0-9.]+$/)]),
    item_name: new FormControl('', [Validators.required]),
    item_price: new FormControl('', [Validators.required, Validators.pattern(/^[0-9]+$/)]),
    quantity: new FormControl('', [Validators.required, Validators.pattern(/^[0-9.]+$/)]),
    amount: new FormControl('', [Validators.required, Validators.pattern(/^[0-9.]+$/)]),
    email: new FormControl('', [Validators.required, Validators.email]),
    phone: new FormControl('', [Validators.required, Validators.pattern(/^[0-9]{10}$/)]),
    client_id: new FormControl('', [Validators.required]),
    address: new FormControl('', [Validators.required]),
    table: new FormControl('invoice_master'),
    uploadImage: new FormControl('./items'),
    invoice_id: new FormControl(''),
    action: new FormControl(''),
    items_container: new FormArray([
      this.createCloneItemsForm()
    ])
  })



  items_container = this.myDataForm.get('items_container') as FormArray;

  createCloneItemsForm(): FormGroup {
    return new FormGroup({
      item_id: new FormControl('', [Validators.required, Validators.pattern(/^[0-9.]+$/)]),
      item_name: new FormControl('', [Validators.required]),
      item_price: new FormControl('', [Validators.required, Validators.pattern(/^[0-9.]+$/)]),
      quantity: new FormControl('', [Validators.required, Validators.pattern(/^[0-9]+$/)]),
      amount: new FormControl('', [Validators.required, Validators.pattern(/^[0-9.]+$/)]),
    })
  }


  addItemsForm() {

    this.items_container.push(this.createCloneItemsForm());

  }

  removeItemForm(index: number) {
    if (this.items_container.length > 1) {
      this.items_container.removeAt(index);
    }
  }


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

