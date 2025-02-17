<?php

class User_contact extends HIGGS_Model
{
    public function insert($name, $address, $email)
    {
        $this->db->insert('user_contacts', array(
            'name'    => $name,
            'address' => $address,
            'email'   => $email,
        ));
    }
}
