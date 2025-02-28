import { Routes } from '@angular/router';
import { BodyComponent } from './project-layout/body/body.component';
import { LoginComponent } from './login-page/login/login.component';
import { graurdSecureGuard } from './gaurd/graurd-secure.guard';
import { gaurdLoginGuard } from './gaurd/gaurd-login.guard';

export const routes: Routes = [

    {
        path:'',
        redirectTo:'/dash/dashboard',
        pathMatch:'full'
    },
    {
        path:'login',
        title: 'Login',
        component: LoginComponent,
        canActivate: [gaurdLoginGuard],
    },
    {
        path:'dash',
        title:'dash',
        component: BodyComponent,
        canActivate: [graurdSecureGuard],
        children:[
            {
                path:'user-master',
                title:'User master',
                loadComponent:()=>import('./masters/user-master/user-master.component').then(m=>m.UserMasterComponent),
                canActivate: [graurdSecureGuard]
            },
            {
                path:'client-master',
                title:'Client master',
                loadComponent:()=>import('./masters/client-master/client-master.component').then(m=>m.ClientMasterComponent),
                canActivate: [graurdSecureGuard]
            },
            {
                path:'dashboard',
                title:'Dashboard',
                loadComponent:()=>import('./masters/dashboard/dashboard.component').then(m=>m.DashboardComponent),
                canActivate: [graurdSecureGuard]
            },
            {
                path:'item-master',
                title:'Item master',
                loadComponent:()=>import('./masters/item-master/item-master.component').then(m=>m.ItemMasterComponent),
                canActivate: [graurdSecureGuard]
            },
            {
                path:'invoice',
                title:'Invoice master',
                loadComponent:()=>import('./masters/invoice/invoice.component').then(m=>m.InvoiceComponent),
                canActivate: [graurdSecureGuard]
            },
            {
                path:'auto',
                title:'Invoice master',
                loadComponent:()=>import('./masters/autocomplete/autocomplete.component').then(m=>m.AutocompleteComponent),
                canActivate: [graurdSecureGuard]
            },
        ]
    }

];
