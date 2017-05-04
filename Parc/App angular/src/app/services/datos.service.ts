import { Injectable } from '@angular/core';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class DatosService {

  constructor(public http:Http){ }

  TraerDatos() {
    //return this.http.get('http://www.osmar.hol.es/index.php/usuarios')
    return this.http.get('http://www.mocky.io/v2/5908f4f5250000fd1459e9aa')
    .toPromise()
    .then(this.extractData)
    .catch(this.error);
  }

  private extractData(res: Response)
  {
      return res.json();
  }

  private error(error: Response)
  {
      return error;
  }

    Agregar(a,b,c)
    {
    return this.http.get('http://www.osmar.hol.es/index.php/agregar2/'+a+"/"+b+"/"+c)
    .toPromise()
    .then(this.extractData)
    .catch(this.error);
  }


}
