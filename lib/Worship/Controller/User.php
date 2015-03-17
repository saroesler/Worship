<?php
/**
 * This is the User controller class providing navigation and interaction functionality.
 */
class Worship_Controller_User extends Zikula_AbstractController
{
    /**
     * @brief Main function.
     * @return string
     * 
     * @author Sascha Rösler
     */
    public function main()
    {
        return true;
    }
    
    public function view()
    {
    	$Worships = $this->entityManager->getRepository('Worship_Entity_Worships')->findBy(array(),array('wdate'=>'ASC', 'wtime'=>'ASC'));
    	$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
    	$days = $this->entityManager->getRepository('Worship_Entity_Day')->findBy(array());
    	$dates = array();
    	foreach($Worships as $key =>$Worship)
    	{
    		if($key>0)
    		{
    			if($Worships[$key-1]->getWdateFormattedout()!=$Worship->getWdateFormattedout())
    				$dates[] = array("date"=>$Worship->getWdateFormattedout(),"date_unformat"=>$Worship->getwdate(),"dayname"=>"");
    		}
    		else
    			$dates[] = array("date"=>$Worship->getWdateFormattedout(),"date_unformat"=>$Worship->getwdate(),"dayname"=>"");
		}
		foreach($dates as $key =>$date)
		{
			$temp = $date['date_unformat']->format('d.m.');
			foreach($days as $day)
			{
				$temp2 = $day->getDdateFormatted();
				if($temp == $temp2)
					$dates[$key]["dayname"] = $day->getDtitle();
			}
		}
		
		return $this->view
    		->assign('churches', $churches)
    		->assign('Worships',$Worships)
    		->assign('dates',$dates)
    		->fetch('User/view.tpl');
    }
}
