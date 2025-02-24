import { Component } from '@angular/core';
import { FormValidationComponent } from '../../validation/form-validation/form-validation.component';

@Component({
  selector: 'app-item-form',
  imports: [FormValidationComponent],
  template: `
  
  <input type="hidden" formControlName="item_id" [readOnly]="true">

<div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
    <label for="itemNameId" class="form-label">Item name <span
            class="text-danger">*</span></label>
    <input type="text" id="itemNameId" formControlName="item_name"
        class="form-control form-control-sm">
    <!-- <app-form-validation [Form]="myDataForm" fieldName="item_name" /> -->
</div>

<div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
    <label for="itemPriceId" class="form-label">Item price <span
            class="text-danger">*</span></label>
    <input type="text" id="itemPriceId" formControlName="item_price" [readOnly]="true"
        class="form-control form-control-sm">
    <!-- <app-form-validation [Form]="myDataForm" fieldName="item_price" /> -->
</div>

<div class="col-md-2 col-xl-2 col-sm-6 col-xs-6 mb-3">
    <label for="itemQuantityId" class="form-label">Quantity <span
            class="text-danger">*</span></label>
    <input type="number" id="itemQuantityId" formControlName="quantity"
        class="form-control form-control-sm">
    <!-- <app-form-validation [Form]="myDataForm" fieldName="quantity" /> -->
</div>

<div class="col-md-3 col-xl-3 col-sm-6 col-xs-6 mb-3">
    <label for="itemQuantityId" class="form-label">Amount <span
            class="text-danger">*</span></label>
    <input type="text" id="itemQuantityId" formControlName="amount" [readOnly]="true"
        class="form-control form-control-sm">
    <!-- <app-form-validation [Form]="myDataForm" fieldName="amount" /> -->
</div>

<div class="col-1 col-md-1 col-xl-1 mt-4">
    <button class="btn btn-danger btn-sm" >X</button>
</div>
  
  `,
  styles: ``
})
export class ItemFormComponent {
  // myDataForm: FormGroup<any> | undefined;

}
