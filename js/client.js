function ShowTheGMap(mapdiv, mapData){
	if(document.getElementById(mapdiv) && GBrowserIsCompatible()){
		mapData = eval("("+unescape(mapData)+")");
		
		if(mapData.latitude && mapData.longitude && mapData.zoom){
			var map = new GMap2(document.getElementById(mapdiv));
			map.setCenter(new GLatLng(mapData.latitude,mapData.longitude), mapData.zoom);
			map.enableContinuousZoom();
			map.enableDoubleClickZoom();
			
			switch(parseInt(mapData.mapstyle)){
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
			
			switch(parseInt(mapData.hud)){
				case 1:
					map.addControl(new GMapTypeControl());
					map.addControl(new GLargeMapControl());
					break;

				case 2:
					var customUI = map.getDefaultUI();
	        		map.setUI(customUI);
					break;
					
				default:
					
			}
			
			var icon = G_DEFAULT_ICON, i;
			if(mapData.iconImage){
				icon.image = mapData.iconImage;
				if(parseInt(mapData.iconImageAnchorX) && parseInt(mapData.iconImageAnchorY)){
					icon.iconAnchor = new GPoint(parseInt(mapData.iconImageAnchorX), parseInt(mapData.iconImageAnchorY));
				}
				if(parseInt(mapData.iconImageWidth) && parseInt(mapData.iconImageHeight)){
					icon.iconSize = new GSize(parseInt(mapData.iconImageWidth), parseInt(mapData.iconImageHeight));
				}
			}
			if(mapData.iconShadowImage){
				icon.shadow = mapData.iconShadowImage;
				if(parseInt(mapData.iconShadowImageWidth) && parseInt(mapData.iconShadowImageHeight)){
					icon.shadowSize = new GSize(parseInt(mapData.iconShadowImageWidth), parseInt(mapData.iconShadowImageHeight));
				}
				if(parseInt(mapData.iconWindowAnchorX) && parseInt(mapData.iconWindowAnchorY)){
					icon.infoWindowAnchor = new GPoint(parseInt(mapData.iconWindowAnchorX), parseInt(mapData.iconWindowAnchorY));
				}
			}
			
			var marker = new GMarker(map.getCenter(), {icon:((i=icon)?i:G_DEFAULT_ICON), draggable: false});
			GEvent.addListener(marker, "click", function() {
				var infoTabs = new Array();
				for(var separator in mapData.separators){
					infoTabs.push(new GInfoWindowTab(mapData.separators[separator].name, mapData.separators[separator].html));
				}
				if(infoTabs.length > 0){
					marker.openInfoWindowTabsHtml(infoTabs);
				}
			});
			map.addOverlay(marker);
		}
	}
}

/* Add a function to the onLoad event */
function addOnloadEvent(fnc){
	if(typeof window.addEventListener!="undefined"){
		window.addEventListener("load", fnc, false);
	}else{
		if(typeof window.attachEvent!="undefined"){
			window.attachEvent("onload", fnc );
		}else{
			if(window.onload!=null){
				var oldOnload = window.onload;
				window.onload = function(e){
					oldOnload(e);
					window[fnc]();
				};
			}else{
				window.onload = fnc;
			}
		}
	}
}

/* Add a function to the onUnLoad event */
function addOnUnloadEvent(fnc){
	if(typeof window.addEventListener!="undefined"){
		window.addEventListener("unload", fnc, false);
	}else{
		if(typeof window.attachEvent!="undefined"){
			window.attachEvent("onunload", fnc );
		}else{
			if(window.onunload!=null){
				var oldOnunload = window.onunload;
				window.onunload = function(e){
					oldOnunload(e);
					window[fnc]();
				};
			}else{
				window.onunload = fnc;
			}
		}
	}
}
addOnUnloadEvent(GUnload);