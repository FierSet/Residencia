import React, { useState, useEffect } from 'react';

import Caracteristicas from './Caracteristicas';
import menu from './cabecera';

import "./interface.css";

function App() 
{

  const [paginabase] = useState("http://miguelaoz.atwebpages.com/recidencias/"); //http://localhost/residencias/  //http://miguelaoz.atwebpages.com/recidencias/
  const [pagina] = useState(paginabase + "index.php");

  const [Keys, setkey] = useState([]);
  const [text, settext] = useState([]);

  const [vercuenta, setvercuenta] = useState();

  const [mostrarcarac, setmostrarcarac] = useState(false);
  const [expande, setexpande] = useState(false);

  const [min, setmin] = useState(0);
  const [max, setmax] = useState(11);

  const [dif, setdif] = useState(0);
  const [tope, settope] = useState(0);

  const colortext = (extractext) =>
  {
    console.log("change color");
    let colorm = "#000000";

    if(extractext == -1)
      colorm = "#B80303";
    if(extractext == 1)
      colorm = "#20AC01";
    if(extractext == 0)
      colorm = "#000000";

    return colorm;
  }

  const Colors =  
  [
    "#16A085",
    "#27AE60",
    "#2C3E50",
    "#9B59B6",
    "#E74C3C",
    "#77B1A9"
  ];

  const [randomCOLOR] = React.useState(Math.floor(Math.random() * Colors.length)); // sect position of array Colors
  
  
  useEffect( () =>
  {
    cargatabla();
  }, []);
  
  const muestradatosListados = () =>
  {
    let datas = [];
    let muestra = [];
        
    for(let i = 0; i < text.length; i++) //extrae los datos en una matris
      datas.push(
        <tr onClick = {() => muestragerarquias(text[i])}>
        {
          Keys.map(k => 
          (
            <td style={{color: k == "Estado" ? colortext(text[i][k]): null}}>{(k == "Estado" && text[i][k] == 0) ? "Pre-registr" : (k == "Estado" && text[i][k] == 1)? "Registrado" : (k == "Estado" && text[i][k] == -1) ? "deshabilitado" : text[i][k]}</td>
          ))
        }
        </tr>
      );

    for(let i = min; i < max; i++)
      muestra.push(datas[i])

    return muestra;
  }

  const retroceso = () => 
  {
    if(max === tope && dif !== 0)
    {
      setmin(min - 11);
      setmax(max - dif);
      setdif(0);
    }
    else
    {
      setmin(min - 11)
      setmax(max - 11)
    }
  }

  const avanza = () => 
  {
    if((max + 11) > tope)
    {
      setmin(max)
      setmax(tope)
      setdif(tope - max)
    }
    else
    {
      setmin(min + 11)
      setmax(max + 11)
    }   
  }

  const buscar = (datos) =>
  {
    setmin(0);
    setmax(11);
    const requestOptions = {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(
        { 
          "ID": datos.ID, 
          "Nombre": datos.Nombre.replace(" ", "%20"), 
          "Pais": datos.Pais.replace(" ", "%20"),
          "Region": datos.Region.replace(" ", "%20")
        })
  };
    /*
    if(datos.ID || datos.Nombre || datos.Pais || datos.Region)
    {
      pagtem += "?";

      if(datos.ID)
        pagtem += "ID=" + datos.ID;
      
      if(datos.ID && datos.Nombre)
        pagtem += "&Nombre=" + datos.Nombre.replace(" ", "%20");
      else if(datos.Nombre)
        pagtem += "Nombre=" + datos.Nombre.replace(" ", "%20");

      if((datos.ID || datos.Nombre) && datos.Pais)
        pagtem += "&Pais=" + datos.Pais.replace(" ", "%20");
      else if(datos.Pais)
        pagtem += "Pais=" + datos.Pais.replace(" ", "%20");

      if((datos.ID || datos.Nombre || datos.Pais) && datos.Region)
        pagtem += "&Region" + datos.Region.replace(" ", "%20");
      else if(datos.Region)
        pagtem += "Region=" + datos.Region.replace(" ", "%20"); 
    }
    */

    cargatabla(requestOptions);
  }

  const cargatabla = (requestOptions) =>
  {
    fetch(pagina, requestOptions)
    .then((res) => res.json())
    .then((data) => {
    
      console.log(data);
      setkey(Object.keys(data[0]));
      settope(data.length);
      settext(data);
      
    })
    .catch((err) => console.log(err))
  } 

  const muestragerarquias = (e) =>
  {
    setmostrarcarac(true);
    setvercuenta(e);

  }

  return (
    <div style = {{backgroundColor: Colors[randomCOLOR], minHeight: "100vh"}}>

      
      <div className = 'container pt-5'>
        <div id = 'base' className = 'text-center card'>
          
          {
            (!mostrarcarac) ? 
              <form onSubmit={ e => {
                e.preventDefault();

                const datosbusqueda =
                {
                  ID: e.target.ID.value,
                  Nombre: e.target.Nombre.value,
                  Pais: e.target.Pais.value,
                  Region: e.target.Region.value
                };

                buscar(datosbusqueda);
              }}>
                <div id = 'cabecera'>
                  <header id="menu">
                    <ul>
                    {
                      menu.map(e => 
                        <li Key = {e.id}>
                        {
                          (e.type !== "submit") ? <input type = {e.type} className = {e.class} id = {e.id} name = {e.id}  placeholder = {e.placeholder}></input> 
                          : 
                          <button className = {e.class} type = {e.type}><i className = "fa-solid fa-magnifying-glass"></i></button>
                        }
                        </li>
                      )
                    }
                    </ul>
                  </header>
                </div>
              </form>
            :
              null
          }

          {
            (mostrarcarac) ? 
              <Caracteristicas data = {vercuenta} pag={paginabase} setmostrarcarac = {setmostrarcarac} />: null
          }

          <table> 
              <tr>
               {
                  Keys.map( e => (
                    <th>{e}</th>
                  ))
                }
              </tr>
                
                {
                  !expande ? muestradatosListados() 
                  :
                    text.map(e => (
                      
                      <tr onClick = {() => muestragerarquias(e)}>
                      {
                        Keys.map(k => (
                          <td>
                            <p style={{color: k == "Estado" ? colortext(e[k]): null}}> {(k == "Estado" && e[k] == 0)? "Pre-registro" : (k == "Estado" && e[k] == 1) ? "Registro" : (k == "Estado" && e[k] == -1) ? "Desabilitado" : e[k]} </p>
                          </td>
                        ))
                      }
                      </tr>
                    ))
                }
                </table>

                {
                  (tope > 11) ? 
                    <div id = 'corenave'>
                      <button id = 'naveexten' onClick = {() => setexpande(!expande)}> <i className = {(!expande ? "fa-solid fa-arrow-down" : "fa-solid fa-arrow-up")}></i></button>
                      {
                        (!expande ? 
                          <div id = 'navtanble'>
                            <button onClick = {() => min > 0 ? retroceso() : null}> <i className = "fa-solid fa-arrow-left" style={{color: (min > 0) ? "#000000": "#6C6C6C",}} ></i> </button>
                            /
                            <button onClick = {() => max < tope ? avanza() : null}> <i className = "fa-solid fa-arrow-right" style={{color: (max < tope) ? "#000000": "#6C6C6C",}}></i> </button>
                              {(tope/11) % 1 === 0 ? parseInt(max/11) : (max === tope) ? parseInt(max/11) + 1 : parseInt(max/11)} 
                              / 
                              {((tope/11) % 1 === 0) ? parseInt(tope/11) : parseInt(tope/11) + 1}
                            </div>
                            : 
                            null
                        )
                      }
                    </div>
                  : null

                }

        </div>
      </div>

      
      <footer id="pie">
        <p>Desarrollado por<a href = 'http://miguelaoz.atwebpages.com/CV-JavaScript/'>Miguel Angel Ortega.</a> Residencia Profecionale 2023</p>
      </footer>
      
    </div>
  );
}

export default App;
