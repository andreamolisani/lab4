import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { DatosService } from './services/datos.service';
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { Ng2SmartTableModule } from 'ng2-smart-table';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    Ng2SmartTableModule
  ],
  providers: [DatosService],
  bootstrap: [AppComponent]
})
export class AppModule { }
