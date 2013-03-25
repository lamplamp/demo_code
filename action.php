<?php
class Action extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	function get_actions_by_user_id($target_user_id)
	{
		$target_user_id = $this->db->escape($target_user_id);

		// Flexigrid passes these form values
		$page = (int)$this->input->post('page');
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		
        $sql = 'SELECT u.first_name, u.last_name, a.from_status, a.to_status, a.note, a.cost, a.date';
		$sql .= ' FROM actions a, users u';
		$sql .= ' WHERE u.id = a.login_user_id AND a.target_user_id = ' . $target_user_id;
		
		$qtype = $this->input->post('qtype');
		$search = $this->input->post('query');
		if (!empty($qtype) && !empty($search))
		{
			$sql .= ' AND ' . $qtype . ' = ' . $this->db->escape($search);
		}
		
		$sql .= " ORDER BY $sortname $sortorder";
		$sql .= ' LIMIT ' . 10*($page-1) . ', 10';	// hardcoding 10 rows a page for now

        $query = $this->db->query($sql);
        $actions = $query->result_array();
        $query->free_result();
		
		$sql = 'SELECT count(*) AS total';
		$sql .= ' FROM actions a, users u';
		$sql .= ' WHERE u.id = a.login_user_id AND a.target_user_id = ' . $target_user_id;
		if (!empty($qtype) && !empty($search))
		{
			$sql .= ' AND ' . $qtype . ' = ' . $this->db->escape($search);
		}
		
        $query = $this->db->query($sql);
        $total = $query->row()->total;

		$data = array(
			'page'	=>	$page,
			'total'	=>	$total,
			'rows'	=>	$actions
		);
        return json_encode($data);
	}
	
	function insert($login_user_id, $target_user_id, $from_status, $to_status, $note, $cost)
	{
        $sql = 'INSERT actions (login_user_id, target_user_id, from_status, to_status, note, cost, date)';
		$sql .= " VALUES ($login_user_id, $target_user_id, $from_status, $to_status, $note, $cost, now())";

		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}
}

/* End of file action.php */
/* Location: ./application/models/action.php */