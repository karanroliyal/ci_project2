import { Routes } from '@angular/router';
import { BodyComponent } from './project-layout/body/body.component';
// import { UserMasterComponent } from './masters/user-master/user-master.component';

export const routes: Routes = [

    {
        path:'',
        redirectTo:'dash',
        pathMatch:'full'
    },
    {
        path:'dash',
        title:'dash',
        component:BodyComponent,
        children:[
            {
                path:'user-master',
                title:'User master',
                loadComponent:()=>import('./masters/user-master/user-master.component').then(m=>m.UserMasterComponent)
            },
            {
                path:'client-master',
                title:'Client master',
                loadComponent:()=>import('./masters/client-master/client-master.component').then(m=>m.ClientMasterComponent)
            },
            {
                path:'dashboard',
                title:'Dashboard',
                loadComponent:()=>import('./masters/dashboard/dashboard.component').then(m=>m.DashboardComponent)
            },
        ]
    }

];
