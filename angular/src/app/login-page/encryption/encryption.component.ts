import { Component } from '@angular/core';
import { Injectable } from '@angular/core'; 

import * as CryptoJS from 'crypto-js'; [1, 2, 11]

@Component({
  selector: 'app-encryption',
  imports: [],
  template: ``,
  styles: ``
})

@Injectable({
  providedIn:'root'
})


export class EncryptionComponent {

  private secretKey = 'karan_rawat_secret_key'; // Replace with your secure key



  encrypt(data: string): string {

      const encryptedData = CryptoJS.AES.encrypt(data, this.secretKey).toString();

      return encryptedData;

  }



  decrypt(encryptedData: string): string {

      const decryptedData = CryptoJS.AES.decrypt(encryptedData, this.secretKey).toString(CryptoJS.enc.Utf8);

      return decryptedData;

  }

}
