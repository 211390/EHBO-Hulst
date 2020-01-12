<?php
/**
 * Created by PhpStorm.
 * User: toost_000
 * Date: 4-1-2020
 * Time: 14:50
 */

class MenuProduct{

    /** @var int */
    private $id;

    /** @var int */
    private $categoryId;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var float */
    private $price;

    /* ----------------- Public Functions --------------- */

    public function __construct($id, $categoryId, $name, $description, $price) {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /* ----------------- Public GETs --------------- */

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return number_format($this->price, 2);
    }


    /**
     * @return string|null
     */
    public function getCategoryName(){
        return MenuCategoryManager::getNameStatic($this->categoryId);
    }


    /* ----------------- Public SETs --------------- */

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }



}