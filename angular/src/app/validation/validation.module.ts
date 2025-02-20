import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormValidationComponent } from './form-validation/form-validation.component';



@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    FormValidationComponent
  ],
  exports: [FormValidationComponent]
})
export class ValidationModule { }
