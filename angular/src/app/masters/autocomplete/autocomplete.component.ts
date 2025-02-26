import { Component, input, signal, effect, Input } from '@angular/core';
import { ApiService } from '../../api.service';
import { FormGroup } from '@angular/forms';

interface data {
  id: string,
  NAME: string,
  email: string,
  phone: string,
  item_name : string,
  item_price: string,
}


@Component({
  selector: 'app-autocomplete',
  templateUrl: 'autocomplete.component.html',
  styles: `
  `,
  imports: [],
})
export class AutocompleteComponent {

  clientName = input<string>('');
  options = signal<data[]>([]);
  @Input() formGroup: FormGroup | undefined;
  @Input() filedsArray: string[] = [];
  @Input() methodName: string = '';
  @Input() autoCompleteFor: string = '';
  @Input() calculateFun: Function | undefined;
  optionVisible : boolean = true;

  constructor(private api: ApiService) {
    effect(() => {
      if (this.clientName().length) {
        this.change();
      }
      if (this.clientName() == "") {
        this.options.set([]);
      }
    
    });
  }


  change() {

    let arrayId: number[]  = []

    
    let  formData = new FormData();
    if(this.autoCompleteFor == 'client'){
      formData.append('name' , this.clientName())
    }else{
      formData.append('item_name' , this.clientName());
      formData.append('arrId' , JSON.stringify(arrayId));
    }
    
    this.api.tableApi('Invoice_Master_Controller', this.methodName, formData).subscribe((res: any) => {
      console.log(res);
      this.options.set(res.object);
      console.log(this.options());
    })



  }

  selectedArray: any[] = [];


  myId(getId: string) {
    console.log(getId);

    let selectedArray: any[] = [];

    selectedArray = this.options().filter((ele) => ele.id == getId);

    console.log(selectedArray, 'filter')

    if(this.autoCompleteFor == 'client'){

      selectedArray.map((ele) => {
        this.formGroup?.get('client_id')?.setValue(ele.id)
        this.formGroup?.get('NAME')?.setValue(ele.NAME)
        this.formGroup?.get('email')?.setValue(ele.email)
        this.formGroup?.get('phone')?.setValue(ele.phone)
        this.formGroup?.get('address')?.setValue(ele.address)
      })
    }else{
      selectedArray.map((ele) => {
        this.formGroup?.get('item_id')?.setValue(ele.id)
        this.formGroup?.get('item_name')?.setValue(ele.item_name)
        this.formGroup?.get('item_price')?.setValue(ele.item_price)
        this.formGroup?.get('quantity')?.setValue(1)
        this.formGroup?.get('amount')?.setValue(ele.item_price * 1)
      })
      if(this.calculateFun){
        this.calculateFun(0);
      }
    }

    this.optionVisible = false
    this.options.set([]);

  }

}
