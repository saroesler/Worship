<?php
/**
 * Copyright Zikula Foundation 2010 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license MIT
 * @package ZikulaExamples_ExampleDoctrine
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Form handler for create and edit.
 */
class Worship_Handler_DayEdit extends Zikula_Form_AbstractHandler
{

    private $day;

    /**
     * Setup form.
     *
     * @param Zikula_Form_View $view Current Zikula_Form_View instance.
     *
     * @return boolean
     */
    public function initialize(Zikula_Form_View $view)
    {
        // Get the id.
        $actionid = FormUtil::getPassedValue('id',null,'GET');
        if ($actionid) {
            // load user with id
            $day = $this->entityManager->find('Worship_Entity_Day', $actionid);
            if (!$day) {
                return LogUtil::registerError($this->__f('Day with id %s not found', $pid));
            }
            $view->assign('day',$day);
        } else {
            echo 'No ID';
        }


        // assign current values to form fields
        return true;
    }

    /**
     * Handle form submission.
     *
     * @param Zikula_Form_View $view  Current Zikula_Form_View instance.
     * @param array            &$args Args.
     *
     * @return boolean
     */
    public function handleCommand(Zikula_Form_View $view, &$args)
    {
    	$actionid = FormUtil::getPassedValue('id',null,'GET');
        $url = ModUtil::url('Worship', 'admin', 'days' );
        if ($args['commandName'] == 'cancel') {
            return $view->redirect($url);
        }


        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        // load form values
        $data = $view->getValues();
        $data["ddate"] = $data["ddate"] . "2000";
        print_r($data);

        // merge user and save everything
        $day = $this->entityManager->find('Worship_Entity_Day', $actionid);
        $day->merge($data);
       // $this->page->setedit_comment($uid);
        $this->entityManager->persist($day);
        $this->entityManager->flush();

        return $view->redirect($url);
    }
}
