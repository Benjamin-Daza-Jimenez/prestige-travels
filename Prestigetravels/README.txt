Benjamín Daza Jimenez 202173574-7
Sebastián Von Kunowsky Lepe 202173560-7

1. El buscador puede buscar por nombre de hotel y paquete, ciudad del hotel y paquete y la fecha
de salida y vuelta del paquete. Se asume que el hotel no tiene fechas, por lo que no aparecerá en la 
busqueda de fechas
2. El buscador solo funciona con las palabras completas y bien escritas, es decir no encontrará nada si 
el nombre del hotel esta incompleto o mal escrito.
3. Se agregó un tipo admin a los usuarios con el fin de ingresar la información de forma más eficaz.
4. Se debe iniciar sesión para mostrar los botones de agregar al carrito y favorito, además, de realizar una reseña.
5. las imagenes deben ser cargadas en la carpeta "Recursos", esta debe estar ubicada dentro de la carpatea PHP.
6. Existe la posibilidad de un 10% que aparezca el cupón en la página principal, este puede ser rechazado o aceptado. Si es aceptado, a la hora de comprar, este descuento se borra.


Documentación
Requiere XAMPP
En header.php se encuentra la conexion a la BD (mysql)
// CONEXION A LA BD
$servidor = "localhost";
$baseDeDatos = "Prestigetravels";
$usuario = "root";
$contrasenia = "";
