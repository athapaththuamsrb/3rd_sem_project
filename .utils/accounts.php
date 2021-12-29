<?php
abstract class User
{
    private $type;
    private $email;

    protected function __construct($type, $email)
    {
        $this->type = $type;
        $this->email = $email;
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

    protected function __construct($type, $place, $district, $email)
    {
        parent::__construct($type, $email);
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
    public function __construct($email)
    {
        parent::__construct('admin', $email);
    }
}

class VaccinationAdmin extends CentreAdmin
{
    public function __construct($place, $district, $email)
    {
        parent::__construct('vaccination', $place, $district, $email);
    }
}

class TestingAdmin extends CentreAdmin
{
    public function __construct($place, $district, $email)
    {
        parent::__construct('testing', $place, $district, $email);
    }
}
