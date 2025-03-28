<?php

class User_model extends CI_Model
{

   public $_table = 'users';
   public $primary_key = 'id';
   public $name = 'username';
   public $email = 'email';
   public $active = 'active';


   function __construct()
   {
      parent::__construct();
   }

   // Insert New records
   public function create($insertData)
   {
      $this->db->insert($this->_table, $insertData);
      return $this->db->insert_id();
   }

   // get all records
   public function get_all()
   {
      $this->db->select('*')
        ->from($this->_table)
        ->order_by($this->primary_key, 'DESC');
      $query = $this->db->get();
      if ($query->num_rows() != 0) {
         return $query->result_array();
      } else {
         return false;
      }
   }

   public function get_all_users()
   {
      $this->db->select('u.*,GROUP_CONCAT(g.name) as group_name')
        ->from('users as u')
        ->join('users_groups as ug', 'ug.user_id = u.id', 'left')
        ->join('groups as g', 'g.id = ug.group_id', 'left')
        ->group_by('ug.user_id')
        ->order_by('u.id', 'DESC');
      $query = $this->db->get();
      if ($query->num_rows() != 0) {
         return $query->result_array();
      } else {
         return false;
      }
   }

   // get a record by id
   public function get_by_id($id)
   {
      $this->db->select('*')
        ->from($this->_table)
        ->where($this->primary_key, $id);
      $query = $this->db->get();
      if ($query->num_rows() != 0) {
         return $query->result_array();
      } else {
         return false;
      }
   }


   // check duplicate entry or already exists
   public function exist($data, $id)
   {
      $query = $this->db->select('*')
        ->from($this->_table)
        ->where($this->name, $data)
        ->where_not_in($this->primary_key, $id)
        ->get();
      return ($query->num_rows() == 0);
   }

   // edit a record
   public function edit($updateData, $updateId)
   {
      $this->db->where($this->primary_key, $updateId)->update($this->_table, $updateData);

		return (bool) $this->db->affected_rows();
   }


   // delete a record
   public function delete($id)
   {
      $this->db->delete($this->_table, array($this->primary_key => $id));

		return (bool) $this->db->affected_rows();
   }

}