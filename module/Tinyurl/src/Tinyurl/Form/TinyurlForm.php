<?php
namespace Tinyurl\Form;
 
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
 
class TinyurlForm extends Form
{
	protected $captcha;
 
	public function setCaptcha(CaptchaAdapter $captcha)
	{
		$this->captcha = $captcha;
	}
	
    public function __construct($name = null)
    {	
        // we want to ignore the name passed
        parent::__construct('tinyurl');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'real_site',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'http://',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        /*$this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human.',
                'captcha' => $this->captcha,
            ),
        ));
        $this->add(new Element\Csrf('security'));*/
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}
