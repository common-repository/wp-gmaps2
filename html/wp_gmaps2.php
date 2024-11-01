<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script type="text/javascript" src="../js/utils/tiny_mce_popup.js"></script>
		<script type="text/javascript" src="../js/utils/mctabs.js"></script>
		<link rel="stylesheet" href="../css/content.css" type="text/css" media="screen" />
		<script type="text/javascript">
			/* <![CDATA[ */
				var gmaps_key = tinyMCEPopup.getWindowArg('gmaps_key');
				document.write('<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key='+gmaps_key+'"><\/script>');
				document.write('<script type="text/javascript" src="../js/dialog.js"><\/script>');
			/* //]]> */
		</script>
		<title>{#wp_gmaps2_dlg.title}</title>
	</head>
	<body onload="if(typeof (updateMap) == 'function') updateMap();" onunload="if(typeof (GUnload) == 'function') GUnload();">
		<form id="gmap_form" onsubmit="wp_gmaps2_dialog.insert();return false;" action="#">
			<div class="tabs">
				<ul>
					<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onmousedown="return false;">{#wp_gmaps2_dlg.general}</a></span></li>
					<li id="advanced_tab"><span><a href="javascript:mcTabs.displayTab('advanced_tab','advanced_panel');" onmousedown="return false;">{#wp_gmaps2_dlg.advanced}</a></span></li>
				</ul>
			</div>
			<div class="panel_wrapper">
				<div id="general_panel" class="panel current" style="height:440px">
					<fieldset>
						<legend>{#wp_gmaps2_dlg.map}</legend>
						<table border="0" cellspacing="0" cellpadding="4">
							<tr>
								<td colspan="2"><div id="map" style="width:575px;height:300px;overflow:hidden"></div></td>
							</tr>
						</table>
					</fieldset>
					<fieldset style="margin-top:10px">
						<legend>{#wp_gmaps2_dlg.location}</legend>
						<fieldset>
							<legend>{#wp_gmaps2_dlg.coordinates}</legend>
							<table border="0" cellspacing="0" cellpadding="4">
								<tr>
									<td style="width: 50px; white-space: nowrap;">{#wp_gmaps2_dlg.coordinates_latitude}:</td><td style="width: 150px;"><input onchange="updateMap();" onblur="this.onchange();" style="width:150px;" id="latitude" name="latitude" type="text" class="text" /></td>
									<td style="width: 50px; white-space: nowrap;">{#wp_gmaps2_dlg.coordinates_longitude}:</td><td style="width: 150px;"><input onchange="updateMap();" onblur="this.onchange();" style="width:150px;" id="longitude" name="longitude" type="text" class="text" /></td>
								</tr>
							</table>
						</fieldset>
						<table border="0" cellspacing="0" cellpadding="4">
							<tr>
								<td>{#wp_gmaps2_dlg.address}:</td>
								<td><input size="60" id="address" name="address" value="{#wp_gmaps2_dlg.defaultaddress}" type="text" onfocus="if(this.value=='{#wp_gmaps2_dlg.defaultaddress}'){this.value=''}" onblur="if(this.value!='' && this.value!='{#wp_gmaps2_dlg.defaultaddress}'){showAddress(this.value);}else{this.value='{#wp_gmaps2_dlg.defaultaddress}'}; return false;"><input type="button" onclick="showAddress(document.getElementById('address').value);return false;" style="border:1px solid #555;background:white;margin-left:10px;" value="{#wp_gmaps2_dlg.search}" /></td>
							</tr>
						</table>
					</fieldset>
				</div>
				<div id="advanced_panel" class="panel" style="height:440px">
					<fieldset>
						<legend>{#wp_gmaps2_dlg.map_size}</legend>
						<table border="0" cellspacing="0" cellpadding="4">
								<tr>
									<td colspan="2">
										<table border="0" cellspacing="0" cellpadding="0" width="575">
											<td width="50%">
												{#wp_gmaps2_dlg.width}: <input style="width:180px;" id="width" name="width" type="text" class="text" value="400" /> <abbr title="{#wp_gmaps2_dlg.pixel}">px</abbr>
											</td>
											<td align="right" width="50%">
												{#wp_gmaps2_dlg.height}: <input style="width:180px;" id="height" name="height" type="text" class="text" value="300" /> <abbr title="{#wp_gmaps2_dlg.pixel}">px</abbr>
											</td>
										</table>
									</td>
									<td></td>
								</tr>
						</table>
					</fieldset>
					<fieldset style="margin-top:10px">
						<legend>{#wp_gmaps2_dlg.map_options}</legend>
						<table border="0" cellspacing="0" cellpadding="4" style="width: 100%;">
							<tr>
								<td class="minimalSizedLabel">{#wp_gmaps2_dlg.zoom_level}:</td>
								<td><input type="text" size="2" value="13" name="zoomlevel" id="zoomlevel" class="text" /></td>
								<td class="minimalSizedLabel">{#wp_gmaps2_dlg.map_style}:</td>
								<td>
									<select name="mapstyle" id="mapstyle" onchange="updateMap();" onblur="this.onchange();" >
										<option value="1" selected>{#wp_gmaps2_dlg.map_style_normal}</option>
										<option value="2">{#wp_gmaps2_dlg.map_style_satellite}</option>
										<option value="3">{#wp_gmaps2_dlg.map_style_hybrid}</option>
										<option value="4">{#wp_gmaps2_dlg.map_style_physical}</option>
									</select>
								</td>
								<td class="minimalSizedLabel">{#wp_gmaps2_dlg.map_controls}:</td>
								<td>
									<select name="hud" id="hud" onchange="updateMap();" onblur="this.onchange();" >
										<option value="1">{#wp_gmaps2_dlg.map_controls_simple}</option>
										<option value="2" selected>{#wp_gmaps2_dlg.map_controls_3d}</option>
										<option value="3">{#wp_gmaps2_dlg.map_controls_none}</option>
									</select>
								</td>
							</tr>
						</table>
					</fieldset>
					<fieldset style="margin-top:10px">
						<legend>{#wp_gmaps2_dlg.map_separators}</legend>
						<div style="width:100%; height: 149px; overflow: auto;">
							<table id="separators_table" border="0" cellspacing="0" cellpadding="4" style="width:100%;">
								<colgroup span="3">
									<col style="width:165px; text-align: left;"/>
									<col style="text-align: left;"/>
									<col style="width:70px; text-align: center;"/>
								</colgroup>
								<thead>
									<tr>
										<th>{#wp_gmaps2_dlg.map_separators_label}</th>
										<th>{#wp_gmaps2_dlg.map_separators_content}</th>
										<th><input type="image" style="border: none; height: 20px;" src="../img/add.png" title="{#wp_gmaps2_dlg.map_separators_add}..." name="separator_add" id="separator_add" onclick="addRowSeparatorOn('separators_table'); return false;"/><input type="image" style="border: none; height: 20px;" src="../img/remove.png" title="{#wp_gmaps2_dlg.map_separators_remove}..." name="separator_remove" id="separator_remove" onclick="removeRowSeparatorOn('separators_table'); return false;"/></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</fieldset>
					<fieldset style="margin-top:10px">
						<legend>{#wp_gmaps2_dlg.map_icon}</legend>
						<table border="0" cellspacing="0" cellpadding="4" style="width:100%;">
							<tr>
								<td>
									<table border="0" cellspacing="0" cellpadding="0" style="width:100%;" class="dtable">
										<tr>
											<td colspan="2">&nbsp;</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.icon_image_x}:</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.icon_image_y}:</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.width}:</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.height}:</td>
										</tr>
										<tr>
											<td class="minimalSizedLabel">{#wp_gmaps2_dlg.map_icon_url}:</td>
											<td><input type="text" value="" name="icon_image" id="icon_image" class="text" style="width: 99%;" title="{#wp_gmaps2_dlg.map_icon_image_title}" /></td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_x" id="icon_image_x" class="text" size="2" title="{#wp_gmaps2_dlg.icon_image_x_title}" /></td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_y" id="icon_image_y" class="text" size="2" title="{#wp_gmaps2_dlg.icon_image_y_title}" /></td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_width" id="icon_image_width" class="text" size="2" title="{#wp_gmaps2_dlg.map_icon_width_title}" /></td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_height" id="icon_image_height" class="text" size="2" title="{#wp_gmaps2_dlg.map_icon_height_title}" /></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" cellspacing="0" cellpadding="0" style="width:100%;" class="dtable">
										<tr>
											<td colspan="2">&nbsp;</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.width}:</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.height}:</td>
										</tr>
										<tr>
											<td class="minimalSizedLabel">{#wp_gmaps2_dlg.map_icon_shadow_url}:</td>
											<td><input type="text" value="" name="icon_image_shadow" id="icon_image_shadow" class="text" style="width: 99%;" title="{#wp_gmaps2_dlg.map_icon_shadow_image_title}" /></td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_shadow_width" id="icon_image_shadow_width" class="text" size="2" title="{#wp_gmaps2_dlg.map_icon_shadow_width_title}" /></td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_shadow_height" id="icon_image_shadow_height" class="text" size="2" title="{#wp_gmaps2_dlg.map_icon_shadow_height_title}" /></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" cellspacing="0" cellpadding="0" class="dtable">
										<tr>
											<td class="minimalSizedLabel">&nbsp;</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.icon_image_x}:</td>
											<td class="minimalSizedWithPadding">{#wp_gmaps2_dlg.icon_image_y}:</td>
										</tr>
										<tr>
											<td class="minimalSizedLabel">{#wp_gmaps2_dlg.map_icon_info_anchor}:</td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_info_x" id="icon_image_info_x" class="text" size="2" title="{#wp_gmaps2_dlg.icon_image_info_anchor_x_title}" /></td>
											<td class="minimalSizedWithPadding"><input type="text" value="" name="icon_image_info_y" id="icon_image_info_y" class="text" size="2" title="{#wp_gmaps2_dlg.icon_image_info_anchor_y_title}" /></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</fieldset>
				</div>
			</div>
			<div class="mceActionPanel">
				<div style="float: left">
					<input type="button" id="insert" name="insert" value="{#insert}" onclick="wp_gmaps2_dialog.insert();" />
				</div>
		
				<div style="float: right">
					<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
				</div>
			</div>
		</form>
	</body>
</html>
