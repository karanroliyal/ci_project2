import { Component, Input } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { NgClass } from '@angular/common';
import { OnInit } from '@angular/core';

@Component({
  selector: 'app-paggination',
  imports: [NgClass],
  template: `
  
  <div  class="pagination-div">
            <nav aria-label="Page navigation example" >
                <ul class="pagination">
                <li class="page-item"  >
                    <button class="page-link" [ngClass]="{'disabled':previousDisable}" aria-label="Previous" (click)="firstPage()" >
                      <span aria-hidden="true">First</span>
                    </button>
                  </li>
                  <li class="page-item"  >
                    <button class="page-link"  [ngClass]="{'disabled':previousDisable}" aria-label="Previous" (click)="previousPage()">
                      <span aria-hidden="true">&laquo;</span>
                    </button>
                  </li>
                  <li class="page-item"><button class="page-link active" href="#">{{page_open}}</button></li>
                  <li class="page-item" >
                    <button class="page-link" href="#" [ngClass]="{'disabled':nextDisable}" aria-label="Next" (click)="nextPage()">
                      <span aria-hidden="true">&raquo;</span>
                    </button>
                  </li>
                  <li class="page-item"  >
                    <button class="page-link" [ngClass]="{'disabled':nextDisable}" aria-label="Previous" (click)="lastPage()" >
                      <span aria-hidden="true">Last</span>
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
export class PagginationComponent implements OnInit {

  @Input() formName: FormGroup | undefined;
  @Input() pages_total: number = 1;
  @Input() page_open: number = 1;
  @Input() callTable: Function | undefined;

  previousDisable: boolean = true;
  nextDisable: boolean = true;

  ngOnInit(): void {
    if (this.page_open == 1) {
      this.previousDisable = true
    } else {
      this.previousDisable = false
    }
    if (this.page_open < this.pages_total) {
      this.nextDisable = true
    } else {
      this.nextDisable = false
    }
  }



  // Next page in paggination function
  nextPage() {
    let page = this.page_open + 1;
    if (page <= this.pages_total) {
      this.formName?.controls['currentPage'].setValue(this.page_open + 1);
      this.page_open++;
      if (this.callTable) {
        this.callTable();
      }
    }
    if (this.page_open == 1) {
      this.previousDisable = true
    } else {
      this.previousDisable = false
    }
    if (this.page_open == this.pages_total) {
      this.nextDisable = true
    } else {
      this.nextDisable = false
    }
  }

  // Previous page 
  previousPage() {
    if (this.page_open > 1) {
      this.formName?.controls['currentPage'].setValue(this.page_open - 1);
      this.page_open--;
      // this.done.getData()
      if (this.callTable) {
        this.callTable();
      }
    }
    if (this.page_open == 1) {
      this.previousDisable = true
    } else {
      this.previousDisable = false
    }
    if (this.page_open == this.pages_total) {
      this.nextDisable = true
    } else {
      this.nextDisable = false
    }
  }

  // First page 
  firstPage() {
    this.formName?.controls['currentPage'].setValue(1);
    this.page_open = 1;
    if (this.callTable) {
      this.callTable();
    }
    if (this.page_open == 1) {
      this.previousDisable = true
    } else {
      this.previousDisable = false
    }
    if (this.page_open == this.pages_total) {
      this.nextDisable = true
    } else {
      this.nextDisable = false
    }
  }

  // Last page 
  lastPage() {
    
    this.formName?.controls['currentPage'].setValue(this.pages_total);
    this.page_open = this.pages_total;
    if (this.callTable) {
      this.callTable();
    }
    if (this.page_open == 1) {
      this.previousDisable = true
    } else {
      this.previousDisable = false
    }
    if (this.page_open == this.pages_total) {
      this.nextDisable = true
    } else {
      this.nextDisable = false
    }
  }

  


}
