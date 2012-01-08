<?php
class Admin_model extends CI_Model {

    function Admin_model(){
        parent::__construct();
        $this->load->database();
    }

    //used normal querying here, easier on DB and couldnt do getuserlist without a standard query
    
    function getAllAlbums()
    {
        return $this->db->query("Select a.id as id,
                                        a.name as name,
                                        COUNT(p.id) as pictureCount
                                 From album a
                                        LEFT JOIN picture p ON p.album_id = a.id
                                 Group by a.id, a.name
                                 Order by a.name ASC");
    }

    function getUserList()
    {   
        return $this->db->query("SELECT u.id AS id, 
                                        u.username AS username,
                                        CONCAT(u.first_name,' ',u.last_name) AS fullname,
                                        u.email AS email,
                                        u.birthdate AS birthdate,
                                        DATE_FORMAT(u.created_at, '%m/%d/%Y') AS joindate,
                                        COUNT(p.id) AS pictureCount, 
                                        SUM(p.size) AS spaceUsed,
                                        u.quota AS quota,
                                        COUNT(distinct a.id) AS albumCount 
                                FROM user u 
                                    LEFT JOIN album a ON u.id = a.user_id 
                                    LEFT JOIN picture p ON a.id = p.album_id 
                                GROUP BY u.id,u.username,u.email,u.birthdate,u.created_at,u.quota 
                                ORDER BY u.username ASC");
    }
}