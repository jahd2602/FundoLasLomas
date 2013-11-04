<?php

namespace Faker\Plugin;
use Faker\Faker;

/**
 * Address Class
 *
 * @package faker
 */
class Address
{

    public static $lang;

    public function __construct($lang = NULL)
    {
        if (!empty($lang)) {
            self::$lang = $lang;
        }
    }

    /**
     * Do nothing on being created
     *
     * @return void
     * @author Caius Durling
     */

    private static $_us_states = array('Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado',
        'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas',
        'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi',
        'Missouri', 'Montana', 'Nebraska', 'Nevada', 'NewHampshire', 'NewJersey', 'NewMexico', 'NewYork',
        'NorthCarolina', 'NorthDakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'RhodeIsland', 'SouthCarolina',
        'SouthDakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'WestVirginia', 'Wisconsin',
        'Wyoming');

    private static $_us_states_abbr = array('AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL',
        'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO',
        'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC',
        'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY', 'AE', 'AA', 'AP');

    private static $_us_zipcode_formats = array('#####', '#####-####');

    private static $_street_suffix = array('Alley', 'Avenue', 'Branch', 'Bridge', 'Brook', 'Brooks', 'Burg',
        'Burgs', 'Bypass', 'Camp', 'Canyon', 'Cape', 'Causeway', 'Center', 'Centers', 'Circle', 'Circles', 'Cliff',
        'Cliffs', 'Club', 'Common', 'Corner', 'Corners', 'Course', 'Court', 'Courts', 'Cove', 'Coves', 'Creek',
        'Crescent', 'Crest', 'Crossing', 'Crossroad', 'Curve', 'Dale', 'Dam', 'Divide', 'Drive', 'Drive', 'Drives',
        'Estate', 'Estates', 'Expressway', 'Extension', 'Extensions', 'Fall', 'Falls', 'Ferry', 'Field', 'Fields',
        'Flat', 'Flats', 'Ford', 'Fords', 'Forest', 'Forge', 'Forges', 'Fork', 'Forks', 'Fort', 'Freeway', 'Garden',
        'Gardens', 'Gateway', 'Glen', 'Glens', 'Green', 'Greens', 'Grove', 'Groves', 'Harbor', 'Harbors', 'Haven',
        'Heights', 'Highway', 'Hill', 'Hills', 'Hollow', 'Inlet', 'Inlet', 'Island', 'Island', 'Islands', 'Islands',
        'Isle', 'Isle', 'Junction', 'Junctions', 'Key', 'Keys', 'Knoll', 'Knolls', 'Lake', 'Lakes', 'Land', 'Landing',
        'Lane', 'Light', 'Lights', 'Loaf', 'Lock', 'Locks', 'Locks', 'Lodge', 'Lodge', 'Loop', 'Mall', 'Manor',
        'Manors', 'Meadow', 'Meadows', 'Mews', 'Mill', 'Mills', 'Mission', 'Mission', 'Motorway', 'Mount', 'Mountain',
        'Mountain', 'Mountains', 'Mountains', 'Neck', 'Orchard', 'Oval', 'Overpass', 'Park', 'Parks', 'Parkway',
        'Parkways', 'Pass', 'Passage', 'Path', 'Pike', 'Pine', 'Pines', 'Place', 'Plain', 'Plains', 'Plains', 'Plaza',
        'Plaza', 'Point', 'Points', 'Port', 'Port', 'Ports', 'Ports', 'Prairie', 'Prairie', 'Radial', 'Ramp', 'Ranch',
        'Rapid', 'Rapids', 'Rest', 'Ridge', 'Ridges', 'River', 'Road', 'Road', 'Roads', 'Roads', 'Route', 'Row', 'Rue',
        'Run', 'Shoal', 'Shoals', 'Shore', 'Shores', 'Skyway', 'Spring', 'Springs', 'Springs', 'Spur', 'Spurs',
        'Square', 'Square', 'Squares', 'Squares', 'Station', 'Station', 'Stravenue', 'Stravenue', 'Stream', 'Stream',
        'Street', 'Street', 'Streets', 'Summit', 'Summit', 'Terrace', 'Throughway', 'Trace', 'Track', 'Trafficway',
        'Trail', 'Trail', 'Tunnel', 'Tunnel', 'Turnpike', 'Turnpike', 'Underpass', 'Union', 'Unions', 'Valley',
        'Valleys', 'Via', 'Viaduct', 'View', 'Views', 'Village', 'Village', 'Villages', 'Ville', 'Vista', 'Vista',
        'Walk', 'Walks', 'Wall', 'Way', 'Ways', 'Well', 'Wells');

    private static $_uk_counties = array('Avon', 'Bedfordshire', 'Berkshire', 'Borders', 'Buckinghamshire',
        'Cambridgeshire', 'Central', 'Cheshire', 'Cleveland', 'Clwyd', 'Cornwall', 'CountyAntrim', 'CountyArmagh',
        'CountyDown', 'CountyFermanagh', 'CountyLondonderry', 'CountyTyrone', 'Cumbria', 'Derbyshire', 'Devon',
        'Dorset', 'DumfriesandGalloway', 'Durham', 'Dyfed', 'EastSussex', 'Essex', 'Fife', 'Gloucestershire',
        'Grampian', 'GreaterManchester', 'Gwent', 'GwyneddCounty', 'Hampshire', 'Herefordshire', 'Hertfordshire',
        'HighlandsandIslands', 'Humberside', 'IsleofWight', 'Kent', 'Lancashire', 'Leicestershire', 'Lincolnshire',
        'Lothian', 'Merseyside', 'MidGlamorgan', 'Norfolk', 'NorthYorkshire', 'Northamptonshire', 'Northumberland',
        'Nottinghamshire', 'Oxfordshire', 'Powys', 'Rutland', 'Shropshire', 'Somerset', 'SouthGlamorgan',
        'SouthYorkshire', 'Staffordshire', 'Strathclyde', 'Suffolk', 'Surrey', 'Tayside', 'TyneandWear',
        'Warwickshire', 'WestGlamorgan', 'WestMidlands', 'WestSussex', 'WestYorkshire', 'Wiltshire', 'Worcestershire');

    private static $_uk_countries = array('England', 'Scotland', 'Wales', 'Northern Ireland');

    private static $_uk_postcode_formats = array('??## #??', '??# #??');

    private static $_street_name_formats = array('firstName', 'surname');

    private static $_street_list = array(
        array(
            'type' => 'Jr.',
            'name' => 'Sargento Lores',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Moyobamba',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Guepi',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Manco Capac',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Los Andes',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Jose Galvez',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Los Andes',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Miguel Grau',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Oxapampa',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Tupac Amaru',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Oriental',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Mateo Pumacahua',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Callao',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Victoria Vasquez',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Sucre',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Francisco Pizarro',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Tarapoto',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Leticia',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'San Pedro',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Jose Olaya',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Arica',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Agusto B. Leguia',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'San Pedro',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Oscar R. Benavides',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Simon Bolivar',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Comandante Chirinos',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Paraiso',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Lima',
        ),
        array(
            'type' => 'Jr.',
            'name' => '9 de Abril',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Progreso',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Manco Inca',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Romain castilla',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Cuzco',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Sinchi Roca',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Ricaldo Palma',
        ),
        array(
            'type' => 'Jr.',
            'name' => '6 de Septiembre',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Luis Flores Sanchez',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Huallaga',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'Miraflores',
        ),
        array(
            'type' => 'Jr.',
            'name' => 'San Martin',
        ),
        array(
            'type' => 'Jr.',
            'name' => '25 de Julio',
        ),
        array(
            'type' => 'Av.',
            'name' => 'Peru',
        ),
        array(
            'type' => 'Av.',
            'name' => 'Circunvalación',
        ),
        array(
            'type' => 'Av.',
            'name' => 'Alfonso Ugarte',
        ),
        array(
            'type' => 'Av.',
            'name' => '1 de Abril',
        ),
        array(
            'type' => 'Pj.',
            'name' => 'Santa Rosa',
        ),
        array(
            'type' => 'Pj.',
            'name' => 'Miraflores',
        ),
        array(
            'type' => 'Pj.',
            'name' => '15 de Agosto',
        ),

    );

    private static $_street_types = array(
        'Pj.', 'Av.', 'Jr.'
    );

    public function streetArray()
    {

        return Utils::getInstance()->random(self::$_street_list);
    }

    public function streetFull()
    {
        $street = $this->streetArray();
        return $street['type'].' '.$street['name'].' '.$this->streetNumber();
    }

    public function streetType()
    {

        return Utils::getInstance()->random(self::$_street_types);
    }

    public function streetName()
    {
        $street = Utils::getInstance()->random(self::$_street_list);
        return $street['name'];
    }

    public function streetNumber()
    {

        return mt_rand(1, 500);
    }

    public function streetSuffix()
    {
        return Utils::getInstance()->random(self::$_street_suffix);
    }


    public function streetAddress()
    {
        return Utils::getInstance()->numerify(implode(" ", array('#####', self::streetName())));
    }

    public function abodeAddress($include_street = false)
    {
        if ($include_street) {
            $str[] = '#####';
        }
        $formats = array('Apt. ###', 'Suite ###');
        $str[] = Utils::getInstance()->random($formats);
        if ($include_street) {
            $str[] = self::streetName();
        }
        return Utils::getInstance()->numerify(implode(" ", $str));
    }

    ######### UK Only ###########


    public function ukCounty()
    {
        return Utils::getInstance()->random(self::$_uk_counties);
    }

    public function ukCountry()
    {
        return Utils::getInstance()->random(self::$_uk_countries);
    }

    public function postCode()
    {
        $a = Utils::getInstance()->random(self::$_uk_postcode_formats);
        $result = Utils::getInstance()->bothify($a);
        return strtoupper($result);
    }

    ###### American Only ########


    public function usState()
    {
        return Utils::getInstance()->random(self::$_us_states);
    }

    public function usStateAbbr()
    {
        return Utils::getInstance()->random(self::$_us_states_abbr);
    }

    public function zipCode()
    {
        $a = Utils::getInstance()->random(self::$_us_zipcode_formats);
        $result = Utils::getInstance()->numerify($a);
        return $result;
    }

    function __set($property, $value)
    {
        throw new Exception('Unknow property "' . $property . '"');
    }
}