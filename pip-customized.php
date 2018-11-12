<?php
/**
 * Filter the document table headers to add product unit price.
 *
 * @param string[] $headers table column headers
 * @param int $order_id the order ID for the document
 * @param string $document_type the current document type
 * @return string[] updated table headers
 */
function sv_wc_pip_add_unit_price_column( $headers, $order_id, $document_type ) {

	if ( 'packing-list' === $document_type ) {

		$new_headers = array();

		foreach ( $headers as $key => $header ) {

			if ( 'quantity' === $key ) {
				$new_headers['unit_price'] = __( 'EP', 'textdomain' );
				$new_headers['item total'] = __( 'GP', 'textdomain' );
			}

			$new_headers[ $key ] = $header;
		}

		unset( $new_headers['weight'] );
		unset( $new_headers['sku'] );
		$headers = $new_headers;
	}

	return $headers;
}
add_filter( 'wc_pip_document_table_headers', 'sv_wc_pip_add_unit_price_column', 10, 3 );


/**
 * Filter the document table row cells to add product unit price.
 *
 * @param string[] $cells the current table row cells
 * @param string $type WC_PIP_Document type
 * @param int $item_id item id
 * @param string[] $item item data
 * @param \WC_Product $product product object
 * @return string[] updated row cells
 */
function sv_wc_pip_document_add_unit_price_cell( $cells, $document_type, $item_id, $item, $product ) {

	if ( 'packing-list' === $document_type ) {

		$new_cells = array();

		foreach ( $cells as $key => $cell ) {

			if ( 'quantity' === $key ) {
				$new_cells['unit_price'] = wc_price( $product->get_price() );
				$new_cells['item_total'] = wc_price( ($item->get_quantity()*$product->get_price()) ); 
			}

			$new_cells[ $key ] = $cell;
		}

		unset( $new_cells['weight'] );
		unset( $new_cells['sku'] );
		$cells = $new_cells;
	}

	return $cells;
}
add_filter( 'wc_pip_document_table_row_cells', 'sv_wc_pip_document_add_unit_price_cell', 10, 5 );

?>
