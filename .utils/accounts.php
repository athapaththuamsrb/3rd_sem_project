<?php
abstract class User
{
    private $type;
    private $email;

    protected function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getEmail()
    {
        return $this->email;
    }
}

abstract class CentreAdmin extends User
{
    private $place;
    private $district;

    protected function __construct($type, $place, $district)
    {
        parent::__construct($type);
        $this->place = $place;
        $this->district = $district;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function getDistrict()
    {
        return $this->district;
    }
}

class Administrator extends User
{
    public function __construct()
    {
        parent::__construct('admin');
    }
}

class VaccinationAdmin extends CentreAdmin
{
    public function __construct($place, $district)
    {
        parent::__construct('vaccination', $place, $district);
    }
}

class TestingAdmin extends CentreAdmin
{
    public function __construct($place, $district)
    {
        parent::__construct('testing', $place, $district);
    }
}
