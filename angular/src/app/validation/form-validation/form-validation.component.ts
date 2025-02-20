import { Component, input } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Component({
  selector: 'app-form-validation',
  imports: [],
  templateUrl: './form-validation.component.html',
  styleUrl: './form-validation.component.css'
})
export class FormValidationComponent {

  Form = input<FormGroup>();
  fieldName = input<string>('');
  minLength = input<number>();
  maxLength = input<number>();
  

}
