var locations = hqWorkspotLocations;
locations.forEach( function (location){
    if(location.hasFloors === '1'){
        var floors = Object.entries(location.floors);
        floors.forEach(function(floor){
            if(floor[1].map){
                setFloor(floor[1], location);
            }
        });
    }else{
        if(location.mapUUID){
            setMaps(location);
        }

    }

});


function setMaps(location){
    (function($){
        //Set Static Map Image layer

        var extent = [0, 0, 1980, 1080];
        var projection = new ol.proj.Projection({
            units: 'pixels',
            extent: extent
        });
        /*Locations*/
        var location_map = new ol.layer.Image({
            source: new ol.source.ImageStatic({
                url: location.mapUUID,
                projection: projection,
                imageExtent: extent
            })
        });

        //Set Vectors styles
        var styles = {
            'available': [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(0, 177, 205, 0.2)'
                })
            })],
            'unavailable': [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(237, 31, 98, 0.2)'
                })
            })],
            'rented': [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(255, 255, 255, 0)'
                })
            })]
        };

        //Function to add vector layer
        function addVector(jsonObject, style) {
            var features = new ol.format.GeoJSON().readFeatures(jsonObject, {
                featureProjection: projection
            });

            vectorSource = new ol.source.Vector({
                features: features
            });

            return new ol.layer.Vector({
                source: vectorSource,
                style: function (feature, resolution) {
                    return styles[style];
                }
            });
        }

        function initLayer() {
            return new ol.layer.Vector({
                source: new ol.source.Vector()
            });
        }

        //Set Vector layers
        var availableSpotsLayer = initLayer();
        var unavailableSpotsLayer = initLayer();
        var rentedSpotsLayer = initLayer();
        var availableFromSpotsLayer = initLayer();
        if(location.available_spots_coordinates_Json){
            availableSpotsLayer = addVector(location.available_spots_coordinates_Json, 'available');
        }
        if(location.unavailable_spots_coordinates_Json){
            unavailableSpotsLayer = addVector(location.unavailable_spots_coordinates_Json, 'unavailable');
        }
        if(location.rented_spots_coordinates_Json){
            rentedSpotsLayer = addVector(location.rented_spots_coordinates_Json, 'rented');
        }
        if(location.available_from_spots_coordinates_Json){
            availableFromSpotsLayer = addVector(location.available_from_spots_coordinates_Json, 'available')
        }

        //Set everything for popups
        var container = document.getElementById('popup-' + location.id);
        var content = document.getElementById('popup-content-' + location.id);
        //var closer = document.getElementById('popup-closer');
        var overlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
            element: container,
            autoPan: false
        }));
        //Set Map
        var map = new ol.Map({
            target: 'location-map-' + location.id,
            layers: [location_map, availableSpotsLayer, unavailableSpotsLayer, rentedSpotsLayer, availableFromSpotsLayer],
            overlays: [overlay],
            //Disable interactions
            interactions: ol.interaction.defaults({
                dragPan: false,
                doubleClickZoom: false,
                keyboardZoom: false,
                mouseWheelZoom: false
            }),
            //Enable view for static image
            view: new ol.View({
                projection: projection,
                center: ol.extent.getCenter(extent),
                zoom: 1.80,
                maxZoom: 2
            }),
            //Disable default map controls
            controls: []
        });

        //Set Overlays for vectors
        var overlay_color = 'rgba(255,0,0,0.1)';
        var featureOverlay = new ol.layer.Vector({
            source: new ol.source.Vector(),
            map: map,
            style: new ol.style.Style({
                fill: new ol.style.Fill({
                    color: overlay_color
                })
            })
        });

        var highlight;
        var displayFeatureInfo = function (pixel, coordinates) {
            var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
                return feature;
            });
            if (feature) {
                var feature_data;
                if (feature.get('status') == 'Algemene Ruimte') {
                    if(!(feature.get('website_product') === null)){
                        feature_data = '<p style="margin-bottom: 3px;"> ' + feature.get('website_product') + ' </p>';
                    }else{
                        feature_data = '<p style="margin-bottom: 3px;"></p>';
                    }
                } else {
                    feature_data = '<p style="margin-bottom: 3px;">Kantoorunit ' + feature.get('unit_number') + '</p>';
                }

                feature_data += '<p>' + feature.get('status') + '</p>';
                if (feature.get('status') == 'Algemene Ruimte') {
                    feature_data += '<p>Vergaderruimte</p>';
                }

                if (feature.get('status') == 'Beschikbaar vanaf') {
                    feature_data += '<p style="margin-top: -10px;">' + feature.get('available_date') + '</p>';
                }

                if (feature.get('price') && (feature.get('status') == 'Beschikbaar' || feature.get('status') == 'Beschikbaar vanaf')) {
                    feature_data += '<p style="margin-top: -10px;">Prijs: ' + feature.get('price') + '</p>';
                }

                if (feature.get('image_url') && feature.get('status') != 'Verhuurd') {
                    feature_data += '<IMG HEIGHT=100 WIDTH=160 SRC=' + feature.get('image_url') + '>';
                }

                content.innerHTML = feature_data;

                overlay.setPosition(coordinates);
            } else {
                content.innerHTML = '&nbsp;';
                overlay.setPosition(undefined);
            }

            if (feature !== highlight) {
                if (highlight) {
                    featureOverlay.getSource().removeFeature(highlight);
                }
                if (feature) {
                    featureOverlay.getSource().addFeature(feature);
                    switch (feature.get('status')) {
                        case 'Beschikbaar':
                            overlay_color = 'rgba(0, 177, 205, 0.5)';
                            break;
                        case 'Algemene Ruimte':
                            overlay_color = 'rgba(237, 31, 98, 0.5)';
                            break;
                        case 'Verhuurd':
                            overlay_color = 'rgba(145, 145, 145, 0.5)';
                            break;
                    }
                    var style = new ol.style.Style({
                        fill: new ol.style.Fill({
                            color: overlay_color
                        })
                    });
                    featureOverlay.setStyle(style);
                }
                highlight = feature;
            }
        };

        var redirectToFeaturePage = function (pixel, coordinates) {
            var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
                return feature;
            });

            if (feature) {
                var url = feature.get('site_url');
                if (url) {
                    window.open(url, '_blank');
                }
            }
        };

        map.on('pointermove', function (evt) {
            if (evt.dragging) {
                return;
            }
            var pixel = map.getEventPixel(evt.originalEvent);
            displayFeatureInfo(pixel, evt.coordinate);
        });

        map.on('click', function (evt) {
            if (evt.dragging) {
                return;
            }
            var pixel = map.getEventPixel(evt.originalEvent);
            redirectToFeaturePage(pixel, evt.coordinate);
        });
        $('.ol-viewport').css('overflow','visible');
    })(jQuery);
}


function setFloor(floor, location){
    (function($){
        //Set Static Map Image layer

        var extent = [0, 0, 1980, 1080];
        var projection = new ol.proj.Projection({
            units: 'pixels',
            extent: extent
        });
        /*Locations*/
        var location_map = new ol.layer.Image({
            source: new ol.source.ImageStatic({
                url: floor.map,
                projection: projection,
                imageExtent: extent
            })
        });

        //Set Vectors styles
        var styles = {
            'available': [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(0, 177, 205, 0.2)'
                })
            })],
            'unavailable': [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(237, 31, 98, 0.2)'
                })
            })],
            'rented': [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(255, 255, 255, 0)'
                })
            })]
        };

        //Function to add vector layer
        function addVector(jsonObject, style) {
            var features = new ol.format.GeoJSON().readFeatures(jsonObject, {
                featureProjection: projection
            });

            vectorSource = new ol.source.Vector({
                features: features
            });

            return new ol.layer.Vector({
                source: vectorSource,
                style: function (feature, resolution) {
                    return styles[style];
                }
            });
        }

        function initLayer() {
            return new ol.layer.Vector({
                source: new ol.source.Vector()
            });
        }

        //Set Vector layers
        var availableSpotsLayer = initLayer();
        var unavailableSpotsLayer = initLayer();
        var rentedSpotsLayer = initLayer();
        var availableFromSpotsLayer = initLayer();
        if(floor.available_spots_coordinates_Json){
            availableSpotsLayer = addVector(floor.available_spots_coordinates_Json, 'available');
        }
        if(floor.unavailable_spots_coordinates_Json){
            unavailableSpotsLayer = addVector(floor.unavailable_spots_coordinates_Json, 'unavailable');
        }
        if(floor.rented_spots_coordinates_Json){
            rentedSpotsLayer = addVector(floor.rented_spots_coordinates_Json, 'rented');
        }
        if(floor.available_from_spots_coordinates_Json){
            availableFromSpotsLayer = addVector(floor.available_from_spots_coordinates_Json, 'available')
        }

        //Set everything for popups
        var container = document.getElementById('popup-' + location.id + '-' + floor['f1601'] );
        var content = document.getElementById('popup-content-' + location.id + '-' + floor['f1601']);
        //var closer = document.getElementById('popup-closer');
        var overlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
            element: container,
            autoPan: false
        }));
        //Set Map
        var map = new ol.Map({
            target: 'location-map-' + location.id + '-' + floor['f1601'],
            layers: [location_map, availableSpotsLayer, unavailableSpotsLayer, rentedSpotsLayer, availableFromSpotsLayer],
            overlays: [overlay],
            //Disable interactions
            interactions: ol.interaction.defaults({
                dragPan: false,
                doubleClickZoom: false,
                keyboardZoom: false,
                mouseWheelZoom: false
            }),
            //Enable view for static image
            view: new ol.View({
                projection: projection,
                center: ol.extent.getCenter(extent),
                zoom: 1.80,
                maxZoom: 2
            }),
            //Disable default map controls
            controls: []
        });

        //Set Overlays for vectors
        var overlay_color = 'rgba(255,0,0,0.1)';
        var featureOverlay = new ol.layer.Vector({
            source: new ol.source.Vector(),
            map: map,
            style: new ol.style.Style({
                fill: new ol.style.Fill({
                    color: overlay_color
                })
            })
        });

        var highlight;
        var displayFeatureInfo = function (pixel, coordinates) {
            var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
                return feature;
            });
            if (feature) {
                var feature_data;
                if (feature.get('status') == 'Algemene Ruimte') {
                    if(!(feature.get('website_product') === null)){
                        feature_data = '<p style="margin-bottom: 3px;"> ' + feature.get('website_product') + ' </p>';
                    }else{
                        feature_data = '<p style="margin-bottom: 3px;"></p>';
                    }
                } else {
                    feature_data = '<p style="margin-bottom: 3px;">Kantoorunit ' + feature.get('unit_number') + '</p>';
                }

                feature_data += '<p>' + feature.get('status') + '</p>';
                if (feature.get('status') == 'Algemene Ruimte') {
                    feature_data += '<p>Vergaderruimte</p>';
                }

                if (feature.get('status') == 'Beschikbaar vanaf') {
                    feature_data += '<p style="margin-top: -10px;">' + feature.get('available_date') + '</p>';
                }

                if (feature.get('price') && (feature.get('status') == 'Beschikbaar' || feature.get('status') == 'Beschikbaar vanaf')) {
                    feature_data += '<p style="margin-top: -10px;">Prijs: ' + feature.get('price') + '</p>';
                }

                if (feature.get('image_url') && feature.get('status') != 'Verhuurd') {
                    feature_data += '<IMG HEIGHT=100 WIDTH=160 SRC=' + feature.get('image_url') + '>';
                }

                content.innerHTML = feature_data;

                overlay.setPosition(coordinates);
            } else {
                content.innerHTML = '&nbsp;';
                overlay.setPosition(undefined);
            }

            if (feature !== highlight) {
                if (highlight) {
                    featureOverlay.getSource().removeFeature(highlight);
                }
                if (feature) {
                    featureOverlay.getSource().addFeature(feature);
                    switch (feature.get('status')) {
                        case 'Beschikbaar':
                            overlay_color = 'rgba(0, 177, 205, 0.5)';
                            break;
                        case 'Algemene Ruimte':
                            overlay_color = 'rgba(237, 31, 98, 0.5)';
                            break;
                        case 'Verhuurd':
                            overlay_color = 'rgba(145, 145, 145, 0.5)';
                            break;
                    }
                    var style = new ol.style.Style({
                        fill: new ol.style.Fill({
                            color: overlay_color
                        })
                    });
                    featureOverlay.setStyle(style);
                }
                highlight = feature;
            }
        };

        var redirectToFeaturePage = function (pixel, coordinates) {
            var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
                return feature;
            });

            if (feature) {
                var url = feature.get('site_url');
                if (url) {
                    window.open(url, '_blank');
                }
            }
        };

        map.on('pointermove', function (evt) {
            if (evt.dragging) {
                return;
            }
            var pixel = map.getEventPixel(evt.originalEvent);
            displayFeatureInfo(pixel, evt.coordinate);
        });

        map.on('click', function (evt) {
            if (evt.dragging) {
                return;
            }
            var pixel = map.getEventPixel(evt.originalEvent);
            redirectToFeaturePage(pixel, evt.coordinate);
        });
        $('.ol-viewport').css('overflow','visible');
    })(jQuery);
}