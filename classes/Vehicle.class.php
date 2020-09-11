<?php
class Vehicle
{

    // Attributes
    private $_id;
    private $_model;
    private $_builder;
    private $_fuel;
    private $_color;
    private $_kilometer;
    private $_immatriculation;
    private $_technicalcontrol;

    const FUEL_DIESEL = 'diesel';
    const FUEL_ESSENCE = 'essence';
    const FUEL_HYBRIDE = 'hybride';
    const FUEL_ELECTRIQUE = 'electrique';

    const VALID = 'valide';
    const INVALID = 'invalide';

    // Constructor
    public function __construct()
    {
        $this->setModel('model');
        $this->setBuilder('builder');
        $this->setColor('color');
        $this->setFuel(Vehicle::FUEL_ESSENCE);
        $this->setKilometer(0);
        $this->setImmatriculation('A-0');
        $this->setTechnicalControl(Vehicle::INVALID);
    }

    // Getters
    public function getId()
    {
        return $this->_id;
    }

    public function getModel()
    {
        return $this->_model;
    }

    public function getBuilder()
    {
        return $this->_builder;
    }

    public function getFuel()
    {
        return $this->_fuel;
    }

    public function getColor()
    {
        return $this->_color;
    }

    public function getKilometer()
    {
        return $this->_kilometer;
    }

    public function getImmatriculation()
    {
        return $this->_immatriculation;
    }

    public function getTechnicalControl()
    {
        return $this->_technicalcontrol;
    }

    // Setters
    public function setId(int $id)
    {
        $this->_id = $id;
    }

    public function setModel(string $model)
    {
        $this->_model = $model;
    }

    public function setBuilder(string $builder)
    {
        $this->_builder = $builder;
    }

    public function setFuel(string $fuel)
    {
        $this->_fuel = $fuel;
    }

    public function setColor(string $color)
    {
        $this->_color = $color;
    }

    public function setKilometer(int $kilometer)
    {
        $this->_kilometer = $kilometer;
    }

    public function setImmatriculation(string $immatriculation)
    {
        $this->_immatriculation = $immatriculation;
    }

    public function setTechnicalControl(string $control)
    {
        $this->_technicalcontrol = $control;
    }

    // Methods
    public function describe()
    {
        echo '
            <ul style="text-align: center;">
                <li>Modèle du véhicule: ' . $this->getModel() . '</li>
                <li>Immatriculation: ' . $this->getImmatriculation() . '</li>
                <li>Constructeur: ' . $this->getBuilder() . '</li>
                <li>Carburant: ' . $this->getFuel() . '</li>
                <li>Couleur: ' . $this->getColor() . '</li>
                <li>CT: ' . $this->getTechnicalControl() . '</li>
                <li style="color: blue;">km: ' . $this->getKilometer() . '</li>
            </ul>
        ';
    }

    /**
     * compléte les données de l'objet véhicule à partir d'un tableau associatif
     *
     * @param  mixed $tab est un tableau associatif
     * @return void
     */
                    public function hydrate($tab)
    {
        if (isset($tab["id"]) && !empty($tab["id"])) {
            $this->setId($tab["id"]);
        }

        if (isset($tab["model"]) && !empty($tab["model"])) {
            $this->setModel($tab["model"]);
        }

        if (isset($tab["builder"]) && !empty($tab["builder"])) {
            $this->setBuilder($tab["builder"]);
        }

        if (isset($tab["fuel"]) && !empty($tab["fuel"])) {
            $this->setFuel($tab["fuel"]);
        }

        if (isset($tab["color"]) && !empty($tab["color"])) {
            $this->setColor($tab["color"]);
        }

        if (isset($tab["kilometer"]) && !empty($tab["kilometer"])) {
            $this->setKilometer($tab["kilometer"]);
        }

        if (isset($tab["immatriculation"]) && !empty($tab["immatriculation"])) {
            $this->setImmatriculation($tab["immatriculation"]);
        }

        if (isset($tab["technical_control"]) && !empty($tab["technical_control"])) {
            $this->setTechnicalControl($tab["technical_control"]);
        }
    }
    }