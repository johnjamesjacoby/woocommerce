<?php
/**
 * Order Line Item (coupon).
 *
 * @class 		WC_Order_Item_Coupon
 * @version		2.6.0
 * @since       2.6.0
 * @package		WooCommerce/Classes
 * @author 		WooThemes
 */
class WC_Order_Item_Coupon extends WC_Order_Item {

    /**
	 * Data properties of this order item object.
	 * @since 2.6.0
	 * @var array
	 */
    protected $data = array(
        'order_id'      => 0,
		'order_item_id' => 0,
        'code'          => '',
        'discount'      => 0,
        'discount_tax'  => 0,
    );

    /**
     * Read/populate data properties specific to this order item.
     */
    protected function read() {
        parent::read();
        if ( $this->get_order_item_id() ) {
            $this->set_discount( get_metadata( 'order_item', $this->get_order_item_id(), 'discount_amount', true ) );
            $this->set_discount_tax( get_metadata( 'order_item', $this->get_order_item_id(), 'discount_amount_tax', true ) );
        }
    }

    /**
     * Save properties specific to this order item.
     */
    protected function save() {
        parent::save();
        if ( $this->get_order_item_id() ) {
            wc_update_order_item_meta( $this->get_order_item_id(), 'discount_amount', $this->get_discount() );
            wc_update_order_item_meta( $this->get_order_item_id(), 'discount_amount_tax', $this->get_discount_tax() );
        }
    }

    /*
	|--------------------------------------------------------------------------
	| Setters
	|--------------------------------------------------------------------------
	*/

    /**
     * Set order item name.
     * @param string $value
     */
    public function set_order_item_name( $value ) {
        $this->data['code'] = wc_clean( $value );
    }

    /**
     * Set discount amount.
     * @param string $value
     */
    public function set_discount( $value ) {
        $this->data['discount'] =  wc_format_decimal( $value );
    }

    /**
     * Set discounted tax amount.
     * @param string $value
     */
    public function set_discount_tax( $value ) {
        $this->data['discount_tax'] = wc_format_decimal( $value );
    }

    /*
	|--------------------------------------------------------------------------
	| Getters
	|--------------------------------------------------------------------------
	*/

    /**
     * Get order item type.
     * @return string
     */
    public function get_order_item_type() {
        return 'coupon';
    }

    /**
     * Get order item name.
     * @return string
     */
    public function get_order_item_name() {
        return $this->data['code'];
    }

    /**
     * Get coupon code.
     * @return string
     */
    public function get_code() {
        return $this->get_order_item_name();
    }

    /**
     * Get discount amount.
     * @return string
     */
    public function get_discount() {
        return  wc_format_decimal( $this->data['discount'] );
    }

    /**
     * Get discounted tax amount.
     * @return string
     */
    public function get_discount_tax() {
        return  wc_format_decimal( $this->data['discount_tax'] );
    }
}