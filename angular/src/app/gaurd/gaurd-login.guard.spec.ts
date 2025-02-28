import { TestBed } from '@angular/core/testing';
import { CanActivateFn } from '@angular/router';

import { gaurdLoginGuard } from './gaurd-login.guard';

describe('gaurdLoginGuard', () => {
  const executeGuard: CanActivateFn = (...guardParameters) => 
      TestBed.runInInjectionContext(() => gaurdLoginGuard(...guardParameters));

  beforeEach(() => {
    TestBed.configureTestingModule({});
  });

  it('should be created', () => {
    expect(executeGuard).toBeTruthy();
  });
});
