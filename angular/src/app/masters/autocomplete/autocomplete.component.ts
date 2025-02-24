import {Component, input , signal , effect } from '@angular/core';
import { ApiService } from '../../api.service';

interface data {
  id: string,
  NAME: string,
  email: string,
  phone: string,
}


@Component({
  selector: 'app-autocomplete',
  templateUrl: 'autocomplete.component.html',
  styles: ``,
  imports: [],
})
export class AutocompleteComponent {
  
  clientName = input<string>('');
  options = signal<data[]>([]);

  constructor(private api : ApiService){
    effect(() => {
      if (this.clientName()) {
        this.change();
      }
      if(this.clientName() == ""){
        this.options.set([]);
      }
    });
  }


  change(){

    const fromData = new FormData();
    fromData.append('name' , this.clientName());

    this.api.tableApi('dropdowncontroller','client_autocomplete' ,fromData  ).subscribe((res:any)=>{
      console.log(res);
      this.options.set(res.object);
      console.log(this.options())
    })

  }

}
