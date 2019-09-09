<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_expensesOwner','expense');
			$this->load->model('Common');
			if (!owner()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('owner/expenses/view');
	}
	public function get()
	{
		$owner = $this->session->userdata['owner'];
		$owner_id = $owner['owner_id'];

		$result = $this->expense->make_datatables($owner_id);
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->expense;
			$sub_array[] = $res->notes;
			$sub_array[] = $res->date;
			$sub_array[] = $res->time;
			$sub_array[] = $res->cat_name;
			$sub_array[] = $res->turf_name;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->expense->get_all_data($owner_id),
			"recordsFiltered" => $this->expense->get_filtered_data($owner_id),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$owner = $this->session->userdata['owner'];
		$owner_id = $owner['owner_id'];

		$data['categories'] = $this->Common->get_details('expense_categories',array('status' => 1))->result();
		$data['turfs'] = $this->Common->get_details('turfs',array('owner_id' => $owner_id , 'status' => 'a'))->result();
		$this->load->view('owner/expenses/add',$data);
	}

	public function addExpense()
	{
		$owner = $this->session->userdata['owner'];
		$owner_id = $owner['owner_id'];

		$expense = $this->security->xss_clean($this->input->post('expense'));
		$notes = $this->security->xss_clean($this->input->post('notes'));
		$date = $this->security->xss_clean($this->input->post('date'));
		$time = $this->security->xss_clean($this->input->post('time'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

		$cat_id = $this->security->xss_clean($this->input->post('cat_id'));

		$cat_name = $this->Common->get_details('expense_categories',array('cat_id' => $cat_id))->row()->cat_name;

		$array = [
			'expense' => $expense,
			'notes' => $notes,
			'date' => $date,
			'time' => $time,
			'cat_id' => $cat_id,
			'cat_name' => $cat_name,
			'turf_id' => $turf_id,
			'owner_id' => $owner_id
		];

		if ($this->Common->insert('owner_expenses',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Expense added..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add expense..!');
		}

		redirect('owner/expenses');
	}
}
?>
