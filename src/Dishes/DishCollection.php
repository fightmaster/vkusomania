<?php

namespace Dishes;

class DishCollection
{
    
    private $collection = array();
    
    public function add(Dish $dish)
    {
        $this->collection[] = $dish;
    }
    
    public function clear()
    {
        $this->collection = array();
    }
    
    public function getDishes()
    {
        return $this->collection;
    }
    
    public function getCollectionCount()
    {
        return count($this->collection);
    }
}
