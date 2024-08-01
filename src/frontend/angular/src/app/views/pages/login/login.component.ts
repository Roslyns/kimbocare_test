import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import AppAuthService from '../../../services/auth.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    FormsModule,
  ]
})
export class LoginComponent implements OnInit {
  
  loginForm!: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private authService: AppAuthService,
    private router: Router
  ) { }

  get fval() { return this.loginForm.controls; }
  

  ngOnInit(): void {
    this.loginForm = this.formBuilder.group({
      username: ['', [Validators.required]],
      password: ['', [Validators.required]]
    });
  }

  onFormSubmit() {
    
    if (this.loginForm.invalid) {
      return;
    }
    console.log('okay');
    
    
    const authData = this.loginForm.value;
    this.authService.auth(authData);
  }
}