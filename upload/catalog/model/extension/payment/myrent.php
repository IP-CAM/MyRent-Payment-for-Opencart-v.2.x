<?php
class ModelExtensionPaymentMyrent extends Model {
    public function getMethod($address, $total) {
        //debug($total);
       // die();
        $this->load->language('extension/payment/myrent');

  /*      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('cod_total') > 0 && $this->config->get('cod_total') > $total) {
            $status = false;
        } elseif (!$this->cart->hasShipping()) {
            $status = false;
        } elseif (!$this->config->get('cod_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();*/
$status=true;
        if ($status) {

            $method_data = array(
                'code'       => 'myrent',
                'title'      => "Моя платежная система (+{$this->config->get('myrent_int_rent')}%)",
                'terms'      => '',

                'sort_order' => $this->config->get('myrent_sort_order')
            );
        }

        return $method_data;
    }
}
