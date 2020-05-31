<?php
class ControllerExtensionPaymentMyrent extends Controller {
    public function index() {
        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['text_loading'] = $this->language->get('text_loading');

        $data['continue'] = $this->url->link('checkout/success');
  debug($this->session->data['order_id']);
        return $this->load->view('extension/payment/myrent', $data);
    }

    public function confirm() {
        if ($this->session->data['payment_method']['code'] == 'myrent') {
            $this->load->model('checkout/order');

            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('myrent_order_status_id'));
        }
    }
}
