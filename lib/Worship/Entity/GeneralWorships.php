<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Ministrants entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Worship_GeneralWorships")
 */
class Worship_Entity_GeneralWorships extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $gwid;
	
	/**
     * The following are annotations which define the cid field.
     *
     * @ORM\Column(type="integer")
     */
    private $cid;
    
    /**
     * The following are annotations which define the weektime field.
     *
     * @ORM\Column(type="integer")
     */
    private $weekday;

    /**
     * The following are annotations which define the gwtime field.
     *
     * @ORM\Column(type="time")
     */
    private $gwtime;
	
	 /**
     * The following are annotations which define the gwtitle field.
     *
     * @ORM\Column(type="text")
     */
    private $gwtitle;
    
    /**
     * The following are annotations which define the weektime field.
     *
     * @ORM\Column(type="integer")
     */
    private $active;


    public function getGwid()
    {
        return $this->gwid;
    }
    
     public function getcid()
    {
        return $this->cid;
    }
    
    public function setcid($cid)
    {
        $this->cid = ($cid);
    }
    
    public function getWeekday()
    {
        return $this->weekday;
    }
    
    public function setWeekday($weekday)
    {
        $this->weekday = ($weekday);
    }
    
    public function getGwtimeFormatted()
    {
        return $this->gwtime->format('G:i');
    }
    
    public function setGwtime($gwtime)
    {
        $this->gwtime = new \DateTime($gwtime);
    }
    
    public function getGwtime()
    {
        return $this->gwtime;
    }
    
    public function setGwtitle($gwtitle)
    {
        $this->gwtitle = ($gwtitle);
    }
    
	public function getGwtitle()
    {
        return $this->gwtitle;
    }
    
    public function setActive($active)
    {
        $this->active = ($active);
    }
    
	public function getActive()
    {
        return $this->active;
    }
    
	 public function getCname()
    {
    	return ModUtil::apiFunc('Worship', 'Admin', 'getChurchNameById', array('id' => $this->cid));
    }
    public function getDayName()
    {
    	return ModUtil::apiFunc('Worship', 'Admin', 'getDayNameById', array('id' => $this->weekday));
    }
} 
