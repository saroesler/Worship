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
     * @ORM\Column(type="date")
     */
    private $wdate;
    
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
    
    public function getCid()
    {
    	return $this->cid;
    }
    
    public function setCid($cid)
    {
        $this->cid = $cid;
    }
    
    public function getCname()
    {
    	return ModUtil::apiFunc('Worship', 'Admin', 'getChurchNameById', array('id' => $this->cid));
    }
    
        public function getwdate()
    {
        return $this->wdate;
    }
    
    public function getWdateFormatted()
    {
        return $this->wdate->format('d.m.y');
    }
    
    public function getWdateFormattedout()
    {
    	$trans = array(
			'Monday'    => 'Montag',
			'Tuesday'   => 'Dienstag',
			'Wednesday' => 'Mittwoch',
			'Thursday'  => 'Donnerstag',
			'Friday'    => 'Freitag',
			'Saturday'  => 'Samstag',
			'Sunday'    => 'Sonntag',
			'Mon'       => 'Mo',
			'Tue'       => 'Di',
			'Wed'       => 'Mi',
			'Thu'       => 'Do',
			'Fri'       => 'Fr',
			'Sat'       => 'Sa',
			'Sun'       => 'So',
			'January'   => 'Januar',
			'February'  => 'Februar',
			'March'     => 'März',
			'May'       => 'Mai',
			'June'      => 'Juni',
			'July'      => 'Juli',
			'October'   => 'Oktober',
			'December'  => 'Dezember',
		);
		$date = $this->wdate->format('D d.m.Y');
		$date = strtr($date, $trans);  
        return $date;
    }
    
    public function getWdateMonthFormattedout()
    {
    	$trans = array(
			'Monday'    => 'Montag',
			'Tuesday'   => 'Dienstag',
			'Wednesday' => 'Mittwoch',
			'Thursday'  => 'Donnerstag',
			'Friday'    => 'Freitag',
			'Saturday'  => 'Samstag',
			'Sunday'    => 'Sonntag',
			'Mon'       => 'Mo',
			'Tue'       => 'Di',
			'Wed'       => 'Mi',
			'Thu'       => 'Do',
			'Fri'       => 'Fr',
			'Sat'       => 'Sa',
			'Sun'       => 'So',
			'January'   => 'Januar',
			'February'  => 'Februar',
			'March'     => 'März',
			'May'       => 'Mai',
			'June'      => 'Juni',
			'July'      => 'Juli',
			'October'   => 'Oktober',
			'December'  => 'Dezember',
		);
		$date = $this->wdate->format('d. F');
		$date = strtr($date, $trans);  
        return $date;
    }
    
    public function getWdateMonthYearFormattedout()
    {
    	$trans = array(
			'Monday'    => 'Montag',
			'Tuesday'   => 'Dienstag',
			'Wednesday' => 'Mittwoch',
			'Thursday'  => 'Donnerstag',
			'Friday'    => 'Freitag',
			'Saturday'  => 'Samstag',
			'Sunday'    => 'Sonntag',
			'Mon'       => 'Mo',
			'Tue'       => 'Di',
			'Wed'       => 'Mi',
			'Thu'       => 'Do',
			'Fri'       => 'Fr',
			'Sat'       => 'Sa',
			'Sun'       => 'So',
			'January'   => 'Januar',
			'February'  => 'Februar',
			'March'     => 'März',
			'May'       => 'Mai',
			'June'      => 'Juni',
			'July'      => 'Juli',
			'October'   => 'Oktober',
			'December'  => 'Dezember',
		);
		$date = $this->wdate->format('d. F Y');
		$date = strtr($date, $trans);  
        return $date;
    }
    
    public function setWdate($wdate)
    {
    	$this->wdate = new \Datetime($wdate);
    }
    
    public function getWtime()
    {
        return $this->wtime;
    }
    
    public function getWtimeFormatted()
    {
        return $this->wtime->format('H:i');
    }
    
    public function setWtime($wtime)
    {
        $this->wtime = new \DateTime($wtime);
    }
    
    public function getWtitle()
    {
        return $this->wtitle;
    }
    
    public function setWtitle($wtitle)
    {
    	$this->wtitle = $wtitle;
    }
}
