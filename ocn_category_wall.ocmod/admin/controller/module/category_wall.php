<?php

namespace Opencart\Admin\Controller\Extension\OcnCategoryWall\Module;

class CategoryWall extends \Opencart\System\Engine\Controller
{
	public function index(): void
	{
		$this->load->language('extension/ocn_category_wall/module/category_wall');

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
				'href' => $this->url->link('extension/ocn_category_wall/module/category_wall', 'user_token=' . $this->session->data['user_token'])
			]
		];

		$data['save'] = $this->url->link('extension/ocn_category_wall/module/category_wall.save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['module_category_wall_status'] = $this->config->get('module_category_wall_status');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/ocn_category_wall/module/category_wall', $data));
	}

	public function save(): void
	{
		$this->load->language('extension/ocn_category_wall/module/category_wall');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/ocn_category_wall/module/category_wall')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('module_category_wall', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function install(): void
	{
		if ($this->user->hasPermission('modify', 'extension/module')) {
			$this->load->model('extension/ocn_category_wall/module/category_wall');

			$this->model_extension_ocn_category_wall_module_category_wall->install();
		}
	}

	public function uninstall(): void
	{
		if ($this->user->hasPermission('modify', 'extension/module')) {
			$this->load->model('extension/ocn_category_wall/module/category_wall');

			$this->model_extension_ocn_category_wall_module_category_wall->uninstall();
		}
	}
}
