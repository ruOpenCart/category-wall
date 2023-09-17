<?php

namespace Opencart\Catalog\Controller\Extension\OcnCategoryWall\Module;

class CategoryWall extends \Opencart\System\Engine\Controller
{
	public function index(): string
	{
		$this->load->language('extension/ocn_category_wall/module/category_wall');

		if (isset($this->session->data['module_method'])) {
			$data['logged'] = $this->customer->isLogged();
			$data['subscription'] = $this->cart->hasSubscription();

			$data['months'] = [];

			foreach (range(1, 12) as $month) {
				$data['months'][] = date('m', mktime(0, 0, 0, $month, 1));
			}

			$data['years'] = [];

			foreach (range(date('Y'), date('Y', strtotime('+10 year'))) as $year) {
				$data['years'][] = $year;
			}

			$data['language'] = $this->config->get('config_language');

			return $this->load->view('extension/ocn_category_wall/module/category_wall', $data);
		}

		return '';
	}

	public function confirm(): void
	{
		$this->load->language('extension/ocn_category_wall/module/category_wall');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function stored(): void
	{
		$this->load->language('extension/ocn_category_wall/module/category_wall');

		$json = [];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void
	{
		$this->load->language('extension/ocn_category_wall/module/category_wall');

		$json = [];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
