<?php

/******************************************************************************/
/******************************************************************************/

class CBSBookingReport
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	function init()
	{
		add_action('wp_loaded',array($this,'generate'));
		add_action('manage_posts_extra_tablenav',array($this,'bookingReportControls'));
	}
	
	/**************************************************************************/
	
	function bookingReportControls()
	{
		if(!is_admin()) return;
		if(CBSHelper::getGetValue('post_type',false)!==PLUGIN_CBS_CONTEXT.'_booking') return;
		
		$output=
		'
			<div id="booking-report-controls" class="alignleft actions">
				<span>'.esc_html__('Booking report:','car-wash-booking-system').'</span>
				<input id="booking_report_from" type="text" name="booking_report_from" class="to-datepicker" value="'.esc_attr(CBSHelper::getGetValue('booking_report_from',false)).'" placeholder="'.esc_html__('From:','car-wash-booking-system').'"/>
				<input id="booking_report_to" type="text" name="booking_report_to" class="to-datepicker" value="'.esc_attr(CBSHelper::getGetValue('booking_report_to',false)).'" placeholder="'.esc_html__('To:','car-wash-booking-system').'"/>
				<button class="generate-report button">'.esc_html__('Generate','car-wash-booking-system').'</button>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($)
				{
					$(\'.generate-report\').on(\'click\',function()
					{
						var dateTo=$(\'#booking_report_to\').val();
						var dateFrom=$(\'#booking_report_from\').val();
						window.location.href="'.admin_url().'?booking_report=1&booking_report_from="+dateFrom+"&booking_report_to="+dateTo;
						return(false);
					});			
				});
			</script>
		';
		
		echo $output;
	}
	
	/**************************************************************************/
	
	function generate()
	{
		if(!is_admin()) return;
		
		$bookingReport=CBSHelper::getGetValue('booking_report',false);
		if(!$bookingReport) return;
		
		$bookingReportFrom=CBSHelper::getGetValue('booking_report_from',false);
		if($bookingReportFrom)
			$bookingReportFrom=date_i18n('Y-m-d',strtotime($bookingReportFrom));
		$bookingReportTo=CBSHelper::getGetValue('booking_report_to',false);
		if($bookingReportTo)
			$bookingReportTo=date_i18n('Y-m-d',strtotime($bookingReportTo));
		
		$reportFileName='booking-report';		
		if($bookingReportFrom || $bookingReportTo)
		{
			$reportFileName.='[';
			if($bookingReportFrom)
			{
				$reportFileName.='from_'.$bookingReportFrom;
			}
			if($bookingReportTo)
			{
				$reportFileName.=($bookingReportFrom ? '-' : '').'to_'.$bookingReportTo;
			}
			$reportFileName.=']';
		}
		$reportFileName.='.csv';
		
		$Date=new CBSDate();
		$Booking=new CBSBooking();
		$bookings=$Booking->getDictionary(array
		(
			'booking_from'													  =>  $bookingReportFrom,
			'booking_to'														=>  $bookingReportTo,
			'orderby_booking_date'											  =>  1,
		));

		$data='';
		$dataArray=array();		
		$dataArray[]=__('ID','car-wash-booking-system');
		$dataArray[]=__('Location','car-wash-booking-system');
		$dataArray[]=__('Date','car-wash-booking-system');
		$dataArray[]=__('Vehicle','car-wash-booking-system');
		$dataArray[]=__('Package','car-wash-booking-system');		
		$dataArray[]=__('First name','car-wash-booking-system');
		$dataArray[]=__('Second name','car-wash-booking-system');
		$dataArray[]=__('Company name','car-wash-booking-system');
		$dataArray[]=__('Email','car-wash-booking-system');
		$dataArray[]=__('Phone','car-wash-booking-system');		
		$dataArray[]=__('Price','car-wash-booking-system');
		
		$data.=implode(chr(9),$dataArray)."\r\n";
		
		if($bookings)
		{
			foreach($bookings as $bookingId=>$bookingData)
			{
				$dataArray=array();
				$dataArray[]=$bookings[$bookingId]['post']->ID;
				$dataArray[]=$bookings[$bookingId]['meta']['location_name'];
				$dataArray[]=$Booking->getBookingDuration($Date->reverse($bookings[$bookingId]['meta']['date']).' '.$bookings[$bookingId]['meta']['time'],$bookings[$bookingId]['meta']['duration']);
				$dataArray[]=$bookings[$bookingId]['meta']['client_vehicle'];
				
				if(isset($bookings[$bookingId]['meta']['package_name']))
					$dataArray[]=$bookings[$bookingId]['meta']['package_name'];
				else $dataArray[]='';				
				
				$dataArray[]=$bookings[$bookingId]['meta']['client_first_name'];
				$dataArray[]=$bookings[$bookingId]['meta']['client_second_name'];
				$dataArray[]=$bookings[$bookingId]['meta']['client_company_name'];
				$dataArray[]=$bookings[$bookingId]['meta']['client_email_address'];
				$dataArray[]=$bookings[$bookingId]['meta']['client_phone_number'];
				$dataArray[]=$bookings[$bookingId]['meta']['price'].' '.$bookings[$bookingId]['meta']['currency_id'];
				
				array_walk($dataArray,function(&$value,&$key)
				{
					$value=preg_replace('/\s+/',' ',$value);
				});
				
				$data.=implode(chr(9),$dataArray)."\r\n";
			}
		}

		header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
		header('Cache-Control: public');
		header('Content-Type: text/csv');
		header('Content-Transfer-Encoding: Binary');
		header('Content-Length:'.strlen($data));
		header('Content-Disposition: attachment;filename='.$reportFileName);
		echo $data;
		die();
	}
	
	/**************************************************************************/
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/