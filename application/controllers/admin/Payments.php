<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_payments','payments');
			$this->load->model('Common');
			if (!owner()) {
				redirect('app');
			}
	}
	public function index()
	{
		$owner = $this->session->userdata['owner'];
		$owner_id = $owner['owner_id'];

		$data['turfs'] = $this->Common->get_details('turfs',array('register' => 'complete','owner_id' => $owner_id))->result();
		if (isset($_POST['turf_id'])) {
			$turf_id = $_POST['turf_id'];
		}
		else {
			$turf_id = 'all';
		}
		$data['turf_id'] = $turf_id;
		$data['payments'] = $this->payments->getPaymentsByTurfOwner($turf_id,$owner_id);
		$this->load->view('owner/payments/view',$data);
	}

}
?>
