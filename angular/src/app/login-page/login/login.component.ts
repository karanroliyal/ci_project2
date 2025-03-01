import { Component } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ValidationModule } from "../../validation/validation.module";
import { FormValidationComponent } from "../../validation/form-validation/form-validation.component";
import { ApiService } from '../../api.service';
import Swal from 'sweetalert2';
import { Router, RouterModule } from '@angular/router';
import { EncryptionComponent } from '../encryption/encryption.component';

@Component({
  imports: [ReactiveFormsModule, ValidationModule, FormValidationComponent, RouterModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})


export class LoginComponent {


  constructor(private http: ApiService, private router: Router , private sercurity: EncryptionComponent) { }

  loginForm = new FormGroup({
    Email: new FormControl('', [Validators.required]),
    Password: new FormControl('', [Validators.required])
  })


  allDataUser: any = '';

  checkLogin() {

    this.loginForm.markAllAsTouched();

    if (this.loginForm.valid) {

      const formData = new FormData();
      formData.append('email', this.loginForm.get('Email')?.getRawValue());
      formData.append('password', this.loginForm.get('Password')?.getRawValue());

      this.http.tableApi('Login_Controller', 'login_check', formData).subscribe((res: any) => {

        if (res.statusCode == 200) {
          this.router.navigate(['dash/dashboard'])
          Swal.fire({
            title: 'Login SuccessFully',
            icon: 'success',
            draggable: false
          })
          console.log(res.data);

          console.log(res.Token)
          let data_token = this.sercurity.encrypt(JSON.stringify(res.data));
          let auth_token = res.Token;

          this.allDataUser = res.data;

          localStorage.setItem('secure_token',data_token)
          localStorage.setItem('auth_token',auth_token)

        }

        
        else {
          Swal.fire({
            title: 'Incorrect credentials',
            icon: 'error',
            draggable: false
          })
        }

      })

    }

  }

}
