/* TinyMCE Dialog */
tinyMCEPopup.requireLangPack();

var updatedBySelection = false;
var wp_gmaps2_dialog = {

	init : function(ed, url) {
		updateUsingSelection();
	},

	insert : function() {
		var f = document.forms['gmap_form'];
		var strHtml = '';
		var latitude = parseFloat(f.latitude.value);
		var longitude = parseFloat(f.longitude.value);
		var width = parseInt(f.width.value);
		var height = parseInt(f.height.value);
		var zoom = parseInt(f.zoomlevel.value);
		var hud = f.hud.value;
		var mapstyle = f.mapstyle.value;
		var iconImage = f.icon_image.value;
		var iconImageAnchorX = parseInt(f.icon_image_x.value);
		var iconImageAnchorY = parseInt(f.icon_image_y.value);
		var iconImageWidth = parseInt(f.icon_image_width.value);
		var iconImageHeight = parseInt(f.icon_image_height.value);
		var iconShadowImage = f.icon_image_shadow.value;
		var iconShadowImageWidth = parseInt(f.icon_image_shadow_width.value);
		var iconShadowImageHeight = parseInt(f.icon_image_shadow_height.value);
		var iconWindowAnchorX = parseInt(f.icon_image_info_x.value);
		var iconWindowAnchorY = parseInt(f.icon_image_info_y.value);
		
		if(isNaN(latitude) || isNaN(longitude)){
			tinyMCEPopup.alert(tinyMCEPopup.getLang('wp_gmaps2_dlg.invalid_coordinates'));
		} else {
			Separator = function(name,html){
				this.name = name;
				this.html = html;
			};
			map = new Object();
			map.width = (!isNaN(width))?width:400;
			map.height = (!isNaN(height))?height:300;
			map.longitude = (!isNaN(longitude))?longitude:0;
			map.latitude = (!isNaN(latitude))?latitude:0;
			map.zoom = (!isNaN(zoom))?zoom:13;
			if(!isNaN(hud)){
				map.hud = hud;
			}
			if(!isNaN(mapstyle)){
				map.mapstyle = mapstyle;
			}
			if(iconImage){
				map.iconImage = iconImage;
			}
			if(!isNaN(iconImageAnchorX)){
				map.iconImageAnchorX = iconImageAnchorX;
			}
			if(!isNaN(iconImageAnchorY)){
				map.iconImageAnchorY = iconImageAnchorY;
			}
			if(!isNaN(iconImageWidth)){
				map.iconImageWidth = iconImageWidth;
			}
			if(!isNaN(iconImageHeight)){
				map.iconImageHeight = iconImageHeight;
			}
			if(iconShadowImage){
				map.iconShadowImage = iconShadowImage;
			}
			if(!isNaN(iconShadowImageWidth)){
				map.iconShadowImageWidth = iconShadowImageWidth;
			}
			if(!isNaN(iconShadowImageHeight)){
				map.iconShadowImageHeight = iconShadowImageHeight;
			}
			if(!isNaN(iconWindowAnchorX)){
				map.iconWindowAnchorX = iconWindowAnchorX;
			}
			if(!isNaN(iconWindowAnchorY)){
				map.iconWindowAnchorY = iconWindowAnchorY;
			}
			
			map.separators = new Array();
			var separators_name = document.getElementsByName("separator_name[]");
			var separators_html = document.getElementsByName("separator_html[]");
			if(separators_name && separators_html){
				for(var a = 0; a < separators_name.length; a++){ 
					if(separators_name[a].value!=''){
						map.separators.push(new Separator(separators_name[a].value, separators_html[a].value));
					}
				}
			}
			
			strHtml += '<img src=\''+tinyMCEPopup.getWindowArg("plugin_url")+'/../img/trans.gif\' alt=\''+escape(tinymce.util.JSON.serialize(map))+'\' width="'+map.width+'" height="'+map.height+'" class="wp_gmaps2 mceItemNoResize" title="'+tinyMCEPopup.editor.getLang('wp_gmaps2.desc')+'"/>\n';
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, strHtml);
			tinyMCEPopup.close();
			
			
		}
	}
};

tinyMCEPopup.onInit.add(wp_gmaps2_dialog.init, wp_gmaps2_dialog);

/* page related */
function updateUsingSelection(){
	var map = false, ed = tinyMCEPopup.editor;
	if(!updatedBySelection){
		tinyMCEPopup.restoreSelection();
		map = tinyMCEPopup.editor.getMap();
		
		if(map!=""){
			/* Let's check the size of the image on the selection, and update the map width and height on the form */
			var nodeElement = ed.selection.getNode(), s;
			if (nodeElement.nodeName == 'IMG') {
				if ( ed.dom.hasClass(nodeElement, 'wp_gmaps2') ){
					map.width = (s=nodeElement.width)?s:map.width;
					map.height = (s=nodeElement.height)?s:map.height;
				}
			}
			
			var form = document.forms['gmap_form'];
			if(form){
				var v;
				if(v = parseFloat(map.latitude)){
					form.latitude.value = v;
				}
				if(v = parseFloat(map.longitude)){
					form.longitude.value = v;
				}
				if(v = parseInt(map.width)){
					form.width.value = v;
				}
				if(v = parseInt(map.height)){
					form.height.value = v;
				}
				if(v = parseInt(map.zoom)){
					form.zoomlevel.value = v;
				}
				if(v = parseInt(map.hud)){
					form.hud.value = v;
				}
				if(v = parseInt(map.mapstyle)){
					form.mapstyle.value = v;
				}
				if(typeof(map.separators) == "object"){
					for(var b in map.separators){
						addRowSeparatorOn('separators_table', map.separators[b].name, map.separators[b].html);
					}
				}
				if(map.iconImage){
					form.icon_image.value = map.iconImage;
				}
				if(v = parseInt(map.iconImageAnchorX)){
					form.icon_image_x.value = v;
				}
				if(v = parseInt(map.iconImageAnchorY)){
					form.icon_image_y.value = v;
				}
				if(v = parseInt(map.iconImageWidth)){
					form.icon_image_width.value = v;
				}
				if(v = parseInt(map.iconImageHeight)){
					form.icon_image_height.value = v;
				}
				if(map.iconShadowImage){
					form.icon_image_shadow.value = map.iconShadowImage;
				}
				if(v = parseInt(map.iconShadowImageWidth)){
					form.icon_image_shadow_width.value = v;
				}
				if(v = parseInt(map.iconShadowImageHeight)){
					form.icon_image_shadow_height.value = v;
				}
				if(v = parseInt(map.iconWindowAnchorX)){
					form.icon_image_info_x.value = v;
				}
				if(v = parseInt(map.iconWindowAnchorY)){
					form.icon_image_info_y.value = v;
				}
				updatedBySelection = true;
			}
		}
	}else{
		return;
	}
}
var map=null;

function GMapLibLoaded(){
	return ((typeof (GBrowserIsCompatible) == 'function') && GBrowserIsCompatible())?true:false;
}

function showLatLongOnMap(latitude, longitude, zoom){
	return (GMapLibLoaded()?showPointOnMap(new GLatLng(latitude, longitude),zoom):false);
}

function showPointOnMap(point, zoom){
	if(!map && GMapLibLoaded()){
		map = new GMap2(document.getElementById("map"));
	}
	zoom = parseInt(zoom);
	zoom = ((!isNaN(zoom))?zoom:13);
	if (map!=null && GMapLibLoaded()){
		map.setCenter(point, zoom);

		map.setUI(map.getDefaultUI());
		map.enableContinuousZoom();
		map.enableDoubleClickZoom();

		var markerD2 = new GMarker(point, {icon:G_DEFAULT_ICON, draggable: true});
		map.addOverlay(markerD2);
		markerD2.enableDragging();
		GEvent.addListener(markerD2, "drag", function(){
			document.getElementById("latitude").value = markerD2.getPoint().lat();
			document.getElementById("longitude").value = markerD2.getPoint().lng();
			document.getElementById("zoomlevel").value = map.getZoom();
		});
		GEvent.addListener(map, "maptypechanged", function(){
			var v = 1;
			switch(map.getCurrentMapType()){
				case G_SATELLITE_MAP:
					v = 2;
					break;

				case G_HYBRID_MAP:
					v = 3;
					break;

				case G_PHYSICAL_MAP:
					v = 4;
					break;

				default:
					v = 1;
			}
			document.getElementById("mapstyle").value = v;
		});
		GEvent.addListener(map, "zoomend", function(){
			document.getElementById("zoomlevel").value = map.getZoom();
		});
	}
	return map;
}

function showAddress(address){
	if (GMapLibLoaded()){
		var geocoder = new GClientGeocoder();
		if (geocoder){
			geocoder.getLatLng(address,function(point) {
				if (!point) {
					alert(address + ' '+ tinyMCEPopup.getLang('wp_gmaps2_dlg.not_found'));
				} else {
					var map = showPointOnMap(point,13);
					if (map!=null){
						document.getElementById("latitude").value = point.lat();
						document.getElementById("longitude").value = point.lng();
						document.getElementById("zoomlevel").value = map.getZoom();
					}
				}
			});
		}
	}
}

function updateMap(){
	updateUsingSelection();
	
	if(GMapLibLoaded()){
		var latitude = parseFloat(document.getElementById("latitude").value);
		var longitude = parseFloat(document.getElementById("longitude").value);
		var zoomlevel = parseFloat(document.getElementById("zoomlevel").value);
		var map;
		
		if(latitude && longitude && zoomlevel){
			map = showLatLongOnMap(latitude, longitude, zoomlevel);
		} else {
			map = showLatLongOnMap(39.74356851278918, -8.792168498039246, zoomlevel);
		}
		if(map){
			switch(parseInt(document.getElementById("mapstyle").value)){
				case 2:
					map.setMapType(G_SATELLITE_MAP);
					break;
	
				case 3:
					map.setMapType(G_HYBRID_MAP);
					break;
	
				case 4:
					map.setMapType(G_PHYSICAL_MAP);
					break;
	
				default:
					map.setMapType(G_NORMAL_MAP);
			}
		}
	}
}

function addRowSeparatorOn(tableID, nameValue, htmlValue) {
	var t, table = document.getElementById(tableID);

	var row = table.insertRow(table.rows.length);
	var cell = row.insertCell(0);
	cell.style.verticalAlign = "top";
	
	var input = document.createElement("input");
	input.type = "text";
	input.name = "separator_name[]";
	input.value = ((t = nameValue)?t:'');
	input.className = "text";
	cell.appendChild(input);

	cell = row.insertCell(1);
	input = document.createElement("textarea");
	input.rows = "3";
	input.cols = "40";
	input.name = "separator_html[]";
	input.value = ((t = htmlValue)?t:'');
	input.className = "text";
	cell.appendChild(input);

	cell = row.insertCell(2);
	cell.style.textAlign = "center";
	input = document.createElement("input");
	input.type = "checkbox";
	cell.style.border = "none";
	cell.appendChild(input);
}

function removeRowSeparatorOn(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		
		for(var i=0; i<table.rows.length; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[2].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				table.deleteRow(i);
				i--;
			}
		}
		if(rowCount == table.rows.length){
			tinyMCEPopup.alert(tinyMCEPopup.getLang('wp_gmaps2_dlg.no_rows_selected'));
		}
	}catch(e) {
		alert(tinyMCEPopup.getLang('wp_gmaps2_dlg.error_ocorred')+": "+e);
	}
}