<?php
namespace Tinyurl\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
 
class Tinyurl implements InputFilterAwareInterface
{
    public $id;
    public $real_site;
    public $tiny;
 
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception("Not used");
    }
 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->real_site = (isset($data['real_site'])) ? $data['real_site'] : null;
        $this->tiny  = (isset($data['tiny'])) ? $data['tiny'] : null;
    }
		
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'real_site',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 1000,
                        ),
                    ),
                ),
            )));
 
            $this->inputFilter = $inputFilter;
        }
 
        return $this->inputFilter;
    }
	
}