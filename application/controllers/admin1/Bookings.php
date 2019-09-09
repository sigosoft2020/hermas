<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Upcoming','up');
			$this->load->model('Completed','completed');
			$this->load->model('Cancelled','cancelled');
			$this->load->model('M_booking','booking');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function upcoming()
	{
		$this->load->view('admin/bookings/upcoming');
	}
	public function getUpcoming()
	{
		$result = $this->up->make_datatables();
		$data = array();

		$now = date("Y-m-d H:i:s");

		$refund = $this->Common->get_details('refund_policy',array('id' => 1))->row();
		$refund_time = (int)$refund->hours;

		$start = new DateTime($now);
		foreach ($result as $res) {
			//Check whether cancellation possible or not
			// $cancel = '<button class="btn btn-link" onclick="cancelBooking(' . $res->book_id . ')"><span style="color:red;">Cancel</span></button>';
			// $book_time = $res->from_time;
			// $diff = $start->diff(new DateTime($book_time));
			// $difference = (int)$diff->h;
			// if ($difference < $refund_time) {
			// 	$cancel = "You can cancel a booking only before " . $refund_time . " hours from play time";
			// }

			if ($res->booked_by != 'user') {
				$cancel = '<button class="btn btn-sm btn-danger" onclick="cancelBooking(' . $res->book_id . ')">Cancel</button>';
			}
			else {
				$cancel = '<button class="btn btn-sm btn-danger" onclick="cancelOnlineBooking(' . $res->book_id . ')">Cancel<br>online<br>booking</button>';
			}

			$date = date('d/m/Y',strtotime($res->date));

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = $res->payment_type;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';
			$sub_array[] = $cancel;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->up->get_all_data(),
			"recordsFiltered" => $this->up->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function completed()
	{
		$this->load->view('admin/bookings/completed');
	}
	public function getCompleted()
	{
		$result = $this->completed->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$date = date('d/m/Y',strtotime($res->date));

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = $res->payment_type;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';
			if ($res->booking_status == 'completed') {
				$sub_array[] = '<button class="btn btn-link" style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></button>';
			}
			else {
				if ($res->booked_by != 'user') {
					$sub_array[] = '<button class="btn btn-success btn-sm btn-rounded waves-light waves-effect" onclick="complete(' . $res->book_id . ')" style="font-size:11px;">Complete</button>
													<button class="btn btn-danger btn-sm btn-rounded waves-light waves-effect" onclick="cancel(' . $res->book_id . ')" style="font-size:11px;margin-top:5px;">Cancel</button>
												 ';
				}
				else {
					$sub_array[] = '<button class="btn btn-success btn-sm btn-rounded waves-light waves-effect" onclick="complete(' . $res->book_id . ')" style="font-size:11px;">Complete</button>
													<button class="btn btn-danger btn-sm btn-rounded waves-light waves-effect" onclick="cancelOnlineBooking(' . $res->book_id . ')" style="font-size:11px;margin-top:5px;">Cancel<br>online<br>booking</button>
												 ';
				}
			}

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->completed->get_all_data(),
			"recordsFiltered" => $this->completed->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function cancelled()
	{
		$this->load->view('admin/bookings/cancelled');
	}
	public function getCancelled()
	{
		$result = $this->cancelled->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$date = date('d/m/Y',strtotime($res->date));

			if ($res->status == 'processing') {
				if ($res->type != 'online') {
					$refund = '<button class="btn btn-sm btn-success" onclick="refund(' . $res->book_id . ')">Refund</button>';
				}
				else {
					$refund = '<button class="btn btn-sm btn-secondary" onclick="refundOnline(' . $res->book_id . ')">Refund<br>Online<br>Booking</button>';
				}
			}
			else {
				$refund = '<button class="btn btn-link" style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></button>';
			}

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = $res->payment_type;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('admin/bookings/details_cancelled/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';
			$sub_array[] = $refund;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->cancelled->get_all_data(),
			"recordsFiltered" => $this->cancelled->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function check()
	{
		$today = date('Y-m-d H:i:s');
		$test = $this->up->check($today);

		//print_r(json_encode($test));
		echo $today;
	}

	public function details($book_id)
	{
		$book = $this->Common->get_details('bookings',array('book_id' => $book_id))->row();
		$data['turf'] = $this->Common->get_details('turfs',array('turf_id' => $book->turf_id))->row();
		if ($book->voucher_status == '1') {
			$data['voucher'] = $this->Common->get_details('voucher_apply',array('book_id' => $book_id))->row()->code;
		}
		else {
			$data['voucher'] = false;
		}
		$data['user'] = $this->Common->get_details('users',array('user_id' => $book->user_id))->row();
		$data['book'] = $book;

		$this->load->view('admin/bookings/details',$data);
	}

	public function details_cancelled($book_id)
	{
		$book = $this->Common->get_details('bookings',array('book_id' => $book_id))->row();
		$data['turf'] = $this->Common->get_details('turfs',array('turf_id' => $book->turf_id))->row();
		if ($book->voucher_status == '1') {
			$data['voucher'] = $this->Common->get_details('voucher_apply',array('book_id' => $book_id))->row()->code;
		}
		else {
			$data['voucher'] = false;
		}
		$data['user'] = $this->Common->get_details('users',array('user_id' => $book->user_id))->row();
		$data['book'] = $book;
		$data['cancel'] = $this->Common->get_details('cancellation',array('booking_id' => $book_id))->row();

		$this->load->view('admin/bookings/details_cancelled',$data);
	}

	// ------------------------------ ADD BOOKING --------------------------------- //

	public function add()
	{
		$data['users'] = $this->Common->get_details('users',array('status' => 'a'))->result();
		$data['turfs'] = $this->Common->get_details('turfs',array('register' => 'complete' , 'status' => 'a'))->result();
		//$data['dates'] = $this->getDates();
		$this->load->view('admin/bookings/add',$data);
		//print_r($data['users']);
	}

	public function getDates()
	{
		$turf_id = $this->input->post('turf_id');
		$get = $this->Common->get_details('booking_percentage',array('turf_id' => $turf_id));
		if ($get->num_rows() > 0) {
			$percentage = $get->row()->percentage;
		}
		else {
			$percentage = 100;
		}

		$from = date('Y-m-d');

		$date = strtotime($from);
		$last = strtotime("+6 day", $date);

		$to = date('Y-m-d',$last);
		$format ="Y-m-d";
		$array = array();

    $interval = new DateInterval('P1D');
    $realEnd = new DateTime($to);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($from), $interval, $realEnd);

    foreach($period as $date) {
        $dt = $date->format($format);
				$arr = [
					'date' => $dt,
					'year' => date('Y',strtotime($dt)),
					'month' => date('F',strtotime($dt)),
					'day' => date('d',strtotime($dt)),
					'weak' => date('D',strtotime($dt))
				];
				switch ($arr['weak']) {
					case 'Sun': $id = 1;break;
					case 'Mon': $id = 2;break;
					case 'Tue': $id = 3;break;
					case 'Wed': $id = 4;break;
					case 'Thu': $id = 5;break;
					case 'Fri': $id = 6;break;
					case 'Sat': $id = 7;break;
				}
				$arr['day_id'] = $id;
				array_push($array,$arr);
    }
		$string = "<p><h5>SELECT DATE</h5></p>";

		foreach ($array as $arr) {
			$string = $string . '<button type="button" class="button btn btn-outline-primary waves-light waves-effect w-md" onclick="getPitches(' . $arr['day_id'] . ')" value="' . $arr['day_id'] . '" name="' . $arr['date'] . '" id="btn_' . $arr['day_id'] . '">' . $arr['month'] . '<br>' . $arr['day'] . '<br>' . $arr['weak'] . '</button>';
		}
		$return = [
			'string' => $string,
			'percentage' => $percentage
		];

		print_r(json_encode($return));
	}

	public function getPitches()
	{
		$this->load->model('Android');
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));
		//$turf_id = 1;
		$pitches = $this->Android->getPitchesById($turf_id);

		$string = "<p><h5>SELECT PITCH</h5></p>";
		foreach ($pitches as $pitch) {
			$string = $string . '<button type="button" class="btn btn-outline-primary waves-light waves-effect w-md button-pitch" onclick="getSlots(' . $pitch->pitch_id . ')" id="pitch_' . $pitch->pitch_id . '" name="' . $pitch->tp_id . '">' . $pitch->pitch . '</button>';
		}

		print_r(json_encode($string));
	}

	public function getTimeSlots()
	{
		$this->load->model('Android');

		$date = $this->security->xss_clean($this->input->post('date'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

		$tp_id = $this->security->xss_clean($this->input->post('tp_id'));

		// $date = "2019-07-17";
		// $turf_id = 1;
		// $tp_id = 1;

		$slots = $this->Android->getTimeSlots($turf_id);
		$today = date('Y-m-d H:i:s');
		// Check whether slot is available or not

		$pitch = $this->Common->get_details('turf_pitches',array('tp_id' => $tp_id))->row();
		$pitch_id = $pitch->pitch_id;
		$pitch_count = $pitch->pitch_count;

		foreach ($slots as $slot) {
			$from = $date . " " . $slot->ft;
			if (strtotime($today) > strtotime($from)) {
				$slot->status = false;
				$slot->recent = true;
			}
			else {
			    $slot->recent = false;
				$book = $this->Android->getBookings($from,$turf_id,$date);

				if ($book->num_rows() > 0) {
					if ($pitch_id == '1') {
						if ($book->num_rows() > 0) {
							$slot->status = false;
						}
						else {
							$slot->status = true;
						}
					}
					elseif($pitch_id == '2') {
						$flag = true;
						$pitch7x7 = 0;
						$pitch5x5 = 0;
						$bookings = $book->result();
						foreach ($bookings as $bk) {
							if ($bk->pitch_id == '1'){
								$slot->status = false;
								$flag = false;
								break;
							}
							elseif($bk->pitch_id == '2'){
								$pitch7x7++;
							}
							elseif($bk->pitch_id == '3'){
								$pitch5x5++;
							}
						}
						if ($flag) {
							if ($pitch_count == 1) {
								if ($pitch7x7 == 0) {
									if ($pitch5x5 > 0) {
										$slot->status = false;
									}
									else {
										$slot->status = true;
									}
								}
								elseif ($pitch7x7 == 1) {
									$slot->status = false;
								}
							}
							else {
								if ($pitch7x7 == 0) {
									if ($pitch5x5 > 2) {
										$slot->status = false;
									}
									else {
										$slot->status = true;
									}
								}
								elseif ($pitch7x7 == 1) {
									if ($pitch5x5 > 0) {
										$slot->status = false;
									}
									else {
										$slot->status = true;
									}
								}
							}
						}
					}
					elseif ($pitch_id == '3') {
						$flag = true;
						$pitch7x7 = 0;
						$pitch5x5 = 0;
						$bookings = $book->result();
						foreach ($bookings as $bk) {
							if ($bk->pitch_id == '1'){
								$slot->status = false;
								$flag = false;
								break;
							}
							elseif($bk->pitch_id == '2'){
								$pitch7x7++;
							}
							elseif($bk->pitch_id == '3'){
								$pitch5x5++;
							}
						}

						if ($flag) {
							if ($pitch_count == 1) {
								if ($pitch5x5 == 1 || $pitch7x7 == 1) {
									$slot->status = false;
								}
								else {
									$slot->status = true;
								}
							}
							elseif ($pitch_count == 2) {
								if ($pitch7x7 == 0) {
									if ($pitch5x5 < 2) {
										$slot->status = true;
									}
									else {
										$slot->status = false;
									}
								}
								else {
									$slot->status = false;
								}
							}
							elseif ($pitch_count == 3) {
								if ($pitch7x7 == 0) {
									if ($pitch5x5 < 3) {
										$slot->status = true;
									}
									else {
										$slot->status = false;
									}
								}
								elseif($pitch7x7 == 1) {
									if ($pitch5x5 == 0) {
										$slot->status = true;
									}
									else {
										$slot->status = false;
									}
								}
								else {
									$slot->status = false;
								}
							}
							elseif ($pitch_count == 4) {
								if ($pitch7x7 == 0) {
									if ($pitch5x5 < 4) {
										$slot->status = true;
									}
									else {
										$slot->status = false;
									}
								}
								elseif($pitch7x7 == 1) {
									if ($pitch5x5 < 2) {
										$slot->status = true;
									}
									else {
										$slot->status = false;
									}
								}
								else {
									$slot->status = false;
								}
							}

						}
					}
				}
				else {
					$slot->status = true;
				}
			}
		}

		$length = count($slots);
		$step = 1;
		$my_array = [];
		for ($i=0; $i < $length ; $i++) {
			if ($i == $length-1) {
				$id = $step;
			}
			else {
				$diff = strtotime($slots[$i+1]->from_time) - strtotime($slots[$i]->to_time);
				if ( $diff == 0 ) {
					$id = $step;
				}
				else {
					$id = $step;
					$step++;
				}
			}
			$step++;

			$my_array[] = $id;
		}

		$i=0;
		$string = "<p><h5>SELECT SLOT</h5></p>";
		foreach ($slots as $slot) {
			$id = $my_array[$i];

			if ($slot->status) {
				$string = $string . '<button type="button" class="button-slot btn btn-outline-primary waves-light waves-effect w-md" onclick="setSlots(' . $id . ')" id="slot_' . $id . '" value="' . $slot->ts_id . '">' . $slot->from_time . " -<br>" . $slot->to_time . '</button>';
			}
			else {
				if ($slot->recent) {
					$string = $string . '<button type="button" class="button-slot btn btn-secondary" value="' . $id . '" disabled>' . $slot->from_time . " -<br>" . $slot->to_time . '</button>';
				}
				else {
					$string = $string . '<button type="button" class="button-slot btn btn-danger" value="' . $id . '" disabled>' . $slot->from_time . " -<br>" . $slot->to_time . '</button>';
				}
			}

			$i++;
		}

		print_r(json_encode($string));
	}

	public function getTotalFee()
	{
		$ts_ids = $this->security->xss_clean($this->input->post('ts_ids'));
		$tp_id = $this->security->xss_clean($this->input->post('tp_id'));
		$day_id = $this->security->xss_clean($this->input->post('day_id'));
		$date = $this->security->xss_clean($this->input->post('date'));

		$totalFee = 0;

    $slots = json_decode($ts_ids,true);
		$array = array();
		$i = 0;
    foreach($slots as $slot)
    {
    	$get = $this->booking->getTurfFee($slot,$tp_id,$day_id);
			$row = $get->row();

			$array[$row->slot_id] = $row;
			if ($i == 0) {
				$start = $row->slot_id;
			}
    	$totalFee = $totalFee + $row->price;
			$end = $row->slot_id;
			$i++;
    }

		$slot_name = $array[$start]->from_time . " - " . $array[$end]->to_time;
		$from = $date . " " . $array[$start]->ft;
		if ($array[$end]->slot_id == 24) {
			$new_date = date('Y-m-d', strtotime( $date . ' +1 day'));
			$to = $new_date . " " . $array[$end]->tt;
		}
		else {
			$to = $date . " " . $array[$end]->tt;
		}

		$return = [
			'fee' => $totalFee,
			'slot' => $slot_name,
			'from' => $from,
			'to' => $to
		];

		print_r(json_encode($return));
	}

	public function addBooking()
	{
		$this->load->model('Android');
		//$ts_id = $this->security->xss_clean($this->input->post('ts_id'));
		$tp_id = $this->security->xss_clean($this->input->post('tp_id'));

		// Get turf name of turf , pitch name , time slot

		$get = $this->Android->getDatasNew($tp_id);

		if ($get->num_rows() > 0) {
			$data = $get->row();

			$id = $this->security->xss_clean($this->input->post('user_id'));
			$from_time = $this->security->xss_clean($this->input->post('from_time'));
			$to_time = $this->security->xss_clean($this->input->post('to_time'));

			$turf_id = $this->security->xss_clean($this->input->post('turf_id'));
			$date = $this->security->xss_clean($this->input->post('date'));
			$today = date('Y-m-d');
			$time = date('h:i A');
			$turf_name = $data->turf_name;
			$slot = $this->security->xss_clean($this->input->post('slot'));
			$pitch = $data->pitch;
			$pitch_id = $data->pitch_id;

			//$day_id = $this->security->xss_clean($this->input->post('day_id'));
			$rate = $this->security->xss_clean($this->input->post('rate'));
			$payment_type = 'cod';
			$cash_recieved = $this->security->xss_clean($this->input->post('cash_recieved'));
			$payment_id = 0;
			$booking_status = 'placed';

			$subtotal = $rate;
			$voucher_status = '0';
			$voucher_amount = 0;

			// Booking table details

			$array = [
				'user_id' => $id,
				'turf_id' => $turf_id,
				'turf_name' => $turf_name,
				'slot' => $slot,
				'pitch' => $pitch,
				'pitch_id' => $pitch_id,
				'tp_id' => $tp_id,
				'date' => $date,
				'from_time' => $from_time,
				'to_time' => $to_time,
				'rate' => $rate,
				'voucher_status' => $voucher_status,
				'voucher_amount' => $voucher_amount,
				'subtotal' => $subtotal,
				'payment_type' => $payment_type,
				'cash_recieved' => $cash_recieved,
				'cash_received_cod' => $cash_recieved,
				'payment_id' => $payment_id,
				'booking_status' => $booking_status,
				'booked_date' => $today,
				'booked_time' => $time,
				'booked_by' => 'admin'
			];

			// Insert booking details in database.

			if ($book_id = $this->Common->insert('bookings',$array)) {
			    
			    $this->sendMessageToCustomer($id,$date,$slot,$pitch,$turf_name);
			    
			    $payment = [
			        'amount' => $cash_recieved,
			        'date' => date('Y-m-d'),
			        'time' => date('h:i A'),
			        'type' => 'cod',
			        'booking_id' => $book_id,
			    ];
			    $this->Common->insert('booking_payments',$payment);
			    
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Booking added..!');

				redirect('admin/bookings/upcoming');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to add booking..!');

				redirect('admin/bookings/upcoming');
			}
		}
		else {
			redirect('admin/bookings/add');
		}
	}
	
	public function sendMessageToCustomer($user_id,$date,$slot,$pitch,$turf_name)
	{
		$get = $this->Common->get_details('users',array('user_id' => $user_id));
		if ($get->num_rows() > 0) {
			$user = $get->row();

			$mobile = $user->mobile;
			$message = 'Your booking has been placed successfully for ' . $turf_name . ' on ' . $date . ' at ' . $slot . ' in ' . $pitch . ', Thank you.';

			$resp = file_get_contents("https://api.msg91.com/api/sendhttp.php?mobiles=" . $mobile . "&authkey=285266AO1ZbjJFO5d2c4fdb&route=4&sender=WOOSLT&message=" . $message . "&country=91");
		}
		return true;
	}

	public function getBookingDetails()
	{
		$book_id = $this->security->xss_clean($this->input->post('book_id'));

		$booking = $this->booking->getBookingDetails($book_id);

		$details = '<h5 style="color:#66b388;">' . $booking->username . '</h5><h6>Mobile : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->mobile . '</span></h6><h6>Turf : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->turf_name . '</span> , Pitch : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->pitch . '</span> , Slot : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->slot . '</span></h6>';

		$data = [
			'details' => $details,
			'cash_received' => $booking->cash_recieved
		];

		print_r(json_encode($data));
	}

	public function getBookingDetailsCancelled()
	{
		$book_id = $this->security->xss_clean($this->input->post('book_id'));

		$booking = $this->booking->getBookingDetails($book_id);

		$details = '<h5 style="color:#66b388;">' . $booking->username . '</h5><h6>Mobile : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->mobile . '</span></h6><h6>Turf : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->turf_name . '</span> , Pitch : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->pitch . '</span> , Slot : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->slot . '</span></h6>';

		$data = [
			'details' => $details,
			'cash_received' => $booking->cash_recieved,
			'payment_id' => $booking->payment_id
		];

		print_r(json_encode($data));
	}

	public function cancelBooking()
	{
		$book_id = $this->security->xss_clean($this->input->post('book_id'));
		$reason = $this->security->xss_clean($this->input->post('reason'));
		$status = $this->security->xss_clean($this->input->post('status'));

		$booking = $this->booking->getBookingDetails($book_id);

		if ($status == 'refunded') {
			$refunded_by = 'Admin';
		}
		else {
			$refunded_by = '';
		}

		$array = [
			'reason' => $reason,
			'cancelled_by' => 'admin',
			'amount' => $booking->cash_recieved,
			'refund_percent' => 0,
			'refund_amount' => $booking->cash_recieved,
			'booking_id' => $book_id,
			'payment_id' => 0,
			'user_id' => $booking->user_id,
			'date' => date('Y-m-d'),
			'time' => date('h:i A'),
			'status' => $status,
			'refunded_by' => $refunded_by
		];

		if ($this->Common->insert('cancellation',$array)) {
			$this->Common->update('book_id',$book_id,'bookings',array('booking_status' => 'cancelled'));

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Booking cancelled successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to cancel booking..!');
		}
		redirect('admin/bookings/cancelled');
	}

	public function refund()
	{
		$book_id = $this->security->xss_clean($this->input->post('book_id'));

		$array = [
			'status' => 'refunded'
		];

		if ($this->Common->update('booking_id',$book_id,'cancellation',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Refund entry added..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add refund entry..!');
		}

		redirect('admin/bookings/cancelled');
	}
	public function addCustomer()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$password = $this->security->xss_clean($this->input->post('password'));

		$image = $this->input->post('image');
		if ($image != '') {
			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/profile/';
			$rand = $username . date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/profile/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));
		}
		else {
			$path = "uploads/profile/user.png";
		}

		$array = [
			'username' => $username,
			'email' => $email,
			'mobile' => $mobile,
			'password' => md5($password),
			'auth' => $this->getKey(),
			'image' => $path
		];

		if ($this->Common->insert('users',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New customer added successfully..!');

			redirect('admin/bookings/add');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add customer..!');

			redirect('admin/bookings/add');
		}
	}

	function getKey() {
		while (true) {
			$key = $this->key();
			$cond = [
				'auth' => $key
			];

			$check = $this->Common->get_details('users',$cond);

			if ($check->num_rows() == 0) {
				break;
			}
		}
		return $key;
    }

	function key()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
		return $randomString;
	}
	
	// COMPLETE BOOKINGS
	
	public function getBookingDetailsCompleted()
	{
		$book_id = $this->security->xss_clean($this->input->post('book_id'));

		$booking = $this->booking->getBookingDetails($book_id);

		$details = '<h5 style="color:#66b388;">' . $booking->username . '</h5><h6>Mobile : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->mobile . '</span></h6><h6>Turf : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->turf_name . '</span> , Pitch : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->pitch . '</span> , Slot : <span style="font-size:14px;font-decoration:none;color:#66b388;">' . $booking->slot . '</span></h6>';

		$subtotal = $booking->subtotal;
		$received = $booking->cash_recieved;

		$balance = $subtotal - $received;

		$data = [
			'details' => $details,
			'subtotal' => $booking->subtotal,
			'cash_received' => $booking->cash_recieved,
			'balance' => $balance
		];

		print_r(json_encode($data));
	}

	public function completeBooking()
	{
		$book_id = $this->security->xss_clean($this->input->post('book_id'));
		$amount = $this->security->xss_clean($this->input->post('amount_paid'));
		if ($amount == 0) {
			$array = [
				'completed_by' => 'admin',
				'booking_status' => 'completed'
			];
			$this->Common->update('book_id',$book_id,'bookings',$array);
		}
		else {
			$booking = $this->Common->get_details('bookings',array('book_id' => $book_id))->row();
			$cash_received_cod = $booking->cash_received_cod;
			$cash_recieved = $booking->cash_recieved;

			$cash_received_cod = $cash_received_cod + $amount;
			$cash_recieved = $cash_recieved + $amount;

			$array = [
				'completed_by' => 'admin',
				'booking_status' => 'completed',
				'cash_received_cod' => $cash_received_cod,
				'cash_recieved' => $cash_recieved
			];

			$this->Common->update('book_id',$book_id,'bookings',$array);

			$payment = [
    		'amount' => $amount,
    		'date' => date('Y-m-d'),
    		'time' => date('h:i A'),
    		'type' => 'cod',
    		'booking_id' => $book_id,
			];
    	$this->Common->insert('booking_payments',$payment);
		}

		$this->session->set_flashdata('alert_type', 'success');
		$this->session->set_flashdata('alert_title', 'Success');
		$this->session->set_flashdata('alert_message', 'Booking completed successfully..!');

		redirect('admin/bookings/completed');
	}
	
	// CANCEL ONLINE BOOKING
	
	public function cancelOnlineBooking()
	{
		$book_id = $this->security->xss_clean($this->input->post('book_id'));
		$reason = $this->security->xss_clean($this->input->post('reason'));
		$status = 'processing';

		$booking = $this->booking->getBookingDetails($book_id);
		$refund = $this->Common->get_details('refund_policy',array('id' => 1))->row();
		$refund_amount = ($subtotal * $refund->percentage)/100;

		$array = [
			'reason' => $reason,
			'type' => 'online',
			'cancelled_by' => 'user',
			'amount' => $booking->cash_recieved,
			'refund_percent' => $refund->percentage,
			'refund_amount' => $refund_amount,
			'booking_id' => $book_id,
			'payment_id' => $booking->payment_id,
			'user_id' => $booking->user_id,
			'date' => date('Y-m-d'),
			'time' => date('h:i A'),
			'status' => $status
		];

		if ($this->Common->insert('cancellation',$array)) {
			$this->Common->update('book_id',$book_id,'bookings',array('booking_status' => 'cancelled'));

			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Booking cancelled successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to cancel booking..!');
		}
		redirect('admin/bookings/cancelled');
	}
	
	public function refundAmount()
	{
		$payment_id = '253966348';
		$amount = 1;
		$url = 'https://test.payumoney.com/treasury/merchant/refundPayment?merchantKey=RWDxJPVn&paymentId=' . $payment_id . '&refundAmount=' . $amount;

        $curl = curl_init($url);
    
    	curl_setopt($curl, CURLOPT_HTTPSHEADER, array(
          'Authorization: XPC88f957nguGn+sN+JnQwjd9AxEN2D8TMs2HupuYjc=',
          'Content-Type: application/json',
          'Cache-Control: no-cache',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);

		print_r($response);
	}
}
?>
