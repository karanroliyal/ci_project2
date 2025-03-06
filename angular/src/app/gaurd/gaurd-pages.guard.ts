import { inject } from '@angular/core';
import { CanMatchFn, Router } from '@angular/router';

export const gaurdPagesGuard: CanMatchFn = (route , state) => {

  const router = inject(Router);

  console.log(state, 'current route')

  let matched = true;

  if(localStorage.getItem('menu')){

    let menuData: any = localStorage.getItem('menu');
  
  
    let menu: [{ menu_name: string }] = JSON.parse(menuData);
  
    const menuArray: string[] = ['restricted','/dash/404'];
  
    menu.map((ele: any) => {
  
      let menu_route: any = ele.route;
      menu_route = menu_route.split("/").pop();
      menuArray.push(menu_route)
  
    })
  
    matched = menuArray.some((ele)=>ele === route.path);

  }


  if(!matched){
    router.navigate(['/dash/restricted']);
  }

  return true;

};
