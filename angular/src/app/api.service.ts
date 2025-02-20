import { HttpClient } from "@angular/common/http";
import { Component, Injectable } from "@angular/core";
import { FormGroup } from "@angular/forms";


@Component({
    selector:'app-api-service',
    template:``
})

@Injectable({
    providedIn:'root'
})

export class ApiService{

    constructor(private http : HttpClient){}


    tableApi(controllerName:string ,  methodName:string|null, formValue:any  ):any{

        return this.http.post('http://localhost/ci_project2/'+controllerName+'/'+methodName , formValue )

    }

    

}