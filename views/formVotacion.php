<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Votación</title>
  <style type="text/css">
    .error{
      color: red !important;
    }
  </style>
</head>
<body>
  <h1>Formulario de Votación</h1>
  <form action="#" name="formVotacion" id="formVotacion" method="post">
        <table>
            <tr>
                <td><label for="nombre">Nombre y Apellido:</label></td>
                <td>
                  <input type="text" id="nombreApellido" name="nombreApellido" required>
                  <label for="nombre" generated="true" class="error"></label>
                </td>
            </tr>
            <tr>
                <td><label for="alias">Alias:</label></td>
                <td>
                  <input type="text" id="alias" name="alias" required>
                  <label for="alias" generated="true" class="error"></label>
                </td>
              </tr>
              <tr>
                <td><label for="rut">RUT:</label></td>
                <td>
                  <input type="text" id="rut" name="rut" required>
                  <label for="rut" generated="true" class="error"></label>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td>
                  <input type="email" id="email" name="email" required>
                  <label for="slcRegion" generated="true" class="error"></label>
                </td>
            </tr>
            <tr>
                <td><label for="slcRegion">Región:</label></td>
                <td>
                  <select name="slcRegion" id="slcRegion" required>
                    <option value="">[Seleccione región ...]</option>
                  </select>
                  <label for="slcRegion" generated="true" class="error"></label>
                </td>
            </tr>
            <tr>
                <td><label for="slcComuna">Comuna:</label></td>
                <td>
                  <select name="slcComuna" id="slcComuna" required>
                    <option value="">[Seleccione comuna ...]</option>
                  </select>
                  <label for="slcComuna" generated="true" class="error"></label>
                </td>
              </tr>
            <tr>
                <td><label for="slcCandidato">Candidato:</label></td>
                <td>
                  <select name="slcCandidato" id="slcCandidato" required>
                    <option value="">[Seleccione candidato...]</option>
                  </select>
                  <label for="slcCandidato" generated="true" class="error"></label>
                </td>
            </tr>
            <tr>
                <td><label>¿Cómo se enteró de nosotros?</label></td>
                <td>
                  <div class="radio-group">
                  </div>
                  <label for="optInformacion" generated="true" class="error"></label>
                </td>
            </tr>
        </table>
        
        <button type="submit">Enviar Voto</button>
    </form>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../js/functions.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
</body>
</html>
