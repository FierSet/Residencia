import {useState, useEffect} from 'react';

function Caracteristicas({data, pag, setmostrarcarac}) 
{
    const [pagina] = useState(pag);
    
    const [gelarquia, setgelarquia] = useState([]);
    const [relation, setrelation] = useState([]);

    useEffect(() => {
        cargatablaj(pagina + "jerarquia.php?ID=" + data.ID);
        cargatablar(pagina + "relationship.php?ID=" + data.ID);
    }, [])



    const cargatablaj = (P) =>
    {
        fetch(P)
        .then((res) => res.json())
        .then((data) => {
            setgelarquia(data);
        })
        .catch((err) => console.log(err))
    }

    const cargatablar = (P) =>
    {
        fetch(P)
        .then((res) => res.json())
        .then((data) => {
            setrelation(data);
        })
        .catch((err) => console.log(err))
    } 

    //<div className = 'container pt-5'>
    //<div id = 'base' className = "text-center card">

    return(
        <div className='main-box container pt-5' onClick = {() => setmostrarcarac(false)}>
            
            <div className='nombre'><h2>{data.ID} - {data.nombre}</h2></div>
            
            <div className = 'bloquemadre'>
                
                <div className="bloque">
                    <table id = 'tabla-jelarquia'>
                        <tr>
                            <th>Padre</th>
                            <th>Hijo</th>
                        </tr>
                        {
                            gelarquia.map(e => 
                                <tr>
                                    <td>{(data.ID == e.ID_padre) ? <b>{e.ID_padre}</b> : e.ID_padre}</td>
                                    <td>{(data.ID == e.ID_hijo)  ? <b>{e.ID_hijo}</b> : e.ID_hijo}</td>
                                </tr>
                            )
                        }
                    </table>

                    <table  id = 'tabla-Relationship'>
                        <tr>
                            <th>ID_ship</th>
                            <th>ROLL</th>
                        </tr>
                        {
                            relation.map(e => 
                                <tr>
                                    <td>{e.ID_ship}</td>
                                    <td>{e.Rol}</td>
                                </tr>
                            )
                        }
                    </table>
                </div>
                
            </div>

        </div>
    );
}

export default Caracteristicas;