<?php

namespace Opencart\Admin\Controller\Extension\OcnCategoryWall\Module;

class OcnCategoryWall extends \Opencart\System\Engine\Controller
{
	public function index(): void
	{
		$this->load->language('extension/ocn_category_wall/module/ocn_category_wall');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [
			[
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
			],
			[
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
			],
			[
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/ocn_category_wall/module/ocn_category_wall', 'user_token=' . $this->session->data['user_token'])
			]
		];

		$data['save'] = $this->url->link('extension/ocn_category_wall/module/ocn_category_wall.save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['module_ocn_category_wall_status'] = $this->config->get('module_ocn_category_wall_status');
		$data['module_ocn_category_wall_description_status'] = $this->config->get('module_ocn_category_wall_description_status');
		$data['module_ocn_category_wall_subcategory_status'] = $this->config->get('module_ocn_category_wall_subcategory_status');

		if ($this->config->get('module_ocn_category_wall_image_width')) {
			$data['module_ocn_category_wall_image_width'] = $this->config->get('module_ocn_category_wall_image_width');
		} else {
			$data['module_ocn_category_wall_image_width'] = 80;
		}

		if ($this->config->get('module_ocn_category_wall_image_height')) {
			$data['module_ocn_category_wall_image_height'] = $this->config->get('module_ocn_category_wall_image_height');
		} else {
			$data['module_ocn_category_wall_image_height'] = 80;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/ocn_category_wall/module/ocn_category_wall', $data));
	}

	public function save(): void
	{
		$this->load->language('extension/ocn_category_wall/module/ocn_category_wall');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/ocn_category_wall/module/ocn_category_wall')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['module_ocn_category_wall_image_width'] || !$this->request->post['module_ocn_category_wall_image_height']) {
			$json['error']['image_category'] = $this->language->get('error_image_category');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('module_ocn_category_wall', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function install(): void
	{
		if ($this->user->hasPermission('modify', 'extension/module')) {
			$this->load->model('extension/ocn_category_wall/module/ocn_category_wall');

			$this->model_extension_ocn_category_wall_module_ocn_category_wall->install();

			$this->load->model('setting/setting');
			$data = [
				'module_ocn_category_wall_status' => 0,
				'module_ocn_category_wall_description_status' => 0,
				'module_ocn_category_wall_subcategory_status' => 0,
				'module_ocn_category_wall_image_width' => 240,
				'module_ocn_category_wall_image_height' => 240
			];
			$this->model_setting_setting->editSetting('module_ocn_category_wall', $data);
		}
	}

	public function uninstall(): void
	{
		if ($this->user->hasPermission('modify', 'extension/module')) {
			$this->load->model('extension/ocn_category_wall/module/ocn_category_wall');

			$this->model_extension_ocn_category_wall_module_ocn_category_wall->uninstall();
		}
	}
}
