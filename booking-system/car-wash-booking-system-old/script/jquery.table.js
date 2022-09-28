/******************************************************************************/
/******************************************************************************/

;(function($,doc,win) 
{
	"use strict";
	
	var Table=function(object)
	{
		/**********************************************************************/
		
		var $this=$(object);
		
		var $buttonAdd=$this.next('div').find('.to-table-button-add');
		var $buttonRemove=$this.find('.to-table-button-remove');

		/**********************************************************************/

		this.build=function() 
		{
			var self=this;
			
			var count=$this.children('tbody').find('tr>th').length;
						
			$buttonRemove.on('click',function(e) 
			{ 
				e.preventDefault(); 
				self.removeLine(this); 
			});
			
			$buttonAdd.on('click',function(e) 
			{ 
				e.preventDefault(); 
				self.addLine(); 
			});

			self.addLine();
		};
		
		/**********************************************************************/
		
		this.addLine=function()
		{
			var line=$this.children('tbody').children('tr+tr').first().clone(true,true).removeClass('to-hidden');
			$this.append(line.fadeIn(50));

			line.find('select.to-dropkick-0').each(function() 
			{
				var helper=new PBHelper();
				var string=helper.getRandomString(16);
				
				$(this).attr('id',$(this).attr('id')+'_'+string).removeClass('to-dropkick-0');
			});
		};
		
		/**********************************************************************/
		
		this.removeLine=function(object)
		{
			var lineCount=$(object).parents('tbody:first').children('tr').length;
			
			if(lineCount<=3) return;
			
			$(object).parents('tr').first().fadeOut(200,function() 
			{ 
				$(this).remove(); 
			});
		};
		
		/**********************************************************************/
	};
	
	/**************************************************************************/
	
	$.fn.table=function() 
	{
		var table=new Table(this);
		table.build();
	};
	
	/**************************************************************************/

})(jQuery,document,window);

/******************************************************************************/
/******************************************************************************/