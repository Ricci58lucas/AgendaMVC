<!DOCTYPE html>
<html>
    <head>
        <title>Agenda MVC</title>
    </head>
    <body>
        <!-- Estas clases vienen del  link CSS de Bootsrap en el index -->
        <!-- //contenedor responsive (para varios dispositivos) -->
        <div class="container">

            <!-- //tabla con clases de diseño y para hacerla responsive -->
            <table class="table table-responsive table-striped table-hover">
                <!-- //la fila de los headers (Nombre, Apellido y Numero en negrita) -->
                <thead>
                    <tr class="info">
                        <form action="index.php" method="POST">
                            <th>Nombre <button type="submit" class="btn btn-info" name="alfSortNom_btn" value="SortNom" title="ordenado alfabético del nombre"><img src="Images/alfabetical_symbol.png" class="img-responsive" alt="Alfabetical Mode" width="20" height="16"></button></th>
                            <th>Apellido <button type="submit" class="btn btn-info" name="alfSortApe_btn" value="SortApe" title="ordenado alfabético del apellido"><img src="Images/alfabetical_symbol.png" class="img-responsive" alt="Alfabetical Mode" width="20" height="16"></button></th>
                        </form>
                        <th>Numero</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //mostramos los elementos del array (los contactos) que vienen del modelo
                        foreach($contactosArray as $registro){
                            echo "<tr id='registro".$registro["numero"]."'>";
                                echo "<td>".$registro["nombre"]."</td>";
                                echo "<td>".$registro["apellido"]."</td>";
                                echo "<td>".$registro["numero"]."</td>";
                                echo "<td><button type='submit' class='btn btn-warning' onclick='editContact(".$registro["numero"].", getRegister())''>Editar</button></td>";
                                echo "<form class='form-inline' action='index.php' method='POST'>";
                                    echo "<td><button type='submit' class='btn btn-danger' value=".$registro["numero"]." name='borrar'>Borrar</button></td>";
                                echo "</form>";
                            echo "</tr>";

                            echo "<tr id='formEditar".$registro["numero"]."' style='display:none'>";
                                echo "<form action='index.php' method='POST'>";
                                echo "<td><input type='text' class='form-control' placeholder=".$registro["nombre"]." name='nombreEdit'></td>";
                                echo "<td><input type='text' class='form-control' placeholder=".$registro["apellido"]." name='apellidoEdit'></td>";
                                echo "<td><input type='text' class='form-control' placeholder=".$registro["numero"]." name='numeroEdit'></td>";
                                echo "<td><button type='submit' class='btn btn-success' name='aceptarEdit' value=".$registro["numero"].">Aceptar</button></td>";
                                echo "<td><button type='submit' class='btn btn-danger'>Cancelar</button></td>";
                                echo "</form>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
                <tr class="info">
                    <!-- //form para insertar contactos -->
                    <form  class="inline-form" action="index.php" method="POST">
                        <td><input type="text" class="form-control"  placeholder="Nombre" name="nombre" required></td>
                        <td><input type="text" class="form-control" placeholder="Apellido" name="apellido"></td>
                        <td><input type="text" class="form-control" placeholder="Numero" name="numero" required></td>
                        <td><button type="submit" class="btn btn-primary" name="insertar">Agregar Contacto</button></td>
                    </form>
                    <form class="inline-form" action="index.php" method="POST">
                        <td><button type="submit" class="btn btn-info" value="debug" name="debug_btn" title="debugger mode!!!"><img src="Images/debug_symbol.png" class="img-responsive" alt="Debug Mode" width="32" height="32"></button></td>
                    </form>
                </tr>
            </table>
        </div>
        <p id="demo"></p>
    </body>
    <script>
        var register;
        function editContact(id, idRegister){ //se pasa por parametro el numero del contacto que se quiere editar y el numero del que se estaba editando antes
            register = id; //se guarda el numero que se esta editando ahora en un "registro" del numero anterior

            //se ocultan los datos y se muestra el formulario del numero que se esta editando
            document.getElementById("registro"+id).style.display="none";
            document.getElementById("formEditar"+id).style.display="";

            //se oculta el formulario y se muestran los datos del numero que estaba editando (el numero del registro)
            document.getElementById("registro"+idRegister).style.display="";
            document.getElementById("formEditar"+idRegister).style.display="none";
        }

        function getRegister(){ //se retorna el numero que se estaba editando (el numero del registro)
            return register;
        }
    </script>
</html>