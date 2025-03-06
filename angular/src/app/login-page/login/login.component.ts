import { Component } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ValidationModule } from "../../validation/validation.module";
import { FormValidationComponent } from "../../validation/form-validation/form-validation.component";
import { ApiService } from '../../api.service';
import Swal from 'sweetalert2';
import { Router, RouterModule } from '@angular/router';
import { EncryptionComponent } from '../encryption/encryption.component';
import { AnimationItem } from 'lottie-web';
import { AnimationOptions, LottieComponent } from 'ngx-lottie';


@Component({
  imports: [ReactiveFormsModule, ValidationModule, FormValidationComponent, RouterModule, LottieComponent ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})


export class LoginComponent {


  constructor(private http: ApiService, private router: Router, private sercurity: EncryptionComponent) {
    localStorage.setItem('menu' , '');
  localStorage.setItem('secure_token' , '');
  localStorage.setItem('auth_token' , '');
   }

  private animationItem: AnimationItem | undefined;

  options: AnimationOptions = {
    path: '/assets/images/login_image4.json',
    loop: true,
    autoplay: false
  };

  animationCreated(animationItem: AnimationItem): void {
    this.animationItem = animationItem;
    this.play();
  }


  play(): void {
    if (this.animationItem) {
      this.animationItem.play();
    }
  }


  

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
          const menuData = res.menu;

          localStorage.setItem('secure_token', data_token)
          localStorage.setItem('auth_token', auth_token)
          localStorage.setItem('menu', JSON.stringify(menuData))



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
