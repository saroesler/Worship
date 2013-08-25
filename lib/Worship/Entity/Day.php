<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Worship entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="Worship_Day")
 */
class Worship_Entity_Day extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $did;

    /**
     * The following are annotations which define the wdate field.
     *
     * @ORM\Column(type="date")
     */
    private $wdate;
    
    /**
     * The following are annotations which define the dtitle field.
     *
     * @ORM\Column(type="text")
     */
    private $dtitle;


    public function getDid()
    {
        return $this->did;
    }
    

    public function getwdate()
    {
        return $this->wdate;
    }
    
    public function getwDateFormatted()
    {
        return $this->wdate->format('d.m.Y');
    }
    
    public function getwDateFormattedout()
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
		$date = $this->wdate->format('D d.m.');
		$date = strtr($date, $trans);  
        return $date;
    }
        public function getdtitle()
    {
        return $this->dtitle;
    }
    

    public function setdtitle($dtitle)
    {
        $this->dtitle = $dtitle;
    }
    
    public function setwdate($wdate)
    {
    	$this->wdate = new \Datetime($wdate);

    }
}
