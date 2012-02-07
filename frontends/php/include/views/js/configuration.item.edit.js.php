<script type="text/javascript">
	function removeDelayFlex(index) {
		jQuery('#delayFlex_' + index).remove();
		jQuery('#delay_flex_' + index + '_delay').remove();
		jQuery('#delay_flex_' + index + '_period').remove();

		if (jQuery('#delayFlexTable tr').length <= 7) {
			jQuery('#row_new_delay_flex').css('display', 'block');
		}
		else {
			jQuery('#row_new_delay_flex').css('display', 'none');
		}
	}

	function itemTypeInterface(type) {
		var result = null;
		var types = <?php echo CJs::encodeJson(itemTypeInterface()); ?>;
		jQuery.each(types, function(itemType, interfaceType) {
			if (type == itemType) {
				result = interfaceType;
				return interfaceType;
			}
		});
		return result;
	}

	function organizeInterfaces() {
		var interfaceType = itemTypeInterface(parseInt(jQuery('#type').val()));
		var selectedInterfaceId = jQuery('#selectedInterfaceId').val();
		var isSelected = false;
		var isInterfaceExist = false;

		if (interfaceType > 0) {
			jQuery('#interface_row option').each(function() {
				if (jQuery(this).data('interfacetype') == interfaceType) {
					isInterfaceExist = true;
				}
			});

			if (isInterfaceExist) {
				jQuery('#interfaceid').css('display', 'inline');
				jQuery('#interface_not_defined').css('display', 'none');

				jQuery('#interface_row option').each(function() {
					if (jQuery(this).is('[selected]')) {
						jQuery(this).removeAttr('selected');
					}
				});

				jQuery('#interface_row option').each(function() {
					if (jQuery(this).data('interfacetype') == interfaceType) {
						jQuery(this).css('display', 'block');
						if (!isSelected) {
							if (jQuery(this).val() == selectedInterfaceId) {
								jQuery(this).attr('selected', 'selected');
								isSelected = true;
							}
						}
					}
					else {
						jQuery(this).css('display', 'none');
					}
				});

				// select first available option if we previously don't selected it by interfaceid
				if (!isSelected) {
					jQuery('#interface_row option').each(function() {
						if (jQuery(this).data('interfacetype') == interfaceType) {
							if (!isSelected) {
								jQuery(this).attr('selected', 'selected');
								isSelected = true;
							}
						}
					});
				}
			}
			else {
				jQuery('#interfaceid').css('display', 'none');
				jQuery('#interface_row option').each(function() {
					if (jQuery(this).is('[selected]')) {
						jQuery(this).removeAttr('selected');
					}
				});
				jQuery('#interfaceid').val(0);
				jQuery('#interface_not_defined').css('display', 'inline');
			}
		}
		else {
			// display all interfaces for ANY
			jQuery('#interfaceid').css('display', 'inline');
			jQuery('#interface_not_defined').css('display', 'none');

			jQuery('#interface_row option').each(function() {
				if (jQuery(this).val() != 0) {
					jQuery(this).css('display', 'block');
					if (!isSelected) {
						jQuery(this).attr('selected', 'selected');
						isSelected = true;
					}
				}
			});
		}
	}

	/*
	 * ITEM_TYPE_ZABBIX: 0
	 * ITEM_TYPE_SNMPTRAP: 17
	 * ITEM_TYPE_SIMPLE: 3
	 */
	function displayKeyButton() {
		var type = parseInt(jQuery('#type').val());

		if (type == 0 || type == 7 || type == 3 || type == 5 || type == 8 || type == 17) {
			jQuery('#keyButton').removeAttr('disabled');
		}
		else {
			jQuery('#keyButton').attr('disabled', 'disabled');
		}
	}

	function setAuthTypeLabel() {
		if (jQuery('#authtype').val() == 1) {
			jQuery('#row_password label').html('<?php echo _('Key passphrase'); ?>');
		}
		else {
			jQuery('#row_password label').html('<?php echo _('Password'); ?>');
		}
	}

	jQuery(document).ready(function() {
		<?php
		if (!empty($this->data['valueTypeVisibility'])) { ?>
			var valueTypeSwitcher = new CViewSwitcher('value_type', 'change',
				<?php echo zbx_jsvalue($this->data['valueTypeVisibility'], true); ?>);
		<?php }
		if (!empty($this->data['authTypeVisibility'])) { ?>
			var authTypeSwitcher = new CViewSwitcher('authtype', 'change',
				<?php echo zbx_jsvalue($this->data['authTypeVisibility'], true); ?>);
		<?php }
		if (!empty($this->data['typeVisibility'])) { ?>
			var typeSwitcher = new CViewSwitcher('type', 'change',
				<?php echo zbx_jsvalue($this->data['typeVisibility'], true).(!empty($this->data['itemid']) ? ', true' : ''); ?>);
		<?php }
		if (!empty($this->data['securityLevelVisibility'])) { ?>
			var securityLevelSwitcher = new CViewSwitcher('snmpv3_securitylevel', 'change',
				<?php echo zbx_jsvalue($this->data['securityLevelVisibility'], true); ?>);
		<?php }
		if (!empty($this->data['dataTypeVisibility'])) { ?>
			var dataTypeSwitcher = new CViewSwitcher('data_type', 'change',
				<?php echo zbx_jsvalue($this->data['dataTypeVisibility'], true); ?>);
		<?php } ?>

		var multpStat = document.getElementById('multiplier');
		if (multpStat && multpStat.onclick) {
			multpStat.onclick();
		}

		var mnFrmTbl = document.getElementById('web.items.item.php');
		if (mnFrmTbl) {
			mnFrmTbl.style.visibility = 'visible';
		}

		var maxReached = <?php echo $this->data['maxReached'] ? 'true' : 'false'; ?>;
		if (maxReached) {
			jQuery('#row_new_delay_flex').css('display', 'none');
		}

		jQuery('#type').bind('change', function() {
			organizeInterfaces();
			displayKeyButton();
		});
		organizeInterfaces();
		displayKeyButton();

		jQuery('#authtype').bind('change', function() {
			setAuthTypeLabel();
		});
		setAuthTypeLabel();
	});
</script>
