<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Formulario</title>
</head>

<body class="bg-dark text-white">
  <section class="container mt-5">
    <div class="row">
      <!-- Formulario -->
      <div class="col-md-5 mb-4">
        <h1 class="text-center mb-3">Formulario</h1>
        <form id="formulario" method="POST">
          <div class="col-md-5 mb-3">
            <label for="inputCodigo" class="form-label">Código</label>
            <input type="number" class="form-control" id="inputCodigo" name="codigo" placeholder="325566988" required>
          </div>
          <div class="col-md-10 mb-3">
            <label for="inputName" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="inputName" name="firstName" placeholder="Pepito" required>
          </div>
          <div class="col-md-10 mb-3">
            <label for="inputSurnames" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="inputSurnames" name="lastName" placeholder="Contreras" required>
          </div>
          <div class="col-md-5 mb-3">
            <label for="inputPhone" class="form-label">Celular</label>
            <input type="number" class="form-control" id="inputPhone" name="phone" placeholder="325566988" required>
          </div>
          <div class="col-md-10 mb-3">
            <label for="inputCity" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="inputCity" name="address" placeholder="kr 19 a" required>
          </div>
          
          <div class="mt-5">
            <button type="submit" class="btn btn-primary" id="registrarBtn">Registrar</button>
          </div>
        </form>
      </div>
      
      <!-- Datos Registrados: Parte Derecha -->
      <div class="col-md-7">
        <h1 class="text-center mb-4">Datos Registrados</h1>
        
        <div class="row">
          <div class="col-md-4">
            <input type="number" class="form-control" id="codigoBuscar" placeholder="Código" required>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-secondary" id="consultarBtn">Buscar</button>
          </div>
        </div>

        <table class="table table-dark">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Celular</th>
              <th>Dirección</th>
            </tr>
          </thead>
          <tbody id="tablaDatos">
            <!-- Los datos se cargarán aquí mediante AJAX -->
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
// Función para cargar todos los registros al inicio
    function cargarDatos() {
      fetch('../backend/consultar.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('tablaDatos').innerHTML = data;
        })
        .catch(error => {
          console.error('Error al cargar los datos:', error);
        });
    }

    // Cargar todos los registros al cargar la página
    window.addEventListener('load', cargarDatos);

// Buscar un registro
    document.getElementById('consultarBtn').addEventListener('click', function() {
    const codigo = document.getElementById('codigoBuscar').value;
      
      if (codigo) {
        // Llamar a consultarBtn.php y pasar el código en la URL
        fetch(`../backend/consultarBtn.php?codigo=${codigo}`)
          .then(response => response.text())
          .then(data => {
            document.getElementById('tablaDatos').innerHTML = data;
          })
          .catch(error => {
            console.error('Error al cargar los datos:', error);
          });
      } else {
        // Si no se ha ingresado un código, mostrar todos los registros
        cargarDatos();
      }
    });

    // Registrar un nuevo registro al hacer click en el botón
    document.getElementById('formulario').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe de manera tradicional

      const formData = new FormData(this); // Recoger los datos del formulario
      const codigo = document.getElementById('inputCodigo').value; // Obtener el código del formulario
      
      // Validar si el código ya existe
      fetch(`../backend/validarCodigo.php?codigo=${codigo}`)
        .then(response => response.json())
        .then(data => {
          if (data.exists) {
            console.log("Ya existe el código");  // Mostrar mensaje si ya existe
            alert("El código ya está registrado.");
          } else {
            // Si el código no existe, proceder con el registro
            fetch('../backend/registrar.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.text())
            .then(data => {
              // Limpiar el formulario
              document.getElementById('formulario').reset();

              // Mostrar los datos registrados en la tabla
              cargarDatos();
            })
            .catch(error => {
              console.error('Error al guardar:', error);
            });
          }
        })
        .catch(error => {
          console.error('Error al verificar el código:', error);
        });
    });


    // Función para eliminar un registro
    function eliminarRegistro(codigo) {
        if (confirm("¿Estás seguro de que quieres eliminar este registro?")) {
            fetch(`../backend/eliminar.php?document=${codigo}`)
                .then(response => response.text())
                .then(data => {
                    // Volver a cargar los datos después de eliminar
                    cargarDatos();
                    alert(data);
                })
                .catch(error => {
                    console.error('Error al eliminar:', error);
                });
        }
    }

    // Función para editar un registro
    function editarRegistro(codigo, nombre, apellidos, telefono, direccion) {
        // Llenar los campos del formulario con los datos del registro
        document.getElementById('inputCodigo').value = codigo;
        document.getElementById('inputName').value = nombre;
        document.getElementById('inputSurnames').value = apellidos;
        document.getElementById('inputPhone').value = telefono;
        document.getElementById('inputCity').value = direccion;

        // Cambiar el texto del botón de registro a "Actualizar"
        document.getElementById('registrarBtn').textContent = "Actualizar";
        
        // Guardar el código de registro en una variable para usarlo al actualizar
        document.getElementById('formulario').dataset.codigo = codigo;
    }

    // Actualizar el registro cuando se hace clic en "Actualizar"
    document.getElementById('formulario').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe de manera tradicional

    const formData = new FormData(this); // Recoger los datos del formulario
    const codigo = this.dataset.codigo;  // Obtener el código del registro a actualizar

    // Si el código existe, es una actualización
    if (codigo) {
      fetch(`../backend/actualizar.php?codigo=${codigo}`, {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        // Limpiar el formulario
        document.getElementById('formulario').reset();
        document.getElementById('registrarBtn').textContent = "Registrar"; // Volver al texto original del botón

        // Volver a cargar los datos
        cargarDatos();
        alert(data);  // Mostrar mensaje de confirmación
      })
      .catch(error => {
        console.error('Error al actualizar:', error);
      });
    } else {
      // Si no hay código, es un registro nuevo
      fetch('../backend/registrar.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        // Limpiar el formulario
        document.getElementById('formulario').reset();
        cargarDatos();
        alert(data);  // Mostrar mensaje de confirmación
      })
      .catch(error => {
        console.error('Error al registrar:', error);
      });
    }
  });
  </script>
</body>
</html>
