<?php
$html_attr = array(
	'before_label'		=> '<th>',
	'after_label'		=> '</th>',
	'before_control'	=> '<td>',
	'after_control'		=> '</td>',
);
//	allow devices list control
$allow_devices_list = array(
	'android'	 => array(
		'label' => __( 'Android', 'wp-mobile' ),
	),
	'iphone'	 => array(
		'label' => __( 'iPhone', 'wp-mobile' ),
	),
);
$devices_args = array(
	'html_attr' => $html_attr,
	'label'		=> __( 'Allow Devices', 'wp-mobile' ),
	'value'		=> $allow_devices,
)
?>
<table class="form-table">
	<tbody>
		<tr valign="top">
			<?php
				echo $this->control->checkbox( 'allow_devices', $allow_devices_list, $devices_args );
			?>
		</tr>
	</tbody>
</table>
