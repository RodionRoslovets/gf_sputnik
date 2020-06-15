<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');
		
		//$data['action'] = $this->url->link('information/contact', '', true);
		
		$formcreator = new formcreator($this->registry); 
		$data['formcreator_id49'] = $formcreator->initFeedback(49);

		$formcreator1 = new formcreator($this->registry);
		$data['formcreator_id50'] = $formcreator1->initFeedback(50);

		$formcreator = new formcreator($this->registry); 
		$data['formcreator_id53'] = $formcreator->initFeedback(53);
		
		$data['footer_top'] = $this->load->controller('common/footer_top');
		$data['footer_right'] = $this->load->controller('common/footer_right');
		$data['footer_bottom'] = $this->load->controller('common/footer_bottom');
		$data['footer_left'] = $this->load->controller('common/footer_left');
		
		$data['footer_address'] = nl2br($this->config->get('config_address'));

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['tracking'] = $this->url->link('information/tracking');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/login', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['copyright'] = sprintf($this->language->get('copyright'), $this->config->get('config_name'), date('Y', time()));
        $data['text_powered'] = sprintf($this->language->get('text_powered'));
		
		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = ($this->request->server['HTTPS'] ? 'https://' : 'http://') . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		$data['scripts'] = $this->document->getScripts('footer');
		
		return $this->load->view('common/footer', $data);
	}
}
