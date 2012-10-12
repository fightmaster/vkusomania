<?php

namespace Dishes;

class Dish {

    private $name;
    private $date;
    private $category;
    private $portion;
    private $cost;
    private $id;
    private $num_portion;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCategory($cat)
    {
        $this->category = $cat;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setPortion($portion)
    {
        $this->portion = $portion;
    }

    public function getPortion()
    {
        return $this->portion;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNumPortions($num)
    {
        $this->num_portion = $num;
    }

    public function getNumPortions()
    {
        return $this->num_portion;
    }

}