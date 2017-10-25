<?php 

/**
 * Get a list of client companies.
 *
 * @since    1.0.0
 */
function invoice_app_get_clients(){
    global $wpdb;

    $result = $wpdb->get_results("SELECT DISTINCT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'client_company' ORDER BY meta_key");
    return $result;

}

/**
 * Get most recent invoice.
 *
 * @since    1.0.0
 * @todo better to just save previous invoice in a transient?
 */
function invoice_app_get_previous_invoice(){

    global $wpdb;
    $sql = "SELECT MAX(meta_value) AS previous_invoice_number, 
			ID AS most_recent_invoice  
            FROM {$wpdb->prefix}posts 
            FULL JOIN {$wpdb->prefix}postmeta pinvoice 
            ON pinvoice.post_id = ID AND pinvoice.meta_key = 'invoice_number'";
    $result = $wpdb->get_row($sql);
    return $result;

}

/**
 * Get invoice details by id.
 *
 * @since    1.0.0
 */
function invoice_app_get_invoice_by_id($post_id){
    global $wpdb;
    //get where 
    $sql = "SELECT AS invoice_client,
            pinvoicemeta.post_id AS invoice_meta,
            FROM {$wpdb->prefix}posts
            LEFT JOIN {$wpdb->prefix}postmeta pinvoicemeta
            ON pinvoicemeta.post_id = $post_id AND pclient.meta_key = 'client_company'
            WHERE post_type = 'invoice_app_clients' AND post_status = 'publish'";
 
    $result = $wpdb->get_results($sql);
    return $result;
}

/**
 * Get client details by name.
 *
 * @since    1.0.0
 */
function invoice_app_get_client_details_by_name($name){
    $name = esc_html($name);

    global $wpdb;
    $sql = "SELECT post_id 
            FROM {$wpdb->prefix}postmeta
            WHERE meta_key = 'client_company' AND meta_value LIKE %s";
 
    $result = $wpdb->get_var($wpdb->prepare($sql, $name));
    $postMeta = get_post_meta($result);

    return $postMeta;
}

/**
 * Look for duplicate Invoice numbers.
 *
 * @since    1.0.0
 */
/*function invoice_app_does_invoice_number_exist($newNumber){
    $num = intval($newNumber);

    global $wpdb;
    $sql = "SELECT ID AS most_recent_invoice, 
            meta_value AS dupes 
            FROM {$wpdb->prefix}posts 
            FULL JOIN {$wpdb->prefix}postmeta pinvoice 
            ON pinvoice.post_id = ID AND pinvoice.meta_key = 'invoice_number' AND pinvoice.meta_value = $num";
 
    $result = $wpdb->get_results($sql);
    return $result;
}*/

/**
 * Finds and totals all overdue invoices
 *
 * @since 1.0
 */
function invoice_app_overdue_invoices(){

    global $wpdb;

    $sql = "SELECT ID AS pID, 
            pinvoicedate.meta_value AS due_date,
            pinvoiceprice.meta_value AS invoice_amount
            FROM {$wpdb->prefix}posts
            LEFT JOIN {$wpdb->prefix}postmeta pinvoicedate 
            ON pinvoicedate.post_id = ID AND pinvoicedate.meta_key = 'invoice_due_date'
            RIGHT JOIN {$wpdb->prefix}postmeta pinvoiceprice
            ON pinvoiceprice.post_id = ID AND pinvoiceprice.meta_key = 'invoice_line_items_total'
            WHERE post_type = 'invoice_app_invoices' AND post_status = 'publish'";
 
    $results = $wpdb->get_results($sql);    

    $overdue_total = '0';

    foreach($results as $invoice) {
        if($invoice->due_date != '' && strtotime(date('m/d/Y')) >= strtotime($invoice->due_date)){
            $overdue_total = $overdue_total + $invoice->invoice_amount;
        }
    }

    echo number_format($overdue_total, 2);

}

/**
 * Finds and totals all paid invoices
 *
 * use: call <?php paid_invoices(); ?>
 *
 * @version 1.1
 */
function invoice_app_paid_invoices(){

    global $wpdb;

    $sql = "SELECT ID AS pID, 
            pinvoicestatus.meta_value AS invoice_status,
            pinvoiceprice.meta_value AS invoice_amount
            FROM {$wpdb->prefix}posts
            LEFT JOIN {$wpdb->prefix}postmeta pinvoicestatus
            ON pinvoicestatus.post_id = ID AND pinvoicestatus.meta_key = 'invoice_status'
            RIGHT JOIN {$wpdb->prefix}postmeta pinvoiceprice
            ON pinvoiceprice.post_id = ID AND pinvoiceprice.meta_key = 'invoice_line_items_total'
            WHERE post_type = 'invoice_app_invoices' AND post_status = 'publish' AND pinvoicestatus.meta_value LIKE '%paid%'";

    $results = $wpdb->get_results($sql);

    $paid_total = '0';

    foreach($results as $invoice) {
        $paid_total = $paid_total + $invoice->invoice_amount;
    }

    //return amount
    echo number_format($paid_total, 2);

}

/**
 * Finds and totals live invoices (invoices that have NOT been paid)
 *
 * use: call <?php live_invoices(); ?>
 *
 * @version 1.1
 */
function invoice_app_live_invoices(){

    global $wpdb;

    $sql = "SELECT ID AS pID, 
            pinvoicedate.meta_value AS due_date,
            pinvoicestatus.meta_value AS status,
            pinvoiceprice.meta_value AS invoice_amount
            FROM {$wpdb->prefix}posts
            FULL JOIN {$wpdb->prefix}postmeta pinvoicedate 
            ON pinvoicedate.post_id = ID AND pinvoicedate.meta_key = 'invoice_due_date'
            RIGHT JOIN {$wpdb->prefix}postmeta pinvoicestatus 
            ON pinvoicestatus.post_id = ID AND pinvoicestatus.meta_key = 'invoice_status'
            RIGHT JOIN {$wpdb->prefix}postmeta pinvoiceprice
            ON pinvoiceprice.post_id = ID AND pinvoiceprice.meta_key = 'invoice_line_items_total'
            WHERE post_type = 'invoice_app_invoices' AND post_status = 'publish'";

    $results = $wpdb->get_results($sql);
 
    $live_total = '0';

    foreach($results as $invoice) {
        //today is not due date
        if($invoice->due_date != '' && strtotime(date('m/d/Y')) <= strtotime($invoice->due_date) && $invoice->status != 'paid'){
            $live_total = $live_total + $invoice->invoice_amount;
        }
    }

    //return amount
    echo number_format($live_total, 2);

}

/**
 * Check if post id is a quote.
 * @param $post_id
 *
 * @return false|string*
 */
function invoice_app_is_quote($post_id){
    if (get_post_type($post_id) == 'invoice_app_quotes'){
        return true;
    } else {
        return false;
    }
}

/**
 * Check when quote expires.
 * @param $post_id
 *
 * @return false|string
 */
function invoice_app_quote_expires_on($post_id) {
	$invoice_app_settings = get_option('invoice_app_settings');
	$quoteDate = get_post_meta( $post_id, 'quote_issue_date', true );
	if (!empty($quoteDate)) {
		return date( 'M d, Y', strtotime( $quoteDate ) + ( 24 * 3600 * $invoice_app_settings['quote_life'] ) );
	} else {
		return false;
	}
}

/**
 * Finds and deliver best client (invoices that have NOT been paid)
 *
 * use: call <?php live_invoices(); ?>
 *
 * @version 1.1
 */
/*function best_client(){

  require(APP_BASE . "/assets/database.php");

  try {

    $sql = "SELECT `client_company`,`invoice_amount` FROM `invoices` WHERE invoice_status LIKE '%paid%' ORDER BY COUNT(client_company)";
    //$sql = "SELECT `invoice_amount`, `due_date` FROM `invoices`";
    $results = $db->prepare($sql);
    $results->execute();

  } catch(Exception $e) {

    echo 'Data could not be found';
    return false;
    exit();

  }

  //get invoices 
  $clients = $results->fetchAll(PDO::FETCH_ASSOC);

  //return amount
  echo $clients[0]['client_company'];

}*/

/**
 * Simple function to handle empty invoice values.
 *
 * use: issetornull($var)
 *
 * @version 1.0
 */
function invoice_app_issetornull($var, $default = '') {
    return isset($var) ? $var : $default;
}

/**
 * Creates PDF from invoice/quote values
 *
 * use: call <?php invoice_to_pdf(); ?>
 *
 * @version 1.1
 */
function invoice_to_pdf($post_id = '', $output_to_file = null, $file = null){

	require_once('fpdf/fpdf.php'); //get pdf library

	if (invoice_app_is_quote($post_id)){
		$type = 'quote';
	} else {
		$type = 'invoice';
	}

	$invoice_app_settings = get_option('invoice_app_settings');
	$invoice = get_post_meta($post_id);
	$client = invoice_app_get_client_details_by_name($invoice[$type . '_client'][0]);

	class PDF extends FPDF
	{
		// Load data
		function LoadData($file)
		{
			// Read file lines
			$lines = file($file);
			$data = array();
			foreach($lines as $line)
			$data[] = explode(';',trim($line));
			return $data;
		}

		function PDF($orientation='P', $unit='mm', $size='A4')
		{
			// Call parent constructor
			$this->FPDF($orientation,$unit,$size);
			// Initialization
			$this->B = 0;
			$this->I = 0;
			$this->U = 0;
			$this->HREF = '';
		}

		function WriteHTML($html)
		{
			// HTML parser
			$html = str_replace("\n",' ',$html);
			$a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
			foreach($a as $i=>$e)
		{

		if($i%2==0)
		{
			// Text
			if($this->HREF)
			$this->PutLink($this->HREF,$e);
			else
			$this->Write(5,$e);
		}
		else
		{
			// Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				// Extract attributes
				$a2 = explode(' ',$e);
				$tag = strtoupper(array_shift($a2));
				$attr = array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
					$attr[strtoupper($a3[1])] = $a3[2];
					}
						$this->OpenTag($tag,$attr);
					}
				}
			}
		}
		function OpenTag($tag, $attr)
		{
		// Opening tag
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
		}

		function CloseTag($tag)
		{
			// Closing tag
			if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
			if($tag=='A')
			$this->HREF = '';
		}

		function SetStyle($tag, $enable)
		{
			// Modify style and select corresponding font
			$this->$tag += ($enable ? 1 : -1);
			$style = '';
			foreach(array('B', 'I', 'U') as $s)
			{
				if($this->$s>0)
				$style .= $s;
			}
			$this->SetFont('',$style);
		}

		function PutLink($URL, $txt)
		{
			// Put a hyperlink
			$this->SetTextColor(0, 0, 255);
			$this->SetStyle('U', true);
			$this->Write(5, $txt, $URL);
			$this->SetStyle('U', false);
			$this->SetTextColor(0);
		}

		function SetDash($black=false, $white=false)
		{
			if($black and $white)
			$s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
			else
			$s='[] 0 d';
			$this->_out($s);
		}

		function Footer() {
			// Go to 1.5 cm from bottom
			$this->SetY(-15);
			$this->Cell(0, 10, __('Created by INVOICE APP for WordPress'), 0, 0, 'R');
		}

	}

	$projectDescription = '<span>' . invoice_app_issetornull($invoice[$type . '_description'][0]) . '</span><br><br>';
	if (!invoice_app_is_quote($post_id)) {
		$projectDescription .= '<span>Invoice: <b>' . invoice_app_issetornull($invoice['invoice_number'][0]) . '<b></span><br><br>';
		$terms = '<br><br><span> Terms: ' . invoice_app_issetornull($invoice[ $type . '_terms' ][0]) . '</span>';
		$notes = '<br><span> Notes: ' . invoice_app_issetornull($invoice[ $type . '_notes' ][0]) . '</span>';
	}

	$pdf = new PDF();

	/* Load Fonts */
	include_once("loadfonts.php");
	$pdf->SetDisplayMode('fullpage');
	//$pdf->DisplayPreferences('HideMenubar,HideToolbar,HideWindowUI');
	/* Start Page */
	$pdf->AddPage();

	/* Set Starting Font Type and Size */
	$pdf->SetFont('OpenSans', '', 22);

	/* Left Column */
	$pdf->Cell(45, 10, ucwords($type), '', 0, 'L');
	$pdf->SetFontSize(10);

	$pdf->Cell(57, 6, invoice_app_issetornull($invoice[$type . '_client'][0]), 0, 'L'); //$client['client_address']
	$pdf->Ln();

	if(!empty($client['client_address'][0])){
		$pdf->Cell(45, 5,'', '', 0, 'TL');
		$pdf->Cell(57, 5, invoice_app_issetornull($client['client_address'][0]), 0, 'L'); //$client['client_address']
		$pdf->Ln();
	}

	$pdf->Cell(45, 5, '', '', 0, 'TL');
	$pdf->Cell(57, 5, invoice_app_issetornull($client['client_city'][0]) . ' ' . invoice_app_issetornull($client['client_state'][0]) . ' ' . invoice_app_issetornull($client['client_zip'][0]),0,'L'); //$client['client_address']
	$pdf->Ln();

	$pdf->Cell(45, 5, invoice_app_issetornull($invoice_app_settings['business_name']), '', 0, 'TL');
	$pdf->Cell(57, 5, date('F j, Y', strtotime( invoice_app_issetornull($invoice[$type . '_issue_date'][0], date('F j, Y') ))), 0, 'L'); //$client['client_address']
	$pdf->Ln();

	$pdf->SetTextColor(0, 76, 153);
	$pdf->Cell(45, 5, invoice_app_issetornull($invoice_app_settings['business_phone']), '', 0, 'TL');//phone @todo FIX
	$pdf->Cell(57, 5, '', 0, 'L');
	$pdf->Ln();

	$pdf->Cell(45, 5, invoice_app_issetornull(get_option('admin_email')), '', 0, 'TL');

	//set color back to black
	$pdf->SetTextColor(39, 39, 39);

	$pdf->Cell(57, 5, 'Project Title: ', 0, 'L');
	$pdf->Ln();


	$pdf->SetLeftMargin(55); //set margin
	$pdf->SetFontSize(11); //set font size
	$pdf->WriteHTML('<span>' . invoice_app_issetornull($invoice[$type . '_project_title'][0]) . '</span>'); //write html
	$pdf->Ln();

	$pdf->SetLeftMargin(10); //set margin
	$pdf->SetFontSize(11); //set font size
	$pdf->Ln();

	$pdf->MultiCell(40, 5, invoice_app_issetornull($invoice_app_settings['business_address']), '','TL',false);

	$pdf->Cell(45, 0, '', '', 0, 'TL');
	$pdf->Cell(57, 5, 'Project Description: ', 0, 'L');
	$pdf->Ln();

	/* Right Coumn (Main) */
	$pdf->SetLeftMargin(55); //set margin
	$pdf->SetFontSize(11); //set font size
	$pdf->WriteHTML(invoice_app_issetornull($projectDescription)); //write html

	/* Write Table */
	$pdf->SetFontSize(9); //set font size
	$pdf->SetFillColor(224,235,255);//set header fill color

	/* Write Table Header */
	$pdf->Cell(72, 8, 'Description', '', 0, 'L', true);
	$pdf->Cell(23, 8, 'QTY', '', 0, 'R', 'red');
	$pdf->Cell(23, 8, 'Cost', '', 0, 'R', 'red');
	$pdf->Cell(23, 8, 'Total', '', 0, 'R', 'red');

	$pdf->Ln();//line break

	$pdf->SetDrawColor(230, 230, 230);//change border color to gray

	$lineItems = maybe_unserialize($invoice['invoice_line_items'][0]);
	foreach( $lineItems as $lineItem) {
		$pdf->Cell(72, 12, invoice_app_issetornull($lineItem['description']), 'TR', 0, 'L', false);
		$pdf->Cell(23, 10, invoice_app_issetornull($lineItem['qty']), 'TR', 0, 'R', false);
		$pdf->Cell(23, 10, invoice_app_issetornull($lineItem['rate']), 'TR', 0, 'R', false);
		$pdf->Cell(23, 10, '$' . invoice_app_issetornull($lineItem['total']), 'T', 0, 'R', false);

		$pdf->Ln();
	}

	//draw black line
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(72, 0, '', 'T', 0, 'L', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Ln();

	//product sub-total
	$pdf->SetDrawColor(230, 230, 230);
	$pdf->Cell(72, 10, '', 'RB', 0, 'L', false);
	$pdf->Cell(23, 10, '', 'RB', 0, 'C', false);
	$pdf->Cell(23, 10, 'Subtotal', 'RB', 0,'C', false);
	$pdf->Cell(23, 10, '$' . invoice_app_issetornull($invoice['invoice_line_items_subtotal'][0]), 'B', 0, 'R', false);
	$pdf->Ln();

	//tax total
	$pdf->Cell(72, 10, '', 'R', 0, 'L', false);
	$pdf->Cell(23, 10, '', 'R', 0, 'C', false);
	$pdf->Cell(23, 10, 'Tax (' . invoice_app_issetornull($invoice_app_settings['tax_rate']) . '%)', 'R', 0, 'C', false);
	$pdf->Cell(23, 10, '$ ' . invoice_app_issetornull($invoice['invoice_line_items_tax_total'][0]), '', 0, 'R', false);
	$pdf->Ln();

	//draw black line
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(72, 0, '', 'T', 0, 'L', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Ln();

	/**
	* invoice total
	*/
	$pdf->SetDrawColor(230, 230, 230);
	$pdf->SetFontSize(10); //set font size
	$pdf->Cell(72, 10, '', 'R', 0, 'L', false);
	$pdf->Cell(23, 10, '', 'R', 0, 'C', false);
	$pdf->Cell(23, 10, 'Total', 'R', 0, 'C', false);
	$pdf->Cell(23, 10, '$' . invoice_app_issetornull($invoice['invoice_line_items_subtotal'][0]), '', 0, 'R', false);
	$pdf->Ln();

	//draw black line
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(72, 0, '', 'T', 0, 'L', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Cell(23, 0, '', 'T', 0, 'C', false);
	$pdf->Ln();
	$pdf->Ln();

	//do terms
	if (!invoice_app_is_quote($post_id)) {
		$pdf->SetFontSize( 8 ); //set font size
		$pdf->WriteHTML( $terms );
		$pdf->Ln();//break line
	}

	//do notes
	if (!invoice_app_is_quote($post_id)) {
		$pdf->WriteHTML( invoice_app_issetornull( $notes ) );
	}

	//output
	if ($output_to_file == true) {
		$pdf->Output( WP_CONTENT_DIR . $file, "F");
	} else {
		$pdf->Output();
	}

}