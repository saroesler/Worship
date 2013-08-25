<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Ministrants entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Worship_Worships")
 */
class Worship_Entity_Worships extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $wid;

    /**
     * The following are annotations which define the cid field.
     *
     * @ORM\Column(type="integer")
     */
    private $cid;
    
    /**
     * The following are annotations which define the did field.
     *
     * @ORM\Column(type="integer")
     */
    private $did;
    
    /**
     * The following are annotations which define the wtime field.
     *
     * @ORM\Column(type="time")
     */
    private $wtime;
    
    /**
     * The following are annotations which define the wtitle field.
     *
     * @ORM\Column(type="text")
     */
    private $wtitle;


    public function getWid()
    {
        return $this->wid;
    }
    
   public function getwDid()
    {
        return $this->did;
    }
    
    public function getCid()
    {
    	return $this->cid;
    }
    
    public function getCname()
    {
    	return ModUtil::apiFunc('Worship', 'Admin', 'getChurchNameById', array('id' => $this->cid));
    }
    
	/*public function getddate()
    {
    	return ModUtil::apiFunc('Worship', 'Admin', 'getDateById', array('id' => $this->did));
    }
    */
    public function getwtime()
    {
        return $this->wtime;
    }
    
    public function getwtimeFormatted()
    {
        return $this->wtime->format('G:i');
    }
    
    public function getwtitle()
    {
        return $this->wtitle;
    }
    

    public function setCid($cid)
    {
        $this->cid = $cid;
    }
    
    public function setwDid($did)
    {
        $this->did = $did;
    }
    
    public function setwtime($wtime)
    {
        $this->wtime = new \DateTime($wtime);
    }
    
    public function setwtitle($wtitle)
    {
    	$this->wtitle = $wtitle;
    }
}
