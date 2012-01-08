<?php
class Search_model extends CI_Model {

    function Search_model(){
        parent::__construct();

    }

    function search($searchString, $tableName, $orderField)
    {
        $Results = Doctrine_Core::getTable($tableName)->search('*'.$searchString.'*');
        $Ids = array();
        foreach ($Results as $Result)
        {
            $Ids[] = $Result['id'];
        }

        if(sizeof($Ids) >= 1)
        {
            return Doctrine_Query::create()
                            ->from($tableName.' t')
                            ->whereIn('t.id', $Ids)
                            ->orderBy($orderField)
                            ->setHydrationMode(Doctrine::HYDRATE_RECORD)
                            ->execute();
        }
        else
        {
            return null;
        }
    }
}