<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_dashboard','dash');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		// $data['pending'] = $this->dash->bookingsPending();
		// $data['bookingThisMonth'] = $this->dash->bookingsThisMonth();
		// $data['turf'] = $this->dash->registeredTurfsCounts();
		// $data['users'] = $this->dash->registeredCustomers();
		// $data['expenseToday'] = $this->dash->todaysExpense();
		// $data['expenseMonthly'] = $this->dash->ExpenseThisMonth();

		// $data['customers'] = $this->dash->getUsers();
		// $data['feedbacks'] = $this->dash->latestFeedbacks();
		// $data['expenses'] = $this->dash->latestExpenses();
		// $data['online'] = $this->dash->onlineTransactions();

		// $data['turfs'] = $this->Common->get_details('turfs',array('register' => 'complete' , 'status' => 'a'))->result();

		$this->load->view('admin/dashboard/dashboard');
	}

	public function getDates()
	{
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
		$string = '<h4 class="header-title mb-4">SELECT DATE</h4>';

		foreach ($array as $arr) {
			$string = $string . '<button type="button" class="button btn btn-outline-primary waves-light waves-effect w-md" onclick="getPitches(' . $arr['day_id'] . ')" value="' . $arr['day_id'] . '" name="' . $arr['date'] . '" id="btn_' . $arr['day_id'] . '">' . $arr['month'] . '<br>' . $arr['day'] . '<br>' . $arr['weak'] . '</button>';
		}
		$return = [
			'string' => $string
		];

		print_r(json_encode($return));
	}

	public function getPitches()
	{
		$this->load->model('Android');
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));
		//$turf_id = 1;
		$pitches = $this->Android->getPitchesById($turf_id);

		$string = '<h4 class="header-title mb-4">SELECT PITCH</h4>';
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
		$string = '<h4 class="header-title mb-4">TIMESLOTS</h4>';
		$indications = '<div><ul class="class-ul inline"><li><i class="fa fa-square" style="color:red"></i><span style="color:black;">&nbsp;&nbsp;&nbsp;Booked&nbsp;&nbsp;</span></li><li><i class="fa fa-square" style="color:#6c757d"></i><span style="color:black;">&nbsp;&nbsp;&nbsp;Completed&nbsp;&nbsp;</span></li><li><i class="fa fa-square" style="color:#fff;border : 1px solid black;border-radius:5px;"></i><span style="color:black;">&nbsp;&nbsp;&nbsp;Available</span></li></ul></div><div class="clearfix"></div>';
		$string = $string . $indications;
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

}
?>
