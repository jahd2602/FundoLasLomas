<?php

namespace Faker\Plugin;
use Faker\Faker;
/**
 * Name Class
 * 
 * @package faker
 */
class Name
{

	public static $lang;

	public function __construct($lang = NULL) 
	{
		if (!empty($lang))
		{
			self::$_formats =  I18n::get('name_formats', $lang);
			self::$_firstName =  I18n::get('name_firstName', $lang);
			self::$_surname =  I18n::get('name_surname', $lang);
			self::$_prefix =  I18n::get('name_prefix', $lang);
			self::$lang = $lang;
		}
	}

  /**
   * Do nothing on being instanced
   *
   * @return void
   * @author Caius Durling
   */
  
  private static $_formats = array(array('firstName', 'surname'), array('firstName', 'surname'), 
  array('firstName', 'surname'), array('firstName', 'surname'), array('firstName', 'surname'), 
  array('prefix', 'firstName', 'surname'), array('firstName', 'surname', 'suffix'), 
  array('prefix', 'firstName', 'surname', 'suffix'));

  private static $_firstName = array(
      'Adán','Agustín','Alberto','Alejandro','Alfonso','Alfredo',
      'Andrés','Antonio','Armando','Arturo','Benito','Benjamín',
      'Bernardo','Carlos','César','Claudio','Clemente','Cristian',
      'Cristobal','Daniel','David','Diego','Eduardo','Emilio',
      'Enrique','Ernesto','Esteban','Federico','Felipe','Fernando',
      'Francisco','Gabriel','Gerardo','Germán','Gilberto','Gonzalo',
      'Gregorio','Guillermo','Gustavo','Hernán','Homero','Horacio',
      'Hugo','Ignacio','Jacobo','Jaime','Javier','Jerónimo',
      'Jesús','Joaquín','Jorge','Jorge Luis','José (Pepe)','José Eduardo',
      'José Emilio','José Luis','José María','Juan','Juan Carlos','Julio',
      'Julio César','Lorenzo','Lucas','Luis','Luis Miguel','Manuel',
      'Marco Antonio','Marcos','Mariano','Mario','Martín','Mateo',
      'Miguel','Miguel Ángel','Nicolás','Octavio','Óscar','Pablo',
      'Patricio','Pedro','Rafael','Ramiro','Ramón','Raúl',
      'Ricardo','Roberto','Rodrigo','Rubén','Salvador','Samuel',
      'Sancho','Santiago','Sergio','Teodoro','Timoteo','Tomás',
      'Vicente','Víctor','Adela','Adriana','Alejandra','Alicia',
      'Amalia','Ana','Ana Luisa','Ana María','Andrea','Anita',
      'Ángela','Antonia','Barbara','Beatriz','Berta','Blanca',
      'Caridad','Carla','Carlota','Carmen','Carolina','Catalina',
      'Cecilia','Clara','Claudia','Concepción','Cristina','Daniela',
      'Débora','Diana','Dolores','Dorotea','Elena','Elisa',
      'Eloisa','Elsa','Elvira','Emilia','Esperanza','Estela',
      'Ester','Eva','Florencia','Francisca','Gabriela','Gloria',
      'Graciela','Guadalupe','Guillermina','Inés','Irene','Isabel',
      'Josefina','Juana','Julia','Laura','Leonor','Leticia',
      'Lilia','Lorena','Lourdes','Lucia','Luisa','Luz',
      'Magdalena','Manuela','Marcela','Margarita','María','María del Carmen',
      'María Cristina','María Elena','María Eugenia','María José','María Luisa','María Soledad',
      'María Teresa','Mariana','Maricarmen','Marilu','Marisol','Marta',
      'Mercedes','Micaela','Mónica','Natalia','Norma','Olivia',
      'Patricia','Pilar','Ramona','Raquel','Rebeca','Reina',
      'Rocio','Rosa','Rosalia','Rosario','Sara','Silvia',
      'Sofia','Soledad','Sonia','Susana','Teresa','Verónica',
      'Victoria','Virginia','Yolanda',

      'Daniel','David','Gabriel','Benjamín','Samuel','Lucas',
      'Ángel','José','Adrián','Sebastián','Xavier','Juan',
      'Luis','Diego','Óliver','Carlos','Jesús','Alex',
      'Max','Alejandro','Antonio','Miguel','Víctor','Joel',
      'Santiago','Elías','Iván','Óscar','Leonardo','Eduardo',
      'Alan','Nicolás','Jorge','Omar','Paúl','Andrés',
      'Julián','Josué','Román','Fernando','Javier','Abraham',
      'Ricardo','Francisco','César','Mario','Manuel','Édgar',
      'Alexis','Israel','Mateo','Héctor','Sergio','Emiliano',
      'Simón','Rafael','Martín','Marco','Roberto','Pedro',
      'Emanuel','Abel','Rubén','Fabián','Emilio','Joaquín',
      'Marcos','Lorenzo','Armando','Adán','Raúl','Julio',
      'Enrique','Gerardo','Pablo','Jaime','Saúl','Esteban',
      'Gustavo','Rodrigo','Arturo','Mauricio','Orlando','Hugo',
      'Salvador','Alfredo','Maximiliano','Ramón','Ernesto','Tobías',
      'Abram','Noé','Guillermo','Ezequiel','Lucián','Alonzo',
      'Felipe','Matías','Tomás','Jairo','Isabella','Olivia',
      'Alexis','Sofía','Victoria','Amelia','Alexa','Julia',
      'Camila','Alexandra','Maya','Andrea','Ariana','María',
      'Eva','Angelina','Valeria','Natalia','Isabel','Sara',
      'Liliana','Adriana','Juliana','Gabriela','Daniela','Valentina',
      'Lila','Vivian','Nora','Ángela','Elena','Clara',
      'Eliana','Alana','Miranda','Amanda','Diana','Ana',
      'Penélope','Aurora','Alexandría','Lola','Alicia','Amaya',
      'Alexia','Jazmín','Mariana','Alina','Lucía','Fátima',
      'Ximena','Laura','Cecilia','Alejandra','Esmeralda','Verónica',
      'Daniella','Miriam','Carmen','Iris','Guadalupe','Selena',
      'Fernanda','Angélica','Emilia','Lía','Tatiana','Mónica',
      'Carolina','Jimena','Dulce','Talía','Estrella','Brenda',
      'Lilian','Paola','Serena','Celeste','Viviana','Elisa',
      'Melina','Gloria','Claudia','Sandra','Marisol','Asia',
      'Ada','Rosa','Isabela','Regina','Elsa','Perla',
      'Raquel','Virginia','Patricia','Linda','Marina','Leila',
      'América','Mercedes',
  );

  private static $_surname = array(
      'Macías','Madera','Madrid','Madrigal','Maestas','Magaña',
      'Malave','Maldonado','Manzanares','Mares','Marín','Márquez',
      'Marrero','Marroquín','Martínez','Mascareñas','Mata','Mateo',
      'Matías','Matos','Maya','Mayorga','Medina','Medrano',
      'Mejía','Meléndez','Melgar','Mena','Menchaca','Méndez',
      'Mendoza','Menéndez','Meraz','Mercado','Merino','Mesa',
      'Meza','Miramontes','Miranda','Mireles','Mojica','Molina',
      'Mondragón','Monroy','Montalvo','Montañez','Montaño','Montemayor',
      'Montenegro','Montero','Montes','Montez','Montoya','Mora',
      'Morales','Moreno','Mota','Moya','Munguía','Muñiz',
      'Muñoz','Murillo','Muro','Nájera','Naranjo','Narváez',
      'Nava','Navarrete','Navarro','Nazario','Negrete','Negrón',
      'Nevárez','Nieto','Nieves','Niño','Noriega','Núñez',
      'Ocampo','Ocasio','Ochoa','Ojeda','Olivares','Olivárez',
      'Olivas','Olivera','Olivo','Olmos','Olvera','Ontiveros',
      'Oquendo','Ordóñez','Orellana','Ornelas','Orosco','Orozco',
      'Orta','Ortega','Ortiz','Osorio','Otero','Ozuna',
      'Pabón','Pacheco','Padilla','Padrón','Páez','Pagan',
      'Palacios','Palomino','Palomo','Pantoja','Paredes','Parra',
      'Partida','Patiño','Paz','Pedraza','Pedroza','Pelayo',
      'Peña','Perales','Peralta','Perea','Peres','Pérez',
      'Pichardo','Piña','Pineda','Pizarro','Polanco','Ponce',
      'Porras','Portillo','Posada','Prado','Preciado','Prieto',
      'Puente','Puga','Pulido','Quesada','Quezada','Quiñones',
      'Quiñónez','Quintana','Quintanilla','Quintero','Quiroz','Rael',
      'Ramírez','Ramón','Ramos','Rangel','Rascón','Raya',
      'Razo','Regalado','Rendón','Rentería','Reséndez','Reyes',
      'Reyna','Reynoso','Rico','Rincón','Riojas','Ríos',
      'Rivas','Rivera','Rivero','Robledo','Robles','Rocha',
      'Rodarte','Rodrígez','Rodríguez','Rodríquez','Rojas','Rojo',
      'Roldán','Rolón','Romero','Romo','Roque','Rosado',
      'Rosales','Rosario','Rosas','Roybal','Rubio','Ruelas',
      'Ruiz','Ruvalcaba','Saavedra','Sáenz','Saiz','Salas',
      'Salazar','Salcedo','Salcido','Saldaña','Saldivar','Salgado',
      'Salinas','Samaniego','Sanabria','Sanches','Sánchez','Sandoval',
      'Santacruz','Santana','Santiago','Santillán','Sarabia','Sauceda',
      'Saucedo','Sedillo','Segovia','Segura','Sepúlveda','Serna',
      'Serrano','Serrato','Sevilla','Sierra','Sisneros','Solano',
      'Solís','Soliz','Solorio','Solorzano','Soria','Sosa',
      'Sotelo','Soto','Suárez','Tafoya','Tamayo','Tamez',
      'Tapia','Tejada','Tejeda','Téllez','Tello','Terán',
      'Terrazas','Tijerina','Tirado','Toledo','Toro','Torres',
      'Tórrez','Tovar','Trejo','Treviño','Trujillo','Ulibarri',
      'Ulloa','Urbina','Ureña','Urías','Uribe','Urrutia',
      'Vaca','Valadez','Valdés','Valdez','Valdivia','Valencia',
      'Valentín','Valenzuela','Valladares','Valle','Vallejo','Valles',
      'Valverde','Vanegas','Varela','Vargas','Vásquez','Vázquez',
      'Vega','Vela','Velasco','Velásquez','Velázquez','Vélez',
      'Véliz','Venegas','Vera','Verdugo','Verduzco','Vergara',
      'Viera','Vigil','Villa','Villagómez','Villalobos','Villalpando',
      'Villanueva','Villareal','Villarreal','Villaseñor','Villegas','Yáñez',
      'Ybarra','Zambrano','Zamora','Zamudio','Zapata','Zaragoza',
      'Zarate','Zavala','Zayas','Zelaya','Zepeda','Zúñiga',
      'Abeyta','Abrego','Abreu','Acevedo','Acosta','Acuña',
      'Adame','Adorno','Agosto','Aguayo','Águilar','Aguilera',
      'Aguirre','Alanis','Alaniz','Alarcón','Alba','Alcala',
      'Alcántar','Alcaraz','Alejandro','Alemán','Alfaro','Alicea',
      'Almanza','Almaraz','Almonte','Alonso','Alonzo','Altamirano',
      'Alva','Alvarado','Álvarez','Amador','Amaya','Anaya',
      'Anguiano','Angulo','Aparicio','Apodaca','Aponte','Aragón',
      'Araña','Aranda','Arce','Archuleta','Arellano','Arenas',
      'Arevalo','Arguello','Arias','Armas','Armendáriz','Armenta',
      'Armijo','Arredondo','Arreola','Arriaga','Arroyo','Arteaga',
      'Atencio','Ávalos','Ávila','Avilés','Ayala','Baca',
      'Badillo','Báez','Baeza','Bahena','Balderas','Ballesteros',
      'Banda','Bañuelos','Barajas','Barela','Barragán','Barraza',
      'Barrera','Barreto','Barrientos','Barrios','Batista','Becerra',
      'Beltrán','Benavides','Benavídez','Benítez','Bermúdez','Bernal',
      'Berríos','Bétancourt','Blanco','Bonilla','Borrego','Botello',
      'Bravo','Briones','Briseño','Brito','Bueno','Burgos',
      'Bustamante','Bustos','Caballero','Cabán','Cabrera','Cadena',
      'Caldera','Calderón','Calvillo','Camacho','Camarillo','Campos',
      'Canales','Candelaria','Cano','Cantú','Caraballo','Carbajal',
      'Cardenas','Cardona','Carmona','Carranza','Carrasco','Carrasquillo',
      'Carreón','Carrera','Carrero','Carrillo','Carrion','Carvajal',
      'Casanova','Casares','Casárez','Casas','Casillas','Castañeda',
      'Castellanos','Castillo','Castro','Cavazos','Cazares','Ceballos',
      'Cedillo','Ceja','Centeno','Cepeda','Cerda','Cervantes',
      'Cervántez','Chacón','Chapa','Chavarría','Chávez','Cintrón',
      'Cisneros','Collado','Collazo','Colón','Colunga','Concepción',
      'Contreras','Cordero','Córdova','Cornejo','Corona','Coronado',
      'Corral','Corrales','Correa','Cortés','Cortez','Cotto',
      'Covarrubias','Crespo','Cruz','Cuellar','Curiel','Dávila',
      'de Anda','de Jesús','Delacrúz','Delafuente','Delagarza','Delao',
      'Delapaz','Delarosa','Delatorre','Deleón','Delgadillo','Delgado',
      'Delrío','Delvalle','Díaz','Domínguez','Domínquez','Duarte',
      'Dueñas','Duran','Echevarría','Elizondo','Enríquez','Escalante',
      'Escamilla','Escobar','Escobedo','Esparza','Espinal','Espino',
      'Espinosa','Espinoza','Esquibel','Esquivel','Estévez','Estrada',
      'Fajardo','Farías','Feliciano','Fernández','Ferrer','Fierro',
      'Figueroa','Flores','Flórez','Fonseca','Franco','Frías',
      'Fuentes','Gaitán','Galarza','Galindo','Gallardo','Gallegos',
      'Galván','Gálvez','Gamboa','Gamez','Gaona','Garay',
      'García','Garibay','Garica','Garrido','Garza','Gastélum',
      'Gaytán','Gil','Girón','Godínez','Godoy','Gómez',
      'Gonzales','González','Gracia','Granado','Granados','Griego',
      'Grijalva','Guajardo','Guardado','Guerra','Guerrero','Guevara',
      'Guillen','Gurule','Gutiérrez','Guzmán','Haro','Henríquez',
      'Heredia','Hernádez','Hernandes','Hernández','Herrera','Hidalgo',
      'Hinojosa','Holguín','Huerta','Hurtado','Ibarra','Iglesias',
      'Irizarry','Jaime','Jaimes','Jáquez','Jaramillo','Jasso',
      'Jiménez','Jimínez','Juárez','Jurado','Laboy','Lara',
      'Laureano','Leal','Lebrón','Ledesma','Leiva','Lemus',
      'León','Lerma','Leyva','Limón','Linares','Lira',
      'Llamas','Loera','Lomeli','Longoria','López','Lovato',
      'Loya','Lozada','Lozano','Lucero','Lucio','Luevano',
      'Lugo','Luján','Luna');

  private static $_prefix = array('Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.');

  private static $_suffix = array('Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'MD', 'DDS', 'PhD', 'DVM');

  public function name ()
  {
    $a = Utils::getInstance()->random(self::$_formats);
    
    foreach ($a as $method) {
      $b[] = $this->$method();
    }
    
    $result = join($b, " ");
    
    return $result;
  }

  public function firstName ()
  {
    return Utils::getInstance()->random(self::$_firstName);
  }

  public function surname ()
  {
    return Utils::getInstance()->random(self::$_surname).' '.Utils::getInstance()->random(self::$_surname);
  }

  public function prefix ()
  {
    return Utils::getInstance()->random(self::$_prefix);
  }

  public function suffix ()
  {
    return Utils::getInstance()->random(self::$_suffix);
  }
  
  function __set ($property, $value)
  {
    throw new Exception('Unknow property "' . $property . '"');
  }
}

?>