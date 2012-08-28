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

	function setName($name){
			$this->name = $name;
	}

	function getName(){
			return $this->name;
	}
	
	function setCategory($cat){
			$this->category = $cat;
	}

	function getCategory(){
			return $this->category;
	}
	
	function setDate($date){
			$this->date = $date;
	}

	function getDate(){
			return $this->date;
	}
	
	function setPortion($portion){
			$this->portion = $portion;
	}

	function getPortion(){
			return $this->portion;
	}	

	function setCost($cost){
			$this->cost = $cost;
	}

	function getCost(){
			return $this->cost;
	}
	
	function setID($id){
			$this->id = $id;
	}

	function getID(){
			return $this->id;
	}
	
	function setNumPortions($num){
			$this->num_portion = $num;
	}

	function getNumPortions(){
			return $this->num_portion;
	}
}
?>