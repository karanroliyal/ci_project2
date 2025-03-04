import { Routes } from '@angular/router';
import { BodyComponent } from './project-layout/body/body.component';
import { LoginComponent } from './login-page/login/login.component';
import { graurdSecureGuard } from './gaurd/graurd-secure.guard';
import { gaurdLoginGuard } from './gaurd/gaurd-login.guard';
import { gaurdPagesGuard } from './gaurd/gaurd-pages.guard';

export const routes: Routes = [


    {
        path:'',
        redirectTo:'/dash/dashboard',
        pathMatch:'full',
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
                canActivate: [graurdSecureGuard],
                canMatch: [gaurdPagesGuard]
            },
            {
                path:'client-master',
                title:'Client master',
                loadComponent:()=>import('./masters/client-master/client-master.component').then(m=>m.ClientMasterComponent),
                canActivate: [graurdSecureGuard],
                canMatch: [gaurdPagesGuard]
            },
            {
                path:'dashboard',
                title:'Dashboard',
                loadComponent:()=>import('./masters/dashboard/dashboard.component').then(m=>m.DashboardComponent),
                canActivate: [graurdSecureGuard],
                canMatch: [gaurdPagesGuard]
            },
            {
                path:'item-master',
                title:'Item master',
                loadComponent:()=>import('./masters/item-master/item-master.component').then(m=>m.ItemMasterComponent),
                canActivate: [graurdSecureGuard],
                canMatch: [gaurdPagesGuard]
            },
            {
                path:'invoice',
                title:'Invoice master',
                loadComponent:()=>import('./masters/invoice/invoice.component').then(m=>m.InvoiceComponent),
                canActivate: [graurdSecureGuard],
                canMatch: [gaurdPagesGuard]
            },
            {
                path:'permission',
                title:'Permission',
                loadComponent:()=>import('./permission-comp/permission/permission.component').then(m=>m.PermissionComponent),
                canActivate: [graurdSecureGuard],
                canMatch: [gaurdPagesGuard]
            },
            {
                path:'restricted',
                title:'Restricted',
                loadComponent:()=>import('./notfound/restricted/restricted.component').then(m=>m.RestrictedComponent),
                canActivate: [graurdSecureGuard],
                canMatch: [gaurdPagesGuard]
            },
            {
                path:'404',
                title: '404',
                loadComponent:()=>import('./notfound/not-found/not-found.component').then(m=>m.NotFoundComponent)
            },
        ]
    },
    {
        path:'**',
        redirectTo: '/dash/404',
        pathMatch:'full'
    },

];
