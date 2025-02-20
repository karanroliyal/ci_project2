import { Component, inject, Input } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { UserMasterComponent } from '../../masters/user-master/user-master.component';

@Component({
  selector: 'app-paggination',
  imports: [],
  template: `
  
  <div  class="pagination-div">
            <nav aria-label="Page navigation example" >
                <ul class="pagination">
                  <li class="page-item"  >
                    <button class="page-link"  aria-label="Previous" (click)="previousPage()">
                      <span aria-hidden="true">&laquo;</span>
                    </button>
                  </li>
                  <li class="page-item"><button class="page-link active" href="#">{{page_open}}</button></li>
                  <li class="page-item" >
                    <button class="page-link" href="#" aria-label="Next" (click)="nextPage()">
                      <span aria-hidden="true">&raquo;</span>
                    </button>
                  </li>
                </ul>
              </nav>
        </div>
  
  `,
  styles: `
  .pagination-div{
    user-select: none;
  }
  `
})
export class PagginationComponent {

  @Input() formName :FormGroup | undefined ;
  @Input() pages_total : number = 1;
  @Input() page_open : number  = 1;

  private done = inject(UserMasterComponent)

  // Next page pin paggination function
  nextPage(){
    let page = this.page_open + 1;
    console.log(page)
    console.log('page total',this.pages_total)
    if(page <= this.pages_total){
      console.log("next page" , this.page_open , this.pages_total , 'before')
      this.formName?.controls['currentPage'].setValue(this.page_open + 1);
      this.page_open++;
      this.done.getData()
      console.log("next page" , this.page_open , this.pages_total , 'after')
    }
  }
  
  // // Previous page 
  previousPage(){
    if(this.page_open > 1){
      console.log("previous page" , this.page_open , this.pages_total , 'before')
      this.formName?.controls['currentPage'].setValue(this.page_open - 1);
      this.page_open--;
      this.done.getData()
      console.log("previous page" , this.page_open , this.pages_total , 'after')
    }
  }

}
