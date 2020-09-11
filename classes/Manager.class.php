<?php
class Manager
{

    // attributes
    private $_db;

    const TABLE_NAME = 'vehicles';

    // constructor
    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    // setters
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }


    public function createTable()
    {
        $this
            ->_db
            ->query(
                "DROP TABLE IF EXISTS `vehicles`;
        CREATE TABLE IF NOT EXISTS `vehicles` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `model` varchar(80) NOT NULL,
            `builder` varchar(80) NOT NULL,
            `fuel` varchar(80) NOT NULL,
            `color` varchar(80) NOT NULL,
            `kilometer` int(11) NOT NULL,
            `immatriculation` varchar(16) NOT NULL,
            `technical_control` varchar(32) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `immatriculation` (`immatriculation`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
            );
    }

//si la table existe
    public function existTable()
    {
        return $this
            ->_db
            ->query('DESCRIBE ' . Manager::TABLE_NAME);
    }

    public function readTable()
    {
        if ($this->existTable() == true) {
            $result = $this
                ->_db
                ->prepare("SELECT * FROM " . Manager::TABLE_NAME);

            $result->execute();

            $fetch = $result->fetchall();

            echo "<table style='border: 2px solid black; margin: auto;'>
        
                        <tr>
                            <td style='border: 1px solid black;'>ID</td>&nbsp
                            <td style='border: 1px solid black;'>MODELE</td>&nbsp
                            <td style='border: 1px solid black;'>CONSTRUCTEUR</td>&nbsp
                            <td style='border: 1px solid black;'>CARBURANT</td>&nbsp
                            <td style='border: 1px solid black;'>COULEUR</td>&nbsp
                            <td style='border: 1px solid black;'>KILOMETRAGE</td>&nbsp
                            <td style='border: 1px solid black;'>IMMATRICULATION</td>&nbsp
                            <td style='border: 1px solid black;'>CONTROLE TECHNIQUE</td>&nbsp
                        </tr>";

            foreach ($fetch as $key) {
                echo '<tr>
                            <td style="text-align: center;">' . $key["id"] . '</td>
                            <td style="text-align: center;">' . $key["model"] . '</td>
                            <td style="text-align: center;">' . $key["builder"] . '</td>
                            <td style="text-align: center;">' . $key["fuel"] . '</td>
                            <td style="text-align: center;">' . $key["color"] . '</td>
                            <td style="text-align: center;">' . $key["kilometer"] . '</td>
                            <td style="text-align: center;">' . $key["immatriculation"] . '</td>
                            <td style="text-align: center;">' . $key["technical_control"] . '</td>
                    </tr>';
            }
            echo '</table>';
        } else echo '<p style="text-align: center;">La table "' . Manager::TABLE_NAME . '" n\'existe pas</p>';
    }

    public function truncateTable()
    {
        $this
            ->_db
            ->query("TRUNCATE TABLE " . Manager::TABLE_NAME);
    }

    public function dropTable()
    {
        $this
            ->_db
            ->query("DROP TABLE " . Manager::TABLE_NAME);
    }


        public function create(Vehicle $vehicle)
    {
        $model = $vehicle->getModel();
        $builder = $vehicle->getBuilder();
        $fuel = $vehicle->getFuel();
        $color = $vehicle->getColor();
        $kilometer = $vehicle->getKilometer();
        $imatriculation = $vehicle->getImmatriculation();
        $technical_control = $vehicle->getTechnicalControl();

        $sql = $this
            ->_db
            ->prepare(
                "INSERT INTO vehicles(model,builder,fuel,color,kilometer,immatriculation,technical_control) VALUES (:param1, :param2, :param3, :param4, :param5, :param6, :param7) "
            );

        $sql->bindvalue(':param1', $model, PDO::PARAM_STR);
        $sql->bindvalue(':param2', $builder, PDO::PARAM_STR);
        $sql->bindvalue(':param3', $fuel, PDO::PARAM_STR);
        $sql->bindvalue(':param4', $color, PDO::PARAM_STR);
        $sql->bindvalue(':param5', $kilometer, PDO::PARAM_STR);
        $sql->bindvalue(':param6', $imatriculation, PDO::PARAM_STR);
        $sql->bindvalue(':param7', $technical_control, PDO::PARAM_STR);

        $sql->execute();
    }


        public function selectFirst()
    {
        $sql = $this
            ->_db
            ->prepare('SELECT * FROM ' . Manager::TABLE_NAME . ' LIMIT 1');

        $sql->execute();

        $result = $sql->fetch();

        $vehicle = new Vehicle();

        $vehicle->hydrate($result);

        return $vehicle;
    }


        public function update(Vehicle $vehicle)
    {
        $id = $vehicle->getId();
        $model = $vehicle->getModel();
        $builder = $vehicle->getBuilder();
        $fuel = $vehicle->getFuel();
        $color = $vehicle->getColor();
        $kilometer = $vehicle->getKilometer();
        $imatriculation = $vehicle->getImmatriculation();
        $technical_control = $vehicle->getTechnicalControl();

        $sql = $this
            ->_db
            ->prepare(
                "UPDATE vehicles SET model = :param1 , builder = :param2 , fuel = :param3 , color = :param4 , kilometer = :param5 , immatriculation = :param6 , technical_control = :param7 WHERE id = :param8 "
            );

        $sql->bindvalue(':param1', $model, PDO::PARAM_STR);
        $sql->bindvalue(':param2', $builder, PDO::PARAM_STR);
        $sql->bindvalue(':param3', $fuel, PDO::PARAM_STR);
        $sql->bindvalue(':param4', $color, PDO::PARAM_STR);
        $sql->bindvalue(':param5', $kilometer, PDO::PARAM_STR);
        $sql->bindvalue(':param6', $imatriculation, PDO::PARAM_STR);
        $sql->bindvalue(':param7', $technical_control, PDO::PARAM_STR);
        $sql->bindvalue(':param8', $id, PDO::PARAM_STR);

        $sql->execute();
    }

    public function delete(Vehicle $vehicle)
    {
    $id = $vehicle->getId();

    $sql = $this
            ->_db
            ->prepare("DELETE FROM vehicles  WHERE id = :param1 ");

        $sql->bindvalue(':param1', $id, PDO::PARAM_STR);

        $sql->execute();
    }

        public function listOfVehiclesByBuilder(string $builder = 'Renault')
    {
        $sql = $this
            ->_db
            ->prepare("SELECT * FROM vehicles WHERE builder = :param1 ORDER BY model ASC");

        $sql->bindvalue(':param1', $builder, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchall();

        $results = [];

        foreach ($result as $key) {
            $vehicle = new Vehicle();

            $vehicle->hydrate($key);

            array_push($results, $vehicle);
        }

        return $results;
    }

    public function listOfInvalidVehicles()
    {
        $sql = $this
            ->_db
            ->prepare("SELECT * FROM vehicles WHERE technical_control = :param1 ORDER BY model ASC");

        $sql->bindvalue(':param1', Vehicle::INVALID, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchall();

        $results = [];

        foreach ($result as $key) {
            $vehicle = new Vehicle();

            $vehicle->hydrate($key);

            array_push($results, $vehicle);
        }

        return $results;
    }

    public function listOfGasolineVehicles()
    {
        $sql = $this
            ->_db
            ->prepare("SELECT * FROM vehicles WHERE fuel = :param1 ORDER BY model ASC");

        $sql->bindvalue(':param1', Vehicle::FUEL_ESSENCE, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchall();

        $results = [];

        foreach ($result as $key) 
        {
            $vehicle = new Vehicle();

            $vehicle->hydrate($key);

            array_push($results, $vehicle);
        }

        return $results;
    }


    public function listOfVehiclesByMoreKm(int $kilometermeter = 0)
    {
        $sql = $this
            ->_db
            ->prepare("SELECT * FROM vehicles WHERE kilometer > :param1 ORDER BY kilometer ASC");

        $sql->bindvalue(':param1', $kilometermeter, PDO::PARAM_STR);

        $sql->execute();

        $result = $sql->fetchall();

        $results = [];

        foreach ($result as $key) {
            $vehicle = new Vehicle();

            $vehicle->hydrate($key);

            array_push($results, $vehicle);
        }

        return $results;
    }
}
