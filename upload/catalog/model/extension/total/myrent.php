<?php
class ModelExtensionTotalMyrent extends Model {
    public function getTotal($total)
    {
        if (isset($this->session->data['payment_method'])) {
            if (($this->session->data['payment_method']['code'] == 'myrent') && $this->cart->hasShipping() && ($this->session->data['payment_method']['code'] == 'myrent')) {
                $f=$total['total']/100;
                $must=$f*$this->config->get('myrent_int_rent');
                $total['totals'][] = array(
                    'code' => 'myrent',
                    'title' => "За пользование моей платежной системой(+{$this->config->get('myrent_int_rent')}%)",
                    'value' => $must,
                    'sort_order' => $this->config->get('myrent_sort_order')
                );


                $total['total'] += $must;
            }
        }
    }
   /* public function getTotal($total) {

            $total['totals'][] = array(
                'code'       => 'myrent',
                'title'      => 'Procent za oplaty po rent',
                'value'      => $this->config->get('myrent_int_rent'),
                'sort_order' => $this->config->get('myrent_sort_order')
            );



            $total['total'] += $this->config->get('myrent_int_rent');
        }*/

}
