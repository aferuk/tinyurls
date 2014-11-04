<?php
namespace Tinyurl\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class TinyurlTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
 
    public function getTinyurl($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
 
    public function getTinyurlByTiny($tiny)
    {
        $tiny  = (string) $tiny;
        $rowset = $this->tableGateway->select(array('tiny' => $tiny));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $tiny");
        }
        return $row;
    }
 
    public function saveTinyurl(Tinyurl $tinyurl)
    {
        $data = array(
            'real_site' => $tinyurl->real_site,
            'tiny'  => $tinyurl->tiny,
        );
 
        $id = (int)$tinyurl->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
 
    public function deleteTinyurl($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}