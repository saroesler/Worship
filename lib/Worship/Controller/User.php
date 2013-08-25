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
     * @author Christian Flach
     */
    public function main()
    {
        return true;
    }
    
    public function daily()
    {
    	$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
    	
    	foreach($churches as $church)
    	{
    		$cid=$church->getCid();
			$em = $this->getService('doctrine.entitymanager');
			$qb = $em->createQueryBuilder();
			$qb->select('p')
			   ->from('Worship_Entity_Churchesworships', 'p')
			  ->where('p.cid = :test')
			  ->setParameter('test', $cid)
			  ->orderBy('p.weektime', 'ASC')
			  ->orderBy('p.nwtime', 'ASC')
			->setMaxResults(100);
			$worshipchurches[]= array( 'worships'=>$qb->getQuery()->getArrayResult(), 'church'=>$church);
		}
		return $this->view
    		->assign('churches', $churches)
    		->assign('worshipchurches',$worshipchurches)
    		->fetch('User/daily.tpl');
    }
    
    public function special()
    {
    	$days = $this->entityManager->getRepository('Worship_Entity_Day')->findBy(array());
    	
    	foreach($days as $day)
    	{
    		$did=$day->getDid();
			$em = $this->getService('doctrine.entitymanager');
			$qb = $em->createQueryBuilder();
			$qb->select('p')
			   ->from('Worship_Entity_Worships', 'p')
			  ->where('p.did = :test')
			  ->setParameter('test', $did)
			  ->orderBy('p.wtime', 'ASC')
			->setMaxResults(100);
			$worshipdays[]= array( 'worships'=>$qb->getQuery()->getArrayResult(), 'day'=>$day);
		}
		return $this->view
    		->assign('worshipdays',$worshipdays)
    		->fetch('User/special.tpl');
    }
    
    public function all()
    {
    	//for the daily worships
    	$churches = $this->entityManager->getRepository('Worship_Entity_Church')->findBy(array());
    	
    	foreach($churches as $church)
    	{
    		$cid=$church->getCid();
			$em = $this->getService('doctrine.entitymanager');
			$qb = $em->createQueryBuilder();
			$qb->select('p')
			   ->from('Worship_Entity_Churchesworships', 'p')
			  ->where('p.cid = :test')
			  ->setParameter('test', $cid)
			  ->orderBy('p.weektime', 'ASC')
			  ->orderBy('p.nwtime', 'ASC')
			->setMaxResults(100);
			$worshipchurches[]= array( 'worships'=>$qb->getQuery()->getArrayResult(), 'church'=>$church);
		}
		
		//for the special worships
		$days = $this->entityManager->getRepository('Worship_Entity_Day')->findBy(array());
    	
    	foreach($days as $day)
    	{
    		$did=$day->getDid();
			$em = $this->getService('doctrine.entitymanager');
			$qb = $em->createQueryBuilder();
			$qb->select('p')
			   ->from('Worship_Entity_Worships', 'p')
			  ->where('p.did = :test')
			  ->setParameter('test', $did)
			  ->orderBy('p.wtime', 'ASC')
			->setMaxResults(100);
			$worshipdays[]= array( 'worships'=>$qb->getQuery()->getArrayResult(), 'day'=>$day);
		}
		
//TODO: rechte Abfragen
		 // Display Admin Edit Link
        if ($accesslevel >= ACCESS_EDIT) {
            $this->view->assign('displayeditlink', true);
        } else {
            $this->view->assign('displayeditlink', false);
        }
		return $this->view
			->assign('worshipchurches', $worshipchurches)
    		->assign('worshipdays',$worshipdays)
    		->fetch('User/all.tpl');
    }
}
