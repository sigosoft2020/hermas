<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('admin/M_dashboardAdmin','dash');
			if (!admin()) {
				redirect('app/admin');
			}
	}
	public function index()
	{
		$admin = $this->session->userdata['admin'];
		$admin_id = $admin['admin_id'];

		// $data['pending'] = $this->dash->bookingsPending($owner_id);
		// $data['bookingThisMonth'] = $this->dash->bookingsThisMonth($owner_id);
		// $data['turfs'] = $this->dash->registeredTurfsCounts($owner_id);
		// //$data['users'] = $this->dash->registeredCustomers($owner_id);
		// //$data['expenseToday'] = $this->dash->todaysExpense($owner_id);
		// $data['expenseMonthly'] = $this->dash->ExpenseThisMonth($owner_id);

		// $data['feedbacks'] = $this->dash->latestFeedbacks($owner_id);
		// $data['expenses'] = $this->dash->latestExpenses($owner_id);

		$this->load->view('admin/dashboard/dashboard');
	}
}
?>
