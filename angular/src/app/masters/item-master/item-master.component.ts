import { Component } from '@angular/core';
import { FormGroup, FormControl, ReactiveFormsModule, Validators } from '@angular/forms';
import { PagginationComponent } from "../../project-layout/paggination/paggination.component";
import { ValidationModule } from "../../validation/validation.module";
import { FormValidationComponent } from "../../validation/form-validation/form-validation.component";
import { ApiService } from '../../api.service';
import { NgClass } from '@angular/common';

interface tableData {
  id: string,
  item_name: string,
  item_description: string,
  item_price: string,
  image: string
}

interface responseData {
  table: tableData[],
  pagination: { totalPages: number, current_page_opened: number },
  query: string
}

@Component({
  selector: 'app-item-master',
  imports: [ReactiveFormsModule, PagginationComponent, FormValidationComponent, ValidationModule, NgClass],
  templateUrl: './item-master.component.html',
  styleUrl: './item-master.component.css'
})
export class ItemMasterComponent {
 // all table data
  data: responseData = { table: [{ id: '', item_name: '', item_description: '', item_price: '', image: '' }], pagination: { totalPages: 1, current_page_opened: 1 }, query: '' };

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
      this.tableApi.resetLiveForm(this.myLiveForm , ['item_name'] ,this.getData.bind(this) )
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
    this.tableApi.onSubmitData(this.myDataForm,this.imageUrl , this.insertData.bind(this))
  }


  insertData(action:string) {
    this.tableApi.insertData(this.myDataForm,this.showError.bind(this),this.searchtab.bind(this),this.getData.bind(this),this.file,this.preserveField.bind(this),action)
  }

  // reset form fileds
   preserveField() {
    this.tableApi.preserveField(this.myDataForm , ['table' ,'id' ,'uploadImage' ,'action'] , this.clearImage.bind(this));
  }

  numberOnly(event:any): boolean {
    return this.tableApi.numberOnly(event);
   }

  decimalNumberOnly(event:any): boolean {
    return this.tableApi.decimalNumberOnly(event);
  }


  updateBtn = false;

  // Edit data functions
  async editData(value: any) {
    try {
      const [updatedImageUrl, updatedUpdateBtn , updatedDiv] = await this.tableApi.editData(
        value,
        this.updateBtn,
        this.imageUrl,
        this.imageDiv,
        this.myDataForm,
        'item_master',
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
    this.tableApi.deleteData(value ,this.getData.bind(this) , 'id' , 'item_master')
  }

  showError(error: any) {
    this.tableApi.showError(error , this.myDataForm);
  }

  myLiveForm = new FormGroup({
    item_name: new FormControl(''),
    table_name: new FormControl("item_master"),
    columnToShow: new FormControl('id,item_name,item_description,item_price,image'),
    currentPage: new FormControl(1),
    pageLimit: new FormControl('5'),
    sortOn: new FormControl('id'),
    sortOrder: new FormControl('DESC'),
  })

  myDataForm = new FormGroup({
    item_name : new FormControl('',[Validators.required , Validators.minLength(3) , Validators.maxLength(40) , Validators.pattern(/^[a-zA-Z- ]+$/)]),
    item_description : new FormControl('' , [Validators.required , Validators.minLength(3) ]),
    item_price : new FormControl('' , [Validators.required , Validators.pattern(/^[0-9.]+$/)]),
    image: new FormControl('', [Validators.required]),
    table: new FormControl('item_master'),
    uploadImage: new FormControl('./items'),
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

