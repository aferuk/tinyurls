<?php
namespace Tinyurl\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tinyurl\Model\Tinyurl;
use Tinyurl\Form\TinyurlForm;

use Tinyurl\Model\TinyurlTable;
 
class TinyurlController extends AbstractActionController
{
	protected $tinyurlTable;

    public function indexAction()
    {
	    return new ViewModel(array(
            'tinyurls' => $this->getTinyurlTable()->fetchAll(),
        ));
    }
	
    public function viewAction()
    {		
        // Check if id and blogpost exists.
        $tiny = (string) $this->params()->fromRoute('tiny', 0);
        if (!$tiny) {
            $this->flashMessenger()->addErrorMessage('Blogpost tiny doesn\'t set');
            return $this->redirect()->toRoute('url');
        }
		
		$tableGateway = $this->getServiceLocator()->get('TinyurlTableGateway');		
        $table = new TinyurlTable($tableGateway);
		$tinyurl = $table->getTinyurlByTiny($tiny);
		
        return $this->redirect()->toUrl('http://' . $tinyurl->real_site);
    }
 
    public function addAction()
    {
	    $form = new TinyurlForm();
        $form->get('submit')->setValue('Add');
 
		//echo print_r("<pre>" . print_r($form, true) . "</pre>");
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $tinyurl = new Tinyurl();
            $form->setInputFilter($tinyurl->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $tinyurl->exchangeArray($form->getData());
				
				$tinyurl->real_site = preg_replace('#^https?://#', '', $tinyurl->real_site);
				
				$tinyurl->tiny = $this->create_url();
				// check on duplicate				
				
                $this->getTinyurlTable()->saveTinyurl($tinyurl);
                 
                return $this->redirect()->toRoute('url');
            }
        }
        return array('form' => $form);
    }
	
	public function getTinyurlTable()
    {
        if (!$this->tinyurlTable) {
            $sm = $this->getServiceLocator();
            $this->tinyurlTable = $sm->get('Tinyurl\Model\TinyurlTable');
        }
        return $this->tinyurlTable;
    }
	
	/* custom function. don't know where to put */
	  function create_url() 
	  { 
		$arr = array('a','b','c','d','e','f', 
						 'g','h','i','j','k','l', 
						 'm','n','o','p','r','s', 
						 't','u','v','w','x','y', 
						 'z','A','B','C','D','E', 
						 'G','H','I','J','K','L', 
						 'M','N','O','P','R','S', 
						 'T','U','V','W','X','Y', 
						 'Z','F','1','2','3','4', 
						 '5','6','7','8','9','0'); 
		$url = ""; 
		for($i = 0; $i < 6; $i++) 
		{ 
		  $random = rand(0, count($arr) - 1); 
		  $url .= $arr[$random]; 
		} 
		return $url; 
	  } 
	
}