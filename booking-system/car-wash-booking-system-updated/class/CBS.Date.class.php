<?php

/******************************************************************************/
/******************************************************************************/

class CBSDate
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->timeFormat=array
		(
			'12'=>array(__('12 - hour','car-wash-booking-system')),
			'24'=>array(__('24 - hour','car-wash-booking-system'))
		);
		
		$this->compareOperator=array
		(
			'gt'=>'>',
			'gte'=>'>=',
			'e'=>'=',
			'lt'=>'<',
			'lte'=>'<='
		);
				
		$this->day=array();
		
		for($i=1;$i<8;$i++)
			$this->day[$i]=array(date_i18n('l',strtotime('0'.$i.'-04-2013')));
	}
	
	/**************************************************************************/
	
	function getDayName($number)
	{
		return($this->day[$number][0]);
	}
	
	/**************************************************************************/
	
	function compareDate($date1,$date2)
	{
		$date1=strtotime($date1);
		$date2=strtotime($date2);
		
		if($date1-$date2==0) return(0);
		if($date1-$date2>0) return(1);
		if($date1-$date2<0) return(2);
	}
	
	/**************************************************************************/
	
	function compareTime($time1,$time2)
	{
		$time1=array_map('intval',preg_split('/:/',$time1));
		$time2=array_map('intval',preg_split('/:/',$time2));

		if($time1[0]>$time2[0]) return(1);

		if($time1[0]==$time2[0])
		{
			if($time1[1]>$time2[1]) return(1);
			if($time1[1]==$time2[1]) return(0);
		}
		
		return(2);
	}
	
	/**************************************************************************/
	
	function checkInRange($date,$range1,$range2,$equal=false)
	{
		$date=strtotime($date);
		$range1=strtotime($range1);
		$range2=strtotime($range2);
		
		if($equal) return(($date>=$range1) && ($date<=$range2));
		return(($date>$range1) && ($date<$range2));
	}
	
	/**************************************************************************/
	
	function getHourMinute($minute)
	{
		$data=array();
		
		if($minute<60)
		{
			$data['hour']=0;
			$data['minute']=$minute;
		}
		else
		{
			$data['hour']=floor($minute/60);
			$data['minute']=$minute-($data['hour']*60);
		}
		
		return($data);
	}
	
	/**************************************************************************/
	
	function formatTime(&$time,&$postfix,$format)
	{
		$postfix=null;
		
		if($format=='24') return;

		$data=preg_split('/:/',$time);
		
		if($data[0]>=12) $postfix=__('pm','car-wash-booking-system');
		else $postfix=__('am','car-wash-booking-system');
		
		if($data[0]>12) $data[0]=$data[0]-12;
		
		if(strlen($data[0])==1) $data[0]='0'.$data[0];
		
		$time=$data[0].':'.$data[1];	
	}
	
	/**************************************************************************/
	
	function reverse($date)
	{
		$date=preg_split('/-/',$date);
		return($date[2].'-'.$date[1].'-'.$date[0]);
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/