<?php

/**
 * Created by PhpStorm.
 * User: toost_000
 * Date: 4-1-2020
 * Time: 14:09
 */

class MenuCategory {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $ranking;


    /**
     * @var bool
     */
    private $empty = true;


    function __construct($id, $name, $ranking){
        $this->id = $id;
        $this->name = $name;
        $this->ranking = $ranking;
    }

    /* Public SET stuff */

    /**
     * @param $id int
     */
    public function setId($id){
        $this->id = $id;
    }


    /**
     * @param $name string
     */
    public function setName($name){
        $this->name = $name;
    }


    /**
     * @param $bool bool
     */
    public function setEmpty($bool){
        $this->empty = $bool;
    }


    /**
     * @param $ranking int
     */
    public function setRanking($ranking){
        $this->ranking = $ranking;
    }

    /* Public GET stuff */

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getRanking(){
        return $this->ranking;
    }

    /**
     * @return bool
     */
    public function isEmpty(){
        return $this->empty;
    }

}
