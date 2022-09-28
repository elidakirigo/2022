/******************************************************************************/
/******************************************************************************/

;(function($,doc,win) 
{
	"use strict";
	
	var CBSPluginAdmin=function(object,option)
	{
		/**********************************************************************/
		
		var $self=this;
		var $this=$(object);
		var $option=option;
		
		/**********************************************************************/
		
		this.getValueFromClass=function(object,pattern)
		{
			var reg=new RegExp(pattern);
			var className=$(object).attr('class').split(' ');
			
			for(var i in className)
			{
				if(reg.test(className[i]))
					return(className[i].substring(pattern.length));
			}

			return(false);		
		};	
		
		/**********************************************************************/
		
		this.post=function(data,callback)
		{
			$.post(pluginOption.config.ajaxurl,data,function(response)
			{ 
				callback(response); 
			},'json');
		};
		
		/**********************************************************************/
		
		this.closeMetaBox=function(id)
		{
			$(id).each(function() 
			{
				$('#cbs_meta_box_'+id).addClass('closed');
			});
		};
		
		/**********************************************************************/
	};
	
	/**************************************************************************/
	
	$.fn.CBSPluginAdmin=function(option) 
	{
		return(new CBSPluginAdmin(this,option));
	};
	
	/**************************************************************************/

})(jQuery,document,window);

/******************************************************************************/
/******************************************************************************/