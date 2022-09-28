
		<div class="cbs-main-list-item-section-header cbs-clear-fix">
			<span class="cbs-main-list-item-section-header-step">
				<span><?php echo esc_html($this->data['step']); ?></span>
				<span>/<?php echo esc_html($this->data['stepCount']); ?></span>
			</span>
			<h4 class="cbs-main-list-item-section-header-header">
<?php
		foreach($this->data['header'] as $headerText)
			echo '<span>'.esc_html($headerText).'</span>';
?>
			</h4>
			<h5 class="cbs-main-list-item-section-header-subheader">
<?php
		foreach($this->data['subheader'] as $subheaderText)
			echo '<span>'.esc_html($subheaderText).'</span>';
?>				
				
			</h5>
		</div>