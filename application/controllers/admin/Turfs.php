<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turfs extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('Turf','turf');
			$this->load->model('M_turf');
			$this->load->model('Turf_blocked','turfB');
			$this->load->model('Turf_pending','turfP');
			if (!owner()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('owner/turfs/view');
	}
	public function get()
	{
		$owner = $this->session->userdata['owner'];

		$result = $this->turf->make_datatables($owner['owner_id']);
		$data = array();
		foreach ($result as $res) {
			if ($res->status == "a") {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			$button = '<a class="btn btn-sm btn-outline-danger waves-light waves-effect w-md" href="' . site_url('owner/turfs/deactivate/'.$res->turf_id) . '" onclick="return block()"><i class="fa fa-ban m-r-5"></i><span> deactivate</span></a>';

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->cover_image . '" width="100px" height="100px">';
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->place;
			$sub_array[] = $status;
			$sub_array[] = $button;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('owner/turfs/details/'.$res->turf_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->turf->get_all_data($owner['owner_id']),
			"recordsFiltered" => $this->turf->get_filtered_data($owner['owner_id']),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function blocked()
	{
		$this->load->view('owner/turfs/blocked');
	}

	public function getBlocked()
	{
		$owner = $this->session->userdata['owner'];

		$result = $this->turfB->make_datatables($owner['owner_id']);
		$data = array();
		foreach ($result as $res) {
			if ($res->status == "a") {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			$button = '<a class="btn btn-sm btn-outline-success waves-light waves-effect w-md" href="' . site_url('owner/turfs/activate/'.$res->turf_id) . '" onclick="return activate()"><i class="fa fa-check m-r-5"></i><span>activate</span></a>';

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->cover_image . '" width="100px" height="100px">';
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->place;
			$sub_array[] = $status;
			$sub_array[] = $button;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('owner/turfs/details/'.$res->turf_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->turfB->get_all_data($owner['owner_id']),
			"recordsFiltered" => $this->turfB->get_filtered_data($owner['owner_id']),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function pending()
	{
		$this->load->view('owner/turfs/pending');
	}

	public function getPending()
	{
		$owner = $this->session->userdata['owner'];

		$result = $this->turfP->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$url = site_url('owner/turfs/routing/'.$res->turf_id);

			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->cover_image . '" width="100px" height="100px">';
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->place;
			$sub_array[] = "Registration of this turf is not yet completed , complete the registration by simply clicking the link <a href='" . $url . "'>Click here</a>";

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->turfP->get_all_data($owner['owner_id']),
			"recordsFiltered" => $this->turfP->get_filtered_data($owner['owner_id']),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function activate($turf_id)
	{
		$status = [
			'status' => 'a'
		];
		if ($this->Common->update('turf_id',$turf_id,'turfs',$status)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Turf activated..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to activate turf , Please try agein later..!');
		}

		redirect('owner/turfs');
	}

	public function deactivate($turf_id)
	{
		$status = [
			'status' => 'b'
		];
		if ($this->Common->update('turf_id',$turf_id,'turfs',$status)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Turf deactivated..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to activate turf , Please try agein later..!');
		}

		redirect('owner/turfs/blocked');
	}

	public function details($turf_id)
	{
		$turf = $this->Common->get_details('turfs',array('turf_id' => $turf_id));
		if ($turf->num_rows() > 0) {
			$data['turf'] = $turf->row();

			$data['amenities'] = $this->M_turf->getAmenities($turf_id);
			$data['images'] = $this->M_turf->getTurfImages($turf_id);
			$data['owner'] = $this->M_turf->getTurfOwner($turf->row()->owner_id);
			$data['piches'] = $this->M_turf->getTurfPitch($turf_id);

			$slots = $this->Common->get_details('time_slots',array('turf_id' => $turf_id))->result();
			$pitches = $this->turf->getTurfPitches($turf_id);

			$result = array();

			$count = 0;
			foreach ($pitches as $pitch) {
				$tp_id = $this->Common->get_details('turf_pitches',array('turf_id' => $turf_id , 'pitch_id' => $pitch->pitch_id))->row()->tp_id;
				$array = [];
				foreach ($slots as $slot) {
					$check = $this->Common->get_details('turf_pitch_slot',array('tp_id' => $tp_id , 'ts_id' => $slot->ts_id))->num_rows();
					if ($check > 0) {
						$array[] = $slot->ts_id;
					}
				}
				$result[$pitch->pitch_id] = $array;
				$count++;
			}

			$data['slots'] = $slots;
			$data['pitches'] = $pitches;
			$data['result'] = $result;
			$data['turf_id'] = $turf_id;
			$this->load->view('owner/turfs/details',$data);
		}
		else {
			redirect('owner/turfs');
		}
	}

	public function routing($turf_id)
	{
		$get = $this->Common->get_details('turfs',array('turf_id' => $turf_id));
		if ($get->num_rows() > 0) {
			$turf = $get->row();
			if($turf->register == '1')
			{
				redirect('owner/turfs/sliders/'.$turf_id);
			}
			elseif($turf->register == '2')
			{
				redirect('owner/turfs/rates/'.$turf_id);
			}
			elseif($turf->register == 'complete')
			{
				redirect('owner/turfs');
			}
		}
		else {
			redirect('owner/turfs');
		}
	}

	public function add()
	{
		$data['owners'] = $this->Common->get_details('owners',array('status' => 'a'))->result();
		$this->load->view('owner/turfs/add',$data);
	}

	public function addBasicDetails()
	{
		$turf_name = $this->security->xss_clean($this->input->post('name'));
		$place = $this->security->xss_clean($this->input->post('location'));
		$lat = $this->security->xss_clean($this->input->post('latitude'));
		$lon  = $this->security->xss_clean($this->input->post('longitude'));
		$owner_id = $this->security->xss_clean($this->input->post('owner_id'));
		$status = 'b';
		$register = '1';

		$image = $this->input->post('image');
		$img = substr($image, strpos($image, ",") + 1);

		$url = FCPATH.'uploads/turf_cover/';
		$rand = $turf_name.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/turf_cover/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));

		$array = [
			'turf_name' => $turf_name,
			'lat' => $lat,
			'lon' => $lon,
			'place' => $place,
			'cover_image' => $path,
			'owner_id' => $owner_id,
			'status' => $status,
			'register' => $register
		];

		if ($id = $this->Common->insert('turfs',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Turf details added successfully..!');

			redirect('owner/turfs/sliders/'.$id);
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add turf..!');

			redirect('owner/turf/add');
		}

	}

	public function sliders($turf_id)
	{
		$get = $this->Common->get_details('turf_images',array('turf_id' => $turf_id));
		if ($get->num_rows() > 0) {
			$data['num'] = $get->num_rows();
		}
		else {
			$data['num'] = 0;
		}
		$data['turf_id'] = $turf_id;
		$data['sliders'] = $get->result();

		$this->load->view('owner/turfs/sliders',$data);
	}

	public function addSlider()
	{
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

		$image = $this->input->post('image');
		$img = substr($image, strpos($image, ",") + 1);

		$url = FCPATH.'uploads/turf/';
		$rand = date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/turf/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));

		$array = [
			'image' => $path,
			'turf_id' => $turf_id
		];

		if ($this->Common->insert('turf_images',$array)) {
			$turf_status = [
				'register' => '2'
			];
			//$this->Common->update('turf_id',$turf_id,'turfs',$turf_status);
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Slider image added successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add turf image..!');
		}
		redirect('owner/turfs/sliders/'.$turf_id);
	}

	public function delete_slider($image_id)
	{
		$array = [
			'image_id' => $image_id
		];

		$image = $this->Common->get_details('turf_images',$array);

		$path = FCPATH . $image->row()->image;

		if ($this->Common->delete('turf_images',$array)) {
			unlink($path);
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Image deleted..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to remove turf image..!');
		}

		redirect('owner/turfs/sliders/'.$image->row()->turf_id);
	}

	public function amenities($turf_id)
	{
		$amenities = $this->Common->get_details('amenities',array('status' => '1'))->result();
		$t_amenities = $this->turf->getAmenities($turf_id);

		if (empty($t_amenities)) {
			$data['status'] = false;
			foreach ($amenities as $amenity) {
				$amenity->stat = false;
			}
		}
		else {
			$data['status'] = true;
			$amenity_ids = array_column($t_amenities, 'amenity_id');
			foreach ($amenities as $amenity) {
				if(in_array($amenity->amenity_id,$amenity_ids))
				{
					$amenity->stat = true;
				}
				else {
					$amenity->stat = false;
				}
			}
		}

		$data['amenities'] = $amenities;
		$data['turf_id'] = $turf_id;
		$this->load->view('owner/turfs/amenities',$data);

	}

	public function addAmenities()
	{
		$amenities = $this->input->post('amenities');
		$turf_id = $this->input->post('turf_id');

		$array = [
			'turf_id' => $turf_id
		];

		$this->Common->delete('turf_amenities',$array);

		foreach($amenities as $am)
		{
			$array['amenity_id'] = $am;
			$this->Common->insert('turf_amenities',$array);
		}

		$this->session->set_flashdata('alert_type', 'success');
		$this->session->set_flashdata('alert_title', 'Success');
		$this->session->set_flashdata('alert_message', 'Amenities updated..!');

		redirect('owner/turfs/amenities/'.$turf_id);
	}

	public function pitches($turf_id)
	{
		$pitches = $this->Common->get_details('pitches',array())->result();

		$turf_pitches = $this->turf->getTurfPitches($turf_id);

		if (empty($turf_pitches)) {
			foreach ($pitches as $pitch) {
				$pitch->count = 1;
				$pitch->status = false;
			}

			$array['status'] = false;
		}
		else {
			$array['status'] = true;
			foreach ($pitches as $pitch) {
				foreach ($turf_pitches as $tp) {
					if($pitch->pitch_id == $tp->pitch_id)
					{
						$pitch->status = true;
						$pitch->count = $tp->pitch_count;
						break;
					}
					$pitch->status = false;
					$pitch->count = 1;
				}
			}
		}
		$array['pitches'] = $pitches;
		$array['turf_id'] = $turf_id;
		$this->load->view('owner/turfs/pitches',$array);

	}

	public function addPitches()
	{
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));
		$pitches = $this->security->xss_clean($this->input->post('pitches'));
		$counts = $this->security->xss_clean($this->input->post('counts'));
		$count = [];

		if (empty($pitches)) {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Please choose pitches..!');

			redirect('owner/turfs/pitches/'.$turf_id);
		}
		else {
			$this->Common->delete('turf_pitches',array('turf_id' => $turf_id));

			if (count($pitches) == 1) {
				if ($pitches[0] == 1) {
					$count[] = $counts[0];
				}
				if ($pitches[0] == 2) {
					$count[] = $counts[1];
				}
				if ($pitches[0] == 3) {
					$count[] = $counts[2];
				}
			}
			elseif(count($pitches) == 2) {
				if (in_array(1,$pitches) && in_array(2,$pitches)) {
					$count[] = $counts[0];
					$count[] = $counts[1];
				}
				if (in_array(2,$pitches) && in_array(3,$pitches)) {
					$count[] = $counts[1];
					$count[] = $counts[2];
				}
				if (in_array(1,$pitches) && in_array(3,$pitches)) {
					$count[] = $counts[0];
					$count[] = $counts[2];
				}
			}
			elseif (count($pitches) == 3) {
				$count = $counts;
			}

			$i=0;
			foreach ($pitches as $pitch) {
				$array = [
					'pitch_id' => $pitch,
					'pitch_count' => $count[$i],
					'turf_id' => $turf_id
				];
				$this->Common->insert('turf_pitches',$array);
				$i++;
			}

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Pitches added..!');

			redirect('owner/turfs/pitches/'.$turf_id);
		}
	}

	public function timeslots($turf_id)
	{
		$slots = $this->Common->get_details('time_slots',array('turf_id' => $turf_id));
		if ($slots->num_rows() > 0) {
			$data['status'] = true;
		}
		else {
			$data['status'] = false;
		}
		$data['slots'] = $slots->result();
		$data['turf_id'] = $turf_id;
		$this->load->view('owner/turfs/timeslots',$data);
	}

	public function addTimeSlots()
	{
		$from_time = $this->security->xss_clean($this->input->post('from'));
		$to_time = $this->security->xss_clean($this->input->post('to'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

		$ft = date('H:i:s',strtotime($from_time));
		$tt = date('H:i:s',strtotime($to_time));

		$slots = $this->Common->get_details('time_slots',array('turf_id' => $turf_id))->result();

		$checkFrom = true;
		$checkTo = true;
		foreach ($slots as $slot) {
			if (strtotime($ft) >= strtotime($slot->ft) && strtotime($ft) < strtotime($slot->tt)) {
				$checkFrom = false;
			}
			if (strtotime($tt) >= strtotime($slot->ft) && strtotime($tt) <= strtotime($slot->tt)) {
				$checkTo = false;
			}
		}

		// $check1 = $this->Common->get_details('time_slots',array('ft >=' => $ft , 'tt <' => $ft , 'turf_id' => $turf_id))->num_rows();
		// $check2 = $this->Common->get_details('time_slots',array('ft >=' => $tt , 'tt <=' => $tt , 'turf_id' => $turf_id))->num_rows();

		$flag = true;
		$message = '';
		if (!$checkFrom) {
			$message = 'Invalid from time..!';
			$flag = false;
		}
		if (!$checkTo) {
			$message = 'Invalid to time..!';
			$flag = false;
		}
		if (!$checkFrom && !$checkTo ) {
			$message = 'Invalid from time and to time..!';
			$flag = false;
		}

		if ($flag) {
			$array = [
				'from_time' => $from_time,
				'to_time' => $to_time,
				'ft' => $ft,
				'tt' => $tt,
				'turf_id' => $turf_id
			];
			if ($this->Common->insert('time_slots',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Timeslot added..!');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to add timeslot..!');
			}
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', $message);
		}
		redirect('owner/turfs/timeslots/'.$turf_id);
	}

	public function deleteTimeSlots($ts_id)
	{
		$array = [
			'ts_id' => $ts_id
		];
		$check = $this->Common->get_details('time_slots',$array);
		if ($check->num_rows() > 0) {
			if ($this->Common->delete('time_slots',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Timeslot slot deleted..!');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to delete..!');
			}

			redirect('owner/turfs/timeslots/'.$check->row()->turf_id);
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to delete..!');

			redirect('owner/turfs/pending');
		}

	}

	public function rates($turf_id)
	{
		$get = $this->Common->get_details('turfs',array('turf_id' => $turf_id));
		if ($get->num_rows() > 0) {
			$turfs = $get->row();
			if ($turfs->register == '1') {
				$update = [
					'register' => '2'
				];
				$this->Common->update('turf_id',$turf_id,'turfs',$update);
			}
			$slots = $this->Common->get_details('time_slots',array('turf_id' => $turf_id))->result();
			$pitches = $this->turf->getTurfPitches($turf_id);

			$result = array();

			$count = 0;
			foreach ($pitches as $pitch) {
				$tp_id = $this->Common->get_details('turf_pitches',array('turf_id' => $turf_id , 'pitch_id' => $pitch->pitch_id))->row()->tp_id;
				$array = [];
				foreach ($slots as $slot) {
					$check = $this->Common->get_details('turf_pitch_slot',array('tp_id' => $tp_id , 'ts_id' => $slot->ts_id))->num_rows();
					if ($check > 0) {
						$array[] = $slot->ts_id;
					}
				}
				$result[$pitch->pitch_id] = $array;
				$count++;
			}
			$slot_count = count($slots);
			$total_count = $count * $slot_count;
			$result_count = 0;
			foreach ($result as $res) {
				if (empty($res)) {
					$res_count = 0;
				}
				else {
					$res_count = count($res);
				}
				$result_count = $result_count + $res_count;
			}

			if ($total_count == $result_count) {
				$data['status'] = true;
			}
			else {
				$data['status'] = false;
			}

			$data['slots'] = $slots;
			$data['pitches'] = $pitches;
			$data['turf_id'] = $turf_id;
			$data['result'] = $result;

			$this->load->view('owner/turfs/fees',$data);
		}
		else {
			redirect('owner/turfs/pending');
		}
	}

	public function addSlotFee()
	{
		$ts_id = $this->security->xss_clean($this->input->post('ts_id'));
		$pitch_id = $this->security->xss_clean($this->input->post('pitch_id'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));
		$fees = $this->security->xss_clean($this->input->post('fees'));

		$tp_id = $this->Common->get_details('turf_pitches',array('turf_id' => $turf_id , 'pitch_id' => $pitch_id))->row()->tp_id;

		// Insert into turf_pitch_slot

		$array = [
			'tp_id' => $tp_id,
			'ts_id' => $ts_id
		];

		$check = $this->Common->get_details('turf_pitch_slot',$array);
		if ($check->num_rows() > 0) {
			$tsf_id = $check->row()->id;
			$i = 1;
			$check1 = $this->Common->get_details('turf_time_slot_fees',array('tsf_id' => $tsf_id));
			if ($check1->num_rows() == 7) {
				foreach ($fees as $fee) {
					$update = [
						'price' => $fee
					];
					$this->turf->updateFee($update,$tsf_id,$i);
					$i++;
				}
			}
			else {
				$i = 1;
				foreach ($fees as $fee) {
					$get = [
						'tsf_id' => $tsf_id,
						'day_id' => $i
					];
					$check2 = $this->Common->get_details('turf_time_slot_fees',$get)->num_rows();
					if ($check2 > 0) {
						$update = [
							'price' => $fee
						];
						$this->turf->updateFee($update,$tsf_id,$i);
					}
					else {
						$get['price'] = $fee;
						$this->Common->insert('turf_time_slot_fees',$get);
					}
					$i++;
				}
			}
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Fees updated..!');

			redirect('owner/turfs/rates/'.$turf_id);
		}
		else {
			// Insert into turf_pitch_slot
			$tsf_id = $this->Common->insert('turf_pitch_slot',$array);
			$i = 1;
			foreach ($fees as $fee) {
				$insert = [
					'day_id' => $i,
					'price' => $fee,
					'tsf_id' => $tsf_id
				];
				$this->Common->insert('turf_time_slot_fees',$insert);
				$i++;
			}
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Fees updated..!');

			redirect('owner/turfs/rates/'.$turf_id);
		}

	}
	public function getTurfPrices()
	{
		$ts_id = $this->security->xss_clean($this->input->post('ts_id'));
		$pitch_id = $this->security->xss_clean($this->input->post('pitch_id'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

		$tp_id = $this->Common->get_details('turf_pitches',array('turf_id' => $turf_id , 'pitch_id' => $pitch_id))->row()->tp_id;

		$array = [
			'tp_id' => $tp_id,
			'ts_id' => $ts_id
		];

		$tsf_id = $this->Common->get_details('turf_pitch_slot',$array)->row()->id;

		$result = $this->Common->get_details('turf_time_slot_fees',array('tsf_id' => $tsf_id))->result();

		print_r(json_encode($result));
	}

	public function complete_registration($turf_id)
	{
		$check = $this->Common->get_details('turfs',array('turf_id' => $turf_id))->num_rows();
		if ($check > 0) {
			$status = [
				'status' => 'a',
				'register' => 'complete'
			];
			if ($this->Common->update('turf_id',$turf_id,'turfs',$status)) {
				$wallet = [
					'turf_id' => $turf_id,
					'balance' => 0
				];
				$this->Common->insert('wallets',$wallet);
				
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Turf registration completed..!');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed..!');
			}
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Sorry..!');
		}
		redirect('owner/turfs');
	}
	
	public function updateSlotFee()
	{
		$ts_id = $this->security->xss_clean($this->input->post('ts_id'));
		$pitch_id = $this->security->xss_clean($this->input->post('pitch_id'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));
		$fees = $this->security->xss_clean($this->input->post('fees'));

		$tp_id = $this->Common->get_details('turf_pitches',array('turf_id' => $turf_id , 'pitch_id' => $pitch_id))->row()->tp_id;

		// Insert into turf_pitch_slot

		$array = [
			'tp_id' => $tp_id,
			'ts_id' => $ts_id
		];

		$check = $this->Common->get_details('turf_pitch_slot',$array);
		if ($check->num_rows() > 0) {
			$tsf_id = $check->row()->id;
			$i = 1;
			$check1 = $this->Common->get_details('turf_time_slot_fees',array('tsf_id' => $tsf_id));
			if ($check1->num_rows() == 7) {
				foreach ($fees as $fee) {
					$update = [
						'price' => $fee
					];
					$this->turf->updateFee($update,$tsf_id,$i);
					$i++;
				}
			}
			else {
				$i = 1;
				foreach ($fees as $fee) {
					$get = [
						'tsf_id' => $tsf_id,
						'day_id' => $i
					];
					$check2 = $this->Common->get_details('turf_time_slot_fees',$get)->num_rows();
					if ($check2 > 0) {
						$update = [
							'price' => $fee
						];
						$this->turf->updateFee($update,$tsf_id,$i);
					}
					else {
						$get['price'] = $fee;
						$this->Common->insert('turf_time_slot_fees',$get);
					}
					$i++;
				}
			}
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Fees updated..!');

			redirect('owner/turfs/details/'.$turf_id);
		}
		else {
			// Insert into turf_pitch_slot
			$tsf_id = $this->Common->insert('turf_pitch_slot',$array);
			$i = 1;
			foreach ($fees as $fee) {
				$insert = [
					'day_id' => $i,
					'price' => $fee,
					'tsf_id' => $tsf_id
				];
				$this->Common->insert('turf_time_slot_fees',$insert);
				$i++;
			}
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Fees updated..!');

			redirect('owner/turfs/details/'.$turf_id);
		}

	}

}
?>
