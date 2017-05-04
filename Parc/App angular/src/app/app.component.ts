import { Component } from '@angular/core';
import { HomeComponent } from './home/home.component';
import { DatosService } from './services/datos.service';
import { Ng2SmartTableModule } from 'ng2-smart-table';
import { LocalDataSource } from 'ng2-smart-table';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  size = 10;
  foto = "../assets/1.jpg";
  form = {nombre:"nada", email:"nada2"};
  source:LocalDataSource = new LocalDataSource();
  settings = {add:{addButtonContent:'agregar'},
    columns: {
    id: {title: 'ID'},
    mail: {title: 'E-Mail'},
    pass: {title: 'Password'},
    nick: {title: 'Heroe'}
  },

    /*pager : {
      perPage : 2
    },*/
    noDataMessage : "No hay datos para mostrar.",

    actions : {
      edit : true,
      add : true,
      delete : true
    },

    edit : {
      editButtonContent : "Modificar",
      saveButtonContent : "Guardar",
      cancelButtonContent : "Cancelar",
      confirmSave : true
    }
  };

  constructor(private ds: DatosService)
  {
    this.ds.TraerDatos()
    .then(datos => {
        console.log(datos);
        this.source.load(datos);
    })
    .catch();

    this.ds.Agregar("ram","aaa","123")
    .then(datos => {
        console.log(datos);
        this.source.load(datos);
    })
    .catch();
  }


  Ver():void
  {
    console.log(this.ds.TraerDatos());
  }

  Editar($event)
  {
    console.log($event);
    //$event.confirm.resolve($event.newData);
  }















  /*CrearEvento($event)
  {
    console.log($event);
  }*/
}
