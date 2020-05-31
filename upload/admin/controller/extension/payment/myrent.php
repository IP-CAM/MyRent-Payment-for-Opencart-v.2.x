<?php
class ControllerExtensionPaymentMyrent extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/myrent');

        $this->document->setTitle($this->language->get('title_rent'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {


            $this->model_setting_setting->editSetting('myrent', $this->request->post);
            $this->load->model('extension/extension');
            if($_POST['myrent_status']==1) {

                $this->model_extension_extension->install('total', 'myrent');
            }
            else{
                $this->model_extension_extension->uninstall('total', 'myrent');
            }
            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['help_total'] = $this->language->get('help_total');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/myrent', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/myrent', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

        /*if (isset($this->request->post['cod_total'])) {
            $data['cod_total'] = $this->request->post['cod_total'];
        } else {
            $data['cod_total'] = $this->config->get('cod_total');
        }*/

        if (isset($this->request->post['myrent_order_status_id'])) {
            $data['myrent_order_status_id'] = $this->request->post['myrent_order_status_id'];
        } else {
            $data['myrent_order_status_id'] = $this->config->get('myrent_order_status_id');
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['myrent_geo_zone_id'])) {
            $data['myrent_geo_zone_id'] = $this->request->post['myrent_geo_zone_id'];
        } else {
            $data['myrent_geo_zone_id'] = $this->config->get('myrent_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['myrent_status'])) {
            $data['myrent_status'] = $this->request->post['myrent_status'];
        } else {
            $data['myrent_status'] = $this->config->get('myrent_status');
        }

        if (isset($this->request->post['myrent_int_rent'])) {
            $data['myrent_int_rent'] = $this->request->post['myrent_int_rent'];
        } else {
            $data['myrent_int_rent'] = $this->config->get('myrent_int_rent');
        }
        if (isset($this->request->post['myrent_sort_order'])) {
            $data['myrent_sort_order'] = $this->request->post['myrent_sort_order'];
        } else {
            $data['myrent_sort_order'] = $this->config->get('myrent_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/myrent', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/cod')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}