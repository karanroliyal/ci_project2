import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EncryptionComponent } from './encryption.component';

describe('EncryptionComponent', () => {
  let component: EncryptionComponent;
  let fixture: ComponentFixture<EncryptionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EncryptionComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EncryptionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
