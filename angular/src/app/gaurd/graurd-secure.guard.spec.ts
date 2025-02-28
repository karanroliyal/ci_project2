import { TestBed } from '@angular/core/testing';
import { CanActivateFn } from '@angular/router';

import { graurdSecureGuard } from './graurd-secure.guard';

describe('graurdSecureGuard', () => {
  const executeGuard: CanActivateFn = (...guardParameters) => 
      TestBed.runInInjectionContext(() => graurdSecureGuard(...guardParameters));

  beforeEach(() => {
    TestBed.configureTestingModule({});
  });

  it('should be created', () => {
    expect(executeGuard).toBeTruthy();
  });
});
