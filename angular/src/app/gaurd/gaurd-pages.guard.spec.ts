import { TestBed } from '@angular/core/testing';
import { CanActivateFn } from '@angular/router';

import { gaurdPagesGuard } from './gaurd-pages.guard';

describe('gaurdPagesGuard', () => {
  const executeGuard: CanActivateFn = (...guardParameters) => 
      TestBed.runInInjectionContext(() => gaurdPagesGuard(...guardParameters));

  beforeEach(() => {
    TestBed.configureTestingModule({});
  });

  it('should be created', () => {
    expect(executeGuard).toBeTruthy();
  });
});
