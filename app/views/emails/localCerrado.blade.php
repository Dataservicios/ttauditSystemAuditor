<html lang="en">

<body>

@if($tipo=='LocalCerrado')
    <table>
        <tr><td valign="top">
                <table>

                    <tr>
                        <td>Titulo:</td>
                        <td>{{$titulo}}</td>
                    </tr>
                    <tr>
                        <td>Motivo:</td>
                        <td>{{$motivo}}</td>
                    </tr>
                    <tr>
                        <td>Agente:</td>
                        <td>{{$agente}}</td>
                    </tr>
                    <tr>
                        <td>Dirección:</td>
                        <td>{{$direccion}}</td>
                    </tr>
                    <tr>
                        <td>Distrito:</td>
                        <td>{{$distrito}}</td>
                    </tr>
                    <tr>
                        <td>Fecha:</td>
                        <td>{{$fecha}}</td>
                    </tr>
                </table>
            </td>
            <td>
                <img src="{{$foto}}">
            </td>
        </tr>
    </table>

@endif

</body>
</html>