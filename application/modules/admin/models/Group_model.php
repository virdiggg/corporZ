<?php

class Group_model extends CI_Model {

	public $_table = 'groups';
	public $primary_key = 'id';
	public $name = 'name';
	public $active = 'active';


	function __construct() {
		parent::__construct();
	}

	// Insert New records
	public function create( $insertData ) {
		$result = $this->db->insert( $this->_table, $insertData );

		return $result;
	}

	// get all records
	public function get_all() {
		$this->db->select( '*' )
		         ->from( $this->_table )
		         ->order_by( $this->primary_key, 'DESC' );
		$query = $this->db->get();
		if ( $query->num_rows() != 0 ) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	// get a record by id
	public function get_by_id( $id ) {
		$this->db->select( '*' )
		         ->from( $this->_table )
		         ->where( $this->primary_key, $id );
		$query = $this->db->get();
		if ( $query->num_rows() != 0 ) {
			return $query->result_array();
		} else {
			return false;
		}
	}


	// check duplicate entry or already exists
	public function exist( $data, $id ) {
		$query = $this->db->select( '*' )
		                  ->from( $this->_table )
		                  ->where( $this->name, $data )
		                  ->where_not_in( $this->primary_key, $id )
		                  ->get();
		return ($query->num_rows() == 0);
	}

	// edit a record
	public function edit( $updateData, $updateId ) {
		$result = $this->db->where( $this->primary_key, $updateId )->update( $this->_table, $updateData );

		return $result;
	}


	// delete a record
	public function delete( $id ) {
		$result = $this->db->delete( $this->_table, array( $this->primary_key => $id ) );

		return $result;
	}

}