<!doctype html>
<html>
<style type="text/css">

    #body {
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 1em;
        height: auto;
        margin: 0 auto;
        padding: 0;
        width: 1194px;
    }

    #lateralizq {
        background: none repeat scroll 0 0 #556677;
        float: left;
        height: 900px;
        width: 59px;
    }

    #superiorgeneral {
        background: none repeat scroll 0 0 #118899;
        float: left;
        height: 290px;
        width: 1076px;
    }

    #superiorflotantemenu {
        background: none repeat scroll 0 0 #661100;
        float: left;
        height: 90px;
        width: 1076px;
    }

    #lateralder {
        background: none repeat scroll 0 0 rgba(183, 69, 18, 0.82);
        float: right;
        height: 900px;
        width: 300px;
    }

    #main {
        background: none repeat scroll 0 0 cyan;
        float: right;
        height: 130%;
        width: 70%;
    }

    #pie {
        background: none repeat scroll 0 0 #4455FF;
        float: left;
        height: 147px;
        width: 1076px;
    }

    #fondoabajo {
        background-color: #F2886E;
        clear: both;
        height: 34px;
        width: auto;
    }


</style>
<head>
    <link type="text/css" rel="stylesheet" href="css/UDStyle.css"/>
    <title>RL DEVELOPERS</title>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="UDCore.js"></script>
    <script type="text/javascript" src="UDModules.js"></script>
    <script type="text/javascript" src="UDApplication.js"></script>

</head>
<body style="background-color: #2a2a2a">
<div id="body" >


    <div  style="position: fixed;right: 79%;width: 300px;background: cyan">

        <a  class="button" style="font-size: 10px;" title="Ir atras" href="{{url('/xml_java')}}">
            <span  class="dashicons dashicons-admin-generic"></span><i class="fa fa-mail-reply"></i> <h2>GENERAR CODIGO JAVA</h2>
        </a><br>
        <strong id="usuario">Chat Grupal </strong>
        <div>
            <lavel for="nombre">USUARIO: </lavel>
            <label type="text" id="nombre" >
                {{Auth::User()->name}}
            </label>
        </div>

        <div class="columna"><lavel for="mensaje"></lavel><textarea style="width: 80%" id="mensaje"></textarea></div>
        <div class="columna"><button type="button" id="btnEnviar" style="width: 100%">Enviar Mensaje</button></div>
        <ul id="lista">
        </ul>

    </div>

    <div id="main">
        <div id="umldiagram"></div>
    </div>

</div>


<script src="https://www.gstatic.com/firebasejs/4.13.0/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyCF_egN6ffUTsN5kzdOYolwtCbhhXOc1Kc",
        authDomain: "diagramsecuencia.firebaseapp.com",
        databaseURL: "https://diagramsecuencia.firebaseio.com",
        projectId: "diagramsecuencia",
        storageBucket: "",
        messagingSenderId: "31340697665"
    };
    firebase.initializeApp(config);

    var txtNombre = document.getElementById('nombre');
    var txtMensaje = document.getElementById('mensaje');
    var btnEnviar = document.getElementById('btnEnviar');
    var listaChat = document.getElementById('lista');

    btnEnviar.addEventListener("click", function () {
        var nombre = txtNombre.innerHTML;
        var mensaje = txtMensaje.value;
        firebase.database().ref('chat').push({
            nombre: nombre,
            mensaje: mensaje
        });

    });
    firebase.database().ref('chat')
        .on('value', function (snapshot) {
            var html = "";
            snapshot.forEach(function (e) {
                var element = e.val();
                var nombre = element.nombre;
                var mensaje = element.mensaje;
                html += "<li><b>" + nombre + ": </b>" + mensaje + "</li>"
            })
            listaChat.innerHTML = html;
        });
</script>
<script src="vista.js"></script>
</body>
</html>