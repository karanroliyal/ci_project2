import { HttpClient } from "@angular/common/http";
import { Component, Injectable } from "@angular/core";
import { FormGroup, Validators } from "@angular/forms";
import Swal from "sweetalert2";


@Component({
    selector: 'app-api-service',
    template: ``
})

@Injectable({
    providedIn: 'root'
})

export class ApiService {

    constructor(private http: HttpClient) { }

    // FormGroupName : FormGroup|null|undefined;

    // tableFunction : Function | undefined;

    tableApi(controllerName: string, methodName: string | null, formValue: any): any {

        return this.http.post('http://localhost/ci_project2/' + controllerName + '/' + methodName, formValue)

    }

    // Reset live form data 
    resetLiveForm(FormGroupName: FormGroup, dontReset: string[], tableFunction: Function) {

        dontReset.forEach((ele) => {
            FormGroupName.get(ele)?.setValue('');
        })

        setTimeout(() => {
            tableFunction();
        }, 100)

    }

    // delete data from tables
    deleteData(idValue: string, tableFunction: Function, key: string, tableName: string) {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: false,
        });
        swalWithBootstrapButtons
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                    const formData: any = new FormData();
                    formData.append('deleteid', idValue);
                    formData.append('tableName', tableName);
                    formData.append('key', key);

                    this.http.post('http://localhost/ci_project2/TableController/delete', formData).subscribe((res: any) => {
                        console.log(res);
                        tableFunction();
                    }, (error: any) => {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your can't delete this",
                            icon: "error",
                        });
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your data is safe :)",
                        icon: "error",
                    });
                }
            });




    }

    // show backend error
    showError(error: any, formGroup: FormGroup,) {

        console.log(error, 'error')
        console.log("get any error")

        Object.entries(error).forEach(([key, value]) => {

            console.log(key)
            // this.myDataForm.controls['email']
            if (key === 'email') {
                console.log(key);
            }
            if (key == 'image') {
                formGroup.controls['phone'].addValidators([Validators.nullValidator]);
            }

            Swal.fire({
                title: `${value}`,
                icon: "error",
                draggable: false,
            });

        });

    }

    // edit btn function 
    editData(editId: string, updateBtn: boolean, imageUrl: string, imageDiv: boolean, formGroup: FormGroup, tableName: string, key: string, districtFunction: Function | null): Promise<[string, boolean, boolean]> {
        updateBtn = true;

        formGroup.controls['action'].setValue('update');
        formGroup.controls['table'].setValue(tableName);

        const formData: any = new FormData();
        formData.append('id', editId);
        formData.append('table', tableName);
        formData.append('key', key);

        // Return a Promise that resolves after the HTTP request completes
        return new Promise((resolve, reject) => {
            this.http.post('http://localhost/ci_project2/insertcontroller/edit', formData).subscribe(
                (res: any) => {
                    if (res.image) {
                        if (tableName == 'item_master') {
                            imageUrl = 'http://localhost/ci_project2/items/' + res.image;
                        } else {
                            imageUrl = 'http://localhost/ci_project2/profiles/' + res.image;
                        }
                        imageDiv = false;
                        delete res.image;
                    }
                    if (res.password) {
                        delete res.password;
                    }
                    Object.entries(res).forEach(([key, value]) => {
                        if (formGroup.get(key)) {
                            formGroup.get(key)?.setValue(value);
                        }
                        if (key == 'state') {
                            if (districtFunction !== null) {
                                districtFunction(value)
                            }
                        }
                    });

                    // Resolve the Promise with the updated values
                    resolve([imageUrl, updateBtn, imageDiv]);
                },
                (error) => {
                    // Reject the Promise if there's an error
                    reject(error);
                }
            );
        });
    }

    // Stop reset button of Form to reset hidden fields of table 
    preserveField(formGroup: FormGroup, dontReset: string[], imageRemoveFunction: Function | null) {
        const preservedValues: { [key: string]: any } = {};
        dontReset.forEach((controlName) => {
            preservedValues[controlName] = formGroup.get(controlName)?.value;
        });
        formGroup.reset(preservedValues);
        if (imageRemoveFunction !== null) {
            imageRemoveFunction();
        }
    }

    // Insert form data 
     insertData(formGroup: FormGroup , showError: Function , homeTab: Function , tableLoadFunction: Function , imageFile: any |null , resetFormFunction: Function , action:string) {
        const formData = new FormData();
    
        if (imageFile !== null) {
          formData.append('image', imageFile); // Append file directly
        }
        formData.append('data', JSON.stringify(formGroup.value)); // Send additional form data
        this.http.post('http://localhost/ci_project2/insertcontroller/insert', formData).subscribe((res: any) => {
          if (res.error) {
            showError(res.error);
          } else {
            homeTab('search');
            tableLoadFunction();
            Swal.fire({
              title: `Record ${action} Successfully!`,
              icon: "success",
              draggable: false,
            });
            resetFormFunction();
            formGroup.get('action')?.setValue('');
          }
        })
    
      }

    // On Submiting form data 
    onSubmitData(formGroup: FormGroup , imageUrlValue: any | null , insertFunction: Function ) {
        const solveUpdate = formGroup.get('action')?.value == 'update';
        console.log(solveUpdate, 'update request')
        if(formGroup.controls['image']){
            if (solveUpdate && imageUrlValue !== '') {
                formGroup.controls['image'].clearValidators()
                formGroup.controls['image'].updateValueAndValidity()
            }
            else {
                formGroup.controls['image'].setValidators([Validators.required])
                formGroup.controls['image'].updateValueAndValidity()
            }
        }
        if(formGroup.controls['password']){
            if (solveUpdate && (formGroup.get('password')?.value || '').trim() === '') {
              console.log(formGroup.get('password')?.value, 'top')
              formGroup.controls['password'].clearValidators()
              formGroup.controls['password'].updateValueAndValidity()
            } else {
              console.log(formGroup.get('password')?.value, 'bottom')
              formGroup.controls['password'].setValidators([Validators.required, Validators.minLength(8), Validators.maxLength(15), Validators.pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/)]);
              formGroup.controls['password'].updateValueAndValidity()
            }
        }

        formGroup.markAllAsTouched();
        console.log(formGroup.valid)
        if (formGroup.valid) {
            if(solveUpdate){
                insertFunction('Updated');
            }else{
                insertFunction('Added');
            }
        }
      }

    // number only function 
    numberOnly(event:any): boolean {
        const charCode = (event.which) ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
    }

    //decimal number
    decimalNumberOnly(event:any): boolean {
        const charCode = event.which ? event.which : event.keyCode;
        const inputElement = event.target as HTMLInputElement;
        const currentValue = inputElement.value;
    
        // Allow numbers (0-9), dot (.) but only one decimal point
        if ((charCode >= 48 && charCode <= 57) || (charCode === 46 && !currentValue.includes('.'))) {
          return true;
        }
    
        event.preventDefault();
        return false;
      }

}