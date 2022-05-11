<?php

class Users extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Users';
		$this->load->model('model_users');
		$this->load->model('model_groups');
		$this->load->library('helper');
	}


	public function index()
	{
		if (!in_array('viewUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_data = $this->model_users->getUserData();

		$result = array();
		foreach ($user_data as $k => $v) {
			$result[$k]['user_info'] = $v;

			$group = $this->model_users->getUserGroup($v['id']);
			$result[$k]['user_group'] = $group;
		}

		$this->data['user_data'] = $result;

		$this->render_template('users/index', $this->data);
	}

	public function create()
	{
		if (!in_array('createUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('groups', 'Group', 'required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[24]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('fname', 'First name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$password = $this->password_hash($this->input->post('password'));
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $password,
				'email' => $this->input->post('email'),
				'firstname' => $this->input->post('fname'),
				'lastname' => $this->input->post('lname'),
				'number_gst' => $this->input->post('number_gst'),
				'commission_andersons' => $this->input->post('commission_andersons'),
				'commission_ess' => $this->input->post('commission_ess'),
				'phone' => $this->input->post('phone'),
			);

			$create = $this->model_users->create($data, $this->input->post('groups'));
			if ($create == true) {
				$this->session->set_flashdata('success', 'Successfully created');
				redirect('users/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('users/create', 'refresh');
			}
		} else {
			// false case
			$group_data = $this->model_groups->getGroupData();
			$this->data['group_data'] = $group_data;

			$this->render_template('users/create', $this->data);
		}
	}

	public function password_hash($pass = '')
	{
		if ($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function edit($id = null)
	{
		if (!in_array('updateUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			$this->form_validation->set_rules('groups', 'Group', 'required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');

			if ($this->form_validation->run() == TRUE) {
				// true case
				if (empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
					$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'firstname' => $this->input->post('fname'),
						'lastname' => $this->input->post('lname'),
						'number_gst' => $this->input->post('number_gst'),
						'commission_andersons' => $this->input->post('commission_andersons'),
						'commission_ess' => $this->input->post('commission_ess'),
						'phone' => $this->input->post('phone'),
					);

					$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
					if ($update == true) {
						$this->session->set_flashdata('success', 'Successfully created');
						redirect('users/', 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('users/edit/' . $id, 'refresh');
					}
				} else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if ($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
							'username' => $this->input->post('username'),
							'password' => $password,
							'email' => $this->input->post('email'),
							'firstname' => $this->input->post('fname'),
							'lastname' => $this->input->post('lname'),
							'number_gst' => $this->input->post('number_gst'),
							'commission_andersons' => $this->input->post('commission_andersons'),
							'commission_ess' => $this->input->post('commission_ess'),
							'phone' => $this->input->post('phone'),
						);

						$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
						if ($update == true) {
							$this->session->set_flashdata('success', 'Successfully updated');
							redirect('users/', 'refresh');
						} else {
							$this->session->set_flashdata('errors', 'Error occurred!!');
							redirect('users/edit/' . $id, 'refresh');
						}
					} else {
						// false case
						$user_data = $this->model_users->getUserData($id);
						$groups = $this->model_users->getUserGroup($id);

						$this->data['user_data'] = $user_data;
						$this->data['user_group'] = $groups;

						$group_data = $this->model_groups->getGroupData();
						$this->data['group_data'] = $group_data;

						$this->render_template('users/edit', $this->data);
					}
				}
			} else {
				// false case
				$user_data = $this->model_users->getUserData($id);
				$groups = $this->model_users->getUserGroup($id);

				$this->data['user_data'] = $user_data;
				$this->data['user_group'] = $groups;

				$group_data = $this->model_groups->getGroupData();
				$this->data['group_data'] = $group_data;

				$this->render_template('users/edit', $this->data);
			}
		}
	}

	public function delete()
	{
		if (!in_array('deleteUser', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$id = $this->input->post('user_id');
		if ($id) {
			$arr_check = $this->helper->parse_answer_links($this->model_users->exist_links($id));
			if ($arr_check) {
				$response['success'] = false;
				$response['messages'] = "This item has some links for " . $arr_check . ' cannot be removed now!';
			} else {
				$delete = $this->model_users->deactive($id);
				if ($delete == true) {
					$response['success'] = true;
					$response['messages'] = "Successfully removed";
				} else {
					$response['success'] = false;
					$response['messages'] = "Error in the database while removing the item";
				}
			}
		} else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}
		redirect('users/', 'refresh');
		echo json_encode($response);
	}

	public function profile()
	{
		if (!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$user_id = $this->session->userdata('id');

		$user_data = $this->model_users->getUserData($user_id);
		$this->data['user_data'] = $user_data;

		$user_group = $this->model_users->getUserGroup($user_id);
		$this->data['user_group'] = $user_group;

		$this->render_template('users/profile', $this->data);
	}

	public function setting()
	{
		if (!in_array('viewProfile', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->session->userdata('id');

		if ($id) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[64]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('fname', 'First name', 'trim|required');


			if ($this->form_validation->run() == TRUE) {
				// true case
				if (empty($this->input->post('password')) && empty($this->input->post('cpassword'))) {
					$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'firstname' => $this->input->post('fname'),
						'lastname' => $this->input->post('lname'),
						'phone' => $this->input->post('phone'),
					);

					$update = $this->model_users->edit($data, $id);
					if ($update == true) {
						$this->session->set_flashdata('success', 'Successfully updated');
						redirect('users/setting/', 'refresh');
					} else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('users/setting/', 'refresh');
					}
				} else {
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
					$this->form_validation->set_rules('cpassword', 'Confirm password', 'trim|required|matches[password]');

					if ($this->form_validation->run() == TRUE) {

						$password = $this->password_hash($this->input->post('password'));

						$data = array(
							'username' => $this->input->post('username'),
							'password' => $password,
							'email' => $this->input->post('email'),
							'firstname' => $this->input->post('fname'),
							'lastname' => $this->input->post('lname'),
							'phone' => $this->input->post('phone'),
						);

						$update = $this->model_users->edit($data, $id, $this->input->post('groups'));
						if ($update == true) {
							$this->session->set_flashdata('success', 'Successfully updated');
							redirect('users/setting/', 'refresh');
						} else {
							$this->session->set_flashdata('errors', 'Error occurred!!');
							redirect('users/setting/', 'refresh');
						}
					} else {
						// false case
						$user_data = $this->model_users->getUserData($id);
						$groups = $this->model_users->getUserGroup($id);

						$this->data['user_data'] = $user_data;
						$this->data['user_group'] = $groups;

						$group_data = $this->model_groups->getGroupData();
						$this->data['group_data'] = $group_data;

						$this->render_template('users/setting', $this->data);
					}
				}
			} else {
				// false case
				$user_data = $this->model_users->getUserData($id);
				$groups = $this->model_users->getUserGroup($id);

				$this->data['user_data'] = $user_data;
				$this->data['user_group'] = $groups;

				$group_data = $this->model_groups->getGroupData();
				$this->data['group_data'] = $group_data;

				$this->render_template('users/setting', $this->data);
			}
		}
	}
}
