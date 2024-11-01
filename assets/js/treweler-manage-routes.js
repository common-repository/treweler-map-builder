/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./src/js/admin/treweler-manage-routes.js ***!
  \************************************************/


const {
  __
} = wp.i18n;
var tp = '';
var map, draw, direction, lineDrawnStyle, lineDrawnVertaxPointHalosStyle, lineDrawnVertaxPointStyle, lineDrawnMidPointStyle, lineDrawnVertaxPointActiveStyle;
var checkedBtn = 'no';
var bufferData = []; // Data Validation

function isset() {
  let a = arguments,
      l = a.length,
      i = 0,
      undef;

  if (l === 0) {
    // throw new Error('Empty isset');
    return false;
  }

  while (i !== l) {
    if (a[i] === undef || a[i] === null) {
      return false;
    }

    i++;
  }

  return true;
}

function isset_default(val, rtr) {
  if (isset(val) && val !== "") {
    return val;
  } else {
    return rtr;
  }
}

jQuery.noConflict();

const nextSiblings = elem => {
  // create an empty array
  let siblingsSize = 0; // loop through next siblings until `null`

  while (elem = elem.nextElementSibling) {
    if (!elem.classList.contains('d-none')) {
      // push sib0ng to array
      siblingsSize += elem.getBoundingClientRect().height;
    }
  }

  return siblingsSize;
};

(function ($) {
  $(function () {
    const mapRoute = document.getElementById('js-twer-route-map');
    const gpxUploadBtn = document.getElementById('js-twer-gpx-upload');
    const gpxUploadPanel = document.getElementById('js-twer-gpx-upload-panel');
    const gpxInput = document.getElementById('routeGPXFile');
    const gpxNameInput = document.getElementById('routeGPXFileName');
    const mapRouteBody = document.getElementById('js-twer-body');
    const latlngInput = document.getElementById('latlng');
    const setZoomInput = document.getElementById('setZoom');
    const mapInput = document.getElementById('map_id'); // initial Value Tag

    localStorage.setItem("gpxUploadHadRun", 'yes');
    window.TWER_ROUTE = {
      map_style: '',
      draw: '',
      initMap: function () {
        jQuery('.twer-root').each(function () {
          jQuery(this).find('[data-toggle="tooltip"]').tooltip({
            container: $(this).closest('.twer-root')
          });
        });
        tp = twer_ajax.api_key;
        jQuery("#js-twer-route-map").html("");
        let latlng = jQuery("#latlng").val();
        latlng = latlng.substring(1, latlng.length - 1).split(",");
        let lat = latlng[1],
            lng = latlng[0],
            zoom = jQuery("#setZoom").val().trim() != "" ? parseFloat(jQuery("#setZoom").val()).toFixed(2) : 0,
            map_style = $('#map_id option:selected').toArray().map(item => item.dataset.map_style),
            mapProjection = $('#map_id option:selected').toArray().map(item => item.dataset.mapProjection),
            mapLightPreset = $('#map_id option:selected').toArray().map(item => item.dataset.mapLightPreset);

        if (map_style.length <= 0) {
          map_style = ['mapbox://styles/mapbox/standard-beta'];
        }

        if (mapProjection.length <= 0) {
          mapProjection = ['mercator'];
        }

        mapboxgl.accessToken = tp;
        draw = new MapboxDraw({
          displayControlsDefault: false,
          controls: {
            line_string: true,
            trash: true
          },
          styles: [lineDrawnStyle, // vertex point halos
          lineDrawnVertaxPointHalosStyle, // vertex points
          lineDrawnVertaxPointStyle, // Mid point
          lineDrawnMidPointStyle, // Mid point active
          lineDrawnVertaxPointActiveStyle]
        });
        map = new mapboxgl.Map({
          container: 'js-twer-route-map',
          style: map_style[0],
          center: [lng, lat],
          zoom: zoom,
          projection: {
            name: mapProjection[0]
          }
        });
        map.on('style.load', () => {
          if (map_style[0] === 'mapbox://styles/mapbox/standard-beta') {
            let mapLightPresetString = mapLightPreset[0] ? mapLightPreset[0] : 'day';
            map.setConfigProperty('basemap', 'lightPreset', mapLightPresetString);
          }
        });
        map.on("zoom", function () {
          jQuery("#setZoom").val(parseFloat(map.getZoom()).toFixed(2));
          let latlng = map.getCenter();
          jQuery("#latlng").val("{" + latlng.lng + "," + latlng.lat + "}");
        });
        map.on("drag", function () {
          let latlng = map.getCenter();
          jQuery("#latlng").val("{" + latlng.lng + "," + latlng.lat + "}");
        });
        map.addControl(draw, 'top-right');
        map.on('draw.create', updateRoute);
        map.on('draw.update', updateRoute);
        map.on('draw.delete', removeRouteData);
        map.on("load", function () {
          if (jQuery("#routeCoords").val().trim() != "" && jQuery("#routeGPXFile").val().trim() == "") {
            let setRoute = jQuery("#routeCoords").val(),
                defaultCoords = [];
            setRoute = setRoute.split(";");
            setRoute.forEach(function (ele) {
              let ll = [];
              ele.split(",").forEach(function (l) {
                ll.push(parseFloat(l));
              });
              defaultCoords.push(ll);
            });
            bufferData = {
              'type': "FeatureCollection",
              'features': [{
                'type': "Feature",
                'properties': {},
                'geometry': {
                  'coordinates': defaultCoords,
                  'type': 'LineString'
                }
              }]
            };

            var _treweler_route_profile = jQuery("input[name='_treweler_route_profile']:checked").val();
            /* Set the _treweler_route_profile */


            draw.set(bufferData);
            let data = draw.getAll();

            if (data.features.length > 0) {
              var lastFeature = 0;
              var coords = data.features[lastFeature].geometry.coordinates;
              /* Format the coordinates */

              var newCoords = coords.join(';');
              /* Set the radius for each coordinate pair to 25 meters */

              var radius = [];
              coords.forEach(element => {
                radius.push(25);
              });

              if (_treweler_route_profile != 'no') {
                getMatchDistance(newCoords, radius, _treweler_route_profile);
              } else {
                addRoute(data.features[lastFeature].geometry);
              }
            }
          } else if (jQuery("#routeGPXFile").val().trim() != "") {
            let GPXFile = jQuery("#routeGPXFile").val();
            jQuery("input[name='_treweler_route_profile']").each(function (i, e) {
              if (i != 0) {
                jQuery(this).attr('disabled', 'disabled');
              } else {
                jQuery(this).attr('checked', 'checked');
              }
            });
            /* Add Route */

            readGPXFileAndPlotRoute(GPXFile);
          }
        });
      }
    };
    /**
     * Use the coordinates you just drew to make the Map Matching API request
     */

    function updateRoute(e) {
      removeRoute();
      /* Overwrite any existing layers */

      var _treweler_route_profile = $('input[name=\'_treweler_route_profile\']:checked').val();
      /* Set the _treweler_route_profile */


      $('.post-type-route .info-box #directions').html('');

      if ($('#routeGPXFile').val().trim() === '') {
        /* Get the coordinates */
        if (Object.keys(bufferData).length > 0 && bufferData.features.length > 0 && e === undefined) {
          draw.set(bufferData);
          data = draw.getAll();

          if (data.features.length > 0) {
            var lastFeature = 0;
            var coords = data.features[lastFeature].geometry.coordinates;
            /* Format the coordinates */

            var newCoords = coords.join(';');
            /* Set the radius for each coordinate pair to 25 meters */

            var radius = [];
            coords.forEach(element => {
              radius.push(25);
            });

            if (_treweler_route_profile != 'no') {
              getMatchDistance(newCoords, radius, _treweler_route_profile);
            } else {
              addRoute(data.features[lastFeature].geometry);
              reorderRoute();
            }
          }
        } else {
          var data = draw.getAll();
          bufferData = data;

          if (data.features.length > 0) {
            var lastFeature = data.features.length - 1;
            var coords = data.features[lastFeature].geometry.coordinates;
            /* Format the coordinates */

            var newCoords = coords.join(';');
            /* Set the radius for each coordinate pair to 25 meters */

            var radius = [];
            coords.forEach(element => {
              radius.push(25);
            });

            if (_treweler_route_profile != 'no') {
              getMatchDistance(newCoords, radius, _treweler_route_profile);
            } else {
              addRoute(data.features[lastFeature].geometry);
              reorderRoute();
            }
          }
        }

        if (data.features.length > 0) {
          var coords = data.features[0].geometry.coordinates.join(';');
          $('#routeCoords').val(coords);
        }
      } else {
        let selectedGPX = $('#routeGPXFile').val();
        readGPXFileAndPlotRoute(selectedGPX);
      }
    }

    function reorderRoute() {
      try {
        if (map.getLayer('route')) {
          map.moveLayer('route');
        }
      } catch (err) {
        console.log(err);
      }
    }
    /**
     * Make a Map Distance request
     */


    function getMatchDistance(coordinates, radius, _treweler_route_profile) {
      /* Separate the radiuses with semicolons */
      var radiuses = radius.join(';');
      var query = 'https://api.mapbox.com/directions/v5/mapbox/' + _treweler_route_profile + '/' + coordinates + '?' + 'geometries=geojson&steps=true' + '&overview=full&access_token=' + mapboxgl.accessToken;
      jQuery.ajax({
        method: 'GET',
        url: query
      }).done(function (data) {
        if (data.routes.length > 0) {
          var coords = data.routes[0].geometry;
          addRoute(coords);
        } else {
          $('.post-type-route .info-box #directions').html('<span id="direction-error">' + data.message + '</span>');
        }
      }).fail(function (jqXHR, textStatus) {
        $('.post-type-route .info-box #directions').html('<span id="direction-error">' + jqXHR.responseJSON.message + '</span>');
      });
    }
    /**
     * Create the query - Matching API
     */


    function getMatch(coordinates, radius, _treweler_route_profile) {
      /* Separate the radiuses with semicolons */
      var radiuses = radius.join(';');
      var query = 'https://api.mapbox.com/matching/v5/mapbox/' + _treweler_route_profile + '/' + coordinates + '?' + 'geometries=geojson' + '&radiuses=' + radiuses + '&overview=full&access_token=' + mapboxgl.accessToken;
      jQuery.ajax({
        method: 'GET',
        url: query
      }).done(function (data) {
        if (data.matchings.length > 0) {
          var coords = data.matchings[0].geometry;
          addRoute(coords);
        } else {
          $('.post-type-route .info-box #directions').html('<span id="direction-error">' + data.message + '</span>');
        }
      });
    }
    /**
     * Get instructions for route
     */


    function getInstructions(data) {
      /* Target the sidebar to add the instructions */
      var directions = document.getElementById('directions');
      var legs = data.legs;
      var tripDirections = '';
      /* Output the instructions for each step of each leg in the response object */

      tripDirections += '<ul>';

      for (var i = 0; i < legs.length; i++) {
        var steps = legs[i].steps;

        for (var j = 0; j < steps.length; j++) {
          tripDirections += '<li>' + steps[j].maneuver.instruction + '</li>';
        }
      }

      tripDirections += '</ul>';
      var TDh = Math.floor(data.duration / 3600);
      var TDm = Math.floor((data.duration - TDh * 3600) / 60);
      directions.innerHTML = '<h2>Trip duration: ' + TDh + ' h ' + TDm + ' min. (' + Math.floor(data.distance * 0.001) + ' km)</h2>' + tripDirections;
    }
    /**
     * Draw the Map Matching route as a new layer on the map
     */


    function addRoute(coords) {
      /* If a route is already loaded, remove it */
      if (map.getSource('route')) {
        $('.post-type-route .info-box #directions').html('');
        map.removeLayer('route');
        map.removeSource('route');
      }
      /* Add new route */


      let lineColor = $('#routeColor').val(),
          lineOpacity = parseFloat(isset_default($('#route_line_opacity').val(), 1)),
          lineWidth = parseFloat(isset_default($('#route_line_width').val(), 3)),
          lineDash = parseInt(isset_default($('#route_line_dash').val(), 1)),
          lineGap = parseInt(isset_default($('#route_line_gap').val(), 0));
      lineOpacity = lineOpacity >= 0 && lineOpacity <= 1 ? lineOpacity : 0;
      map.addLayer({
        'id': 'route',
        'type': 'line',
        'source': {
          'type': 'geojson',
          'data': {
            'type': 'Feature',
            'properties': {},
            'geometry': coords
          }
        },
        'layout': {
          'line-join': 'round',
          'line-cap': 'round'
        },
        'paint': {
          'line-color': lineColor,
          'line-width': lineWidth,
          'line-opacity': lineOpacity,
          'line-dasharray': [lineDash, lineGap]
        }
      });

      try {
        if (map.getLayer('route') === 'undefined') {
          map.addLayer({
            'id': 'gl-draw-line',
            'type': 'line',
            'source': {
              'type': 'geojson',
              'data': {
                'type': 'Feature',
                'properties': {},
                'geometry': coords
              }
            },
            'filter': ['all', ['==', '$type', 'LineString'], ['!=', 'mode', 'static']],
            'layout': {
              'line-cap': 'round',
              'line-join': 'round'
            },
            'paint': {
              'line-color': '#317dfc',
              'line-dasharray': [0, 2],
              'line-width': 2,
              'line-opacity': 1
            }
          });
        }
      } catch (e) {
        console.log(e);
      }
    }

    function routeReload() {
      let _treweler_route_profile = $('input[name=\'_treweler_route_profile\']:checked').val();

      setTimeout(function () {
        jQuery("#js-twer-directions input[name='_treweler_route_profile']").trigger('change');
      }, 500);
    }

    function addRouteOnChange() {
      let data = draw.getAll();

      if (data.features.length > 0) {
        var lastFeature = 0;
        var coords = data.features[lastFeature].geometry.coordinates;
        /* Format the coordinates */

        var newCoords = coords.join(';');
        /* Set the radius for each coordinate pair to 25 meters */

        var radius = [];
        coords.forEach(element => {
          radius.push(25);
        });

        let _treweler_route_profile = $('input[name=\'_treweler_route_profile\']:checked').val(); //console.log(_treweler_route_profile);


        if (_treweler_route_profile !== 'no') {
          getMatchDistance(newCoords, radius, _treweler_route_profile);
        } else {
          addRoute(data.features[lastFeature].geometry);
        }
      }
    }
    /**
     * Remove Draw control & Add again with updated value
     */


    function removeAddDrawControl() {
      map.removeControl(draw);
      draw = new MapboxDraw({
        displayControlsDefault: false,
        controls: {
          line_string: true,
          trash: true
        },
        styles: [lineDrawnStyle, lineDrawnVertaxPointHalosStyle, lineDrawnVertaxPointStyle, lineDrawnMidPointStyle, lineDrawnVertaxPointActiveStyle]
      });
      map.addControl(draw);
    }
    /**
     * Remove route layer from the map
     */


    function removeRoute(e) {
      if (map.getSource('route') !== undefined) {
        $('.post-type-route .info-box #directions').html('');
        map.removeLayer('route');
        map.removeSource('route');
        $('#routeCoords').val('');
      } else {
        return;
      }
    }

    const gpxUploadBtnContainer = document.getElementById('js-twer-attach__add-file');
    const gpxAttachContainer = document.getElementById('js-twer-attach-container');
    const gpxAfterAddFile = document.getElementById('js-twer-attach-actions');
    const gpxBtnRemove = document.getElementById('js-twer-attach-remove');
    const gpxBtnChange = document.getElementById('js-twer-attach-change');
    const gpxErrorMsg = document.getElementById('gpxErrorMessage'); // Remove uploaded GPX file from metabox after delete

    function removeUploadGPXFile() {
      if (gpxNameInput.value.length && gpxInput.value.length) {
        gpxUploadPanel.removeChild(gpxUploadPanel.getElementsByTagName('p')[0]);
        gpxNameInput.value = gpxInput.value = '';
        gpxUploadBtn.innerText = __('Upload file here', 'treweler');
        gpxUploadBtn.setAttribute('href', '#add');
        gpxUploadBtnContainer.style.display = 'block';
        gpxAttachContainer.style.display = 'block';
        gpxAfterAddFile.style.display = 'none';
        localStorage.setItem("gpxUploadHadRun", 'no');
      }
    }

    if (gpxBtnChange) {
      gpxBtnChange.addEventListener("click", gpxTriggerChange);
      gpxBtnRemove.addEventListener("click", removeRouteData);
    }

    function gpxTriggerChange() {
      // Remove Old Data
      removeRouteData();
      let xmlFrame;

      if (xmlFrame) {
        xmlFrame.open();
        return;
      }

      xmlFrame = wp.media({
        title: __('Select GPX route', 'treweler'),
        button: {
          text: __('Upload GPX route', 'treweler')
        },
        library: {
          type: 'application/gpx+xml'
        },
        multiple: false
      });
      xmlFrame.on('select', function () {
        const xmlFrameFile = xmlFrame.state().get('selection').first();
        const xmlUrl = xmlFrameFile.toJSON().url;
        const xmlName = xmlFrameFile.attributes.filename;
        gpxInput.value = xmlUrl;
        gpxNameInput.value = xmlName;
        gpxAfterAddFile.style.display = 'block';
        localStorage.setItem("gpxUploadHadRun", 'no');
        toggleDirectionsPanel();
        showUploadGPXFile();
        readGPXFileAndPlotRoute(xmlUrl);
      });
      xmlFrame.open();
    }
    /**
     * Remove route layer & data from the map
     */


    function removeRouteData(e) {
      if (map.getSource('route')) {
        $('.post-type-route .info-box #directions').html('');
        removeUploadGPXFile();
        map.removeLayer('route');
        map.removeSource('route');
        $('#routeCoords').val('');
        $('input[name=\'_treweler_route_profile\']').each(function (i, e) {
          if (i != 0) {
            $(this).removeAttr('disabled');
          }
        });
        bufferData = {
          'type': 'FeatureCollection',
          'features': []
        };
        draw.set(bufferData);
        localStorage.setItem("gpxUploadHadRun", 'no');
      }
    }
    /**
     * Read GPX file and draw route on map based on coordinates
     */


    function readGPXFileAndPlotRoute(selectedGPX) {
      jQuery.ajax({
        type: 'GET',
        url: selectedGPX,
        dataType: 'xml',
        success: function (GPX) {
          var points = [];
          $(GPX).find('trkpt').each(function () {
            points.push([parseFloat($(this).attr('lon')), parseFloat($(this).attr('lat'))]);
          });

          if (points.length) {
            let lineColor = $('#routeColor').val(),
                lineOpacity = parseFloat(isset_default($('#route_line_opacity').val(), 1)),
                lineWidth = parseFloat(isset_default($('#route_line_width').val(), 3)),
                lineDash = parseInt(isset_default($('#route_line_dash').val(), 1)),
                lineGap = parseInt(isset_default($('#route_line_gap').val(), 0));
            lineOpacity = lineOpacity >= 0 && lineOpacity <= 1 ? lineOpacity : 0;
            lineDrawnStyle = {
              'id': 'gl-draw-line',
              'type': 'line',
              'filter': ['all', ['==', '$type', 'LineString'], ['!=', 'mode', 'static']],
              'layout': {
                'line-cap': 'round',
                'line-join': 'round'
              },
              'paint': {
                'line-color': lineColor,
                //"#317dfc",
                'line-dasharray': [lineDash, lineGap],
                'line-width': lineWidth,
                'line-opacity': lineOpacity
              }
            };
            /* Add/Remove Draw Control */

            removeAddDrawControl();
            bufferData = {
              'type': 'FeatureCollection',
              'features': [{
                'type': 'Feature',
                'properties': {},
                'geometry': {
                  'coordinates': points,
                  'type': 'LineString'
                }
              }]
            };
            draw.set(bufferData);
            let data = draw.getAll();
            addRoute(data.features[0].geometry);

            if (localStorage.getItem("gpxUploadHadRun") !== 'yes') {
              let bounds = points.reduce(function (bounds, coord) {
                return bounds.extend(coord);
              }, new mapboxgl.LngLatBounds(points[0], points[0]));
              map.fitBounds(bounds, {
                padding: 20
              });
            }

            localStorage.setItem("gpxUploadHadRun", 'yes');

            if (gpxErrorMsg) {
              gpxErrorMsg.style.display = 'none';
            }
          } else {
            if (gpxErrorMsg) {
              gpxErrorMsg.style.display = 'block';
            }

            removeUploadGPXFile();
          }
        }
      });
    }

    function makeDrawLineBlue() {
      map.setPaintProperty('gl-draw-line', 'line-color', '#317dfc');
      map.setPaintProperty('gl-draw-line', 'line-dasharray', [0, 2]);
      map.setPaintProperty('gl-draw-line', 'line-width', 2);
      map.setPaintProperty('gl-draw-line', 'line-opacity', 1);
    }

    function makeRouteBlue() {
      map.setPaintProperty('route', 'line-color', '#317dfc');
      map.setPaintProperty('route', 'line-dasharray', [0, 2]);
      map.setPaintProperty('route', 'line-width', 2);
      map.setPaintProperty('route', 'line-opacity', 1);
    }

    if ($('input[name=\'_treweler_route_profile\']:checked').val() === 'no') {
      let lineColor = $('#routeColor').val();
      lineDrawnStyle = {
        'id': 'gl-draw-line',
        'type': 'line',
        'filter': ['all', ['==', '$type', 'LineString'], ['!=', 'mode', 'static']],
        'layout': {
          'line-cap': 'round',
          'line-join': 'round'
        },
        'paint': {
          'line-color': '#317dfc',
          //'#317dfc',
          'line-dasharray': [1, 0],
          'line-width': 3,
          'line-opacity': 1
        }
      };
    } else {
      checkedBtn = $('input[name=\'_treweler_route_profile\']:checked').val();
      lineDrawnStyle = {
        'id': 'gl-draw-line',
        'type': 'line',
        'filter': ['all', ['==', '$type', 'LineString'], ['!=', 'mode', 'static']],
        'layout': {
          'line-cap': 'round',
          'line-join': 'round'
        },
        'paint': {
          'line-color': '#317dfc',
          'line-dasharray': [0, 2],
          'line-width': 2,
          'line-opacity': 1
        }
      };
    }

    lineDrawnVertaxPointHalosStyle = {
      'id': 'gl-draw-polygon-and-line-vertex-halo-active',
      'type': 'circle',
      'filter': ['all', ['==', 'meta', 'vertex'], ['==', '$type', 'Point'], ['!=', 'mode', 'static']],
      'paint': {
        'circle-radius': 10,
        'circle-color': '#fff'
      }
    };
    lineDrawnMidPointStyle = {
      'id': 'gl-draw-polygon-and-line-vertex-active',
      'type': 'circle',
      'filter': ['all', ['==', 'meta', 'vertex'], ['==', '$type', 'Point'], ['!=', 'mode', 'static']],
      'paint': {
        'circle-radius': 5,
        'circle-color': '#317dfc'
      }
    };
    lineDrawnVertaxPointStyle = {
      'id': 'gl-draw-polygon-and-line-midpoint-halo-active',
      'type': 'circle',
      'filter': ['all', ['==', 'meta', 'midpoint'], ['==', '$type', 'Point'], ['!=', 'mode', 'static']],
      'paint': {
        'circle-radius': 0,
        'circle-color': '#fff'
      }
    };
    lineDrawnVertaxPointActiveStyle = {
      'id': 'gl-draw-polygon-and-line-midpoint-active',
      'type': 'circle',
      'filter': ['all', ['==', 'meta', 'midpoint'], ['==', '$type', 'Point'], ['!=', 'mode', 'static']],
      'paint': {
        'circle-radius': 5,
        'circle-color': '#317dfc'
      }
    };
    /**
     * On change of `map`, set `map` style
     */

    let defaultMapStyle = '';
    let defaultMapProjection = '';
    let defaultMapLightPreset = '';
    $(".js-twer-select-2").on("select2:select.bsnselect", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
      let styleV = $('#map_id option:selected').toArray().map(item => item.dataset.map_style);
      let mapProjection = $('#map_id option:selected').toArray().map(item => item.dataset.mapProjection);
      let mapLightPreset = $('#map_id option:selected').toArray().map(item => item.dataset.mapLightPreset);

      if (styleV.length <= 0) {
        styleV = ['mapbox://styles/mapbox/standard-beta'];
      }

      if (mapProjection.length <= 0) {
        mapProjection = ['mercator'];
      } //console.log(styleV[0], styleV);


      defaultMapStyle = styleV[0];
      map.setStyle(styleV[0]);
      defaultMapProjection = mapProjection[0];
      map.setProjection(mapProjection[0]);

      if (styleV[0] === 'mapbox://styles/mapbox/standard-beta') {
        map.on('style.load', () => {
          let mapLightPresetString = mapLightPreset[0] ? mapLightPreset[0] : 'day';
          map.setConfigProperty('basemap', 'lightPreset', mapLightPresetString);
        });
      }
      /* Place a route on change of map style */


      addRouteOnChange();
      routeReload();
    });
    $(".js-twer-select-2").on('change', function () {
      let styleV = $('#map_id option:selected').toArray().map(item => item.dataset.map_style);
      let mapProjection = $('#map_id option:selected').toArray().map(item => item.dataset.mapProjection);
      let mapLightPreset = $('#map_id option:selected').toArray().map(item => item.dataset.mapLightPreset);

      if (styleV.length <= 0) {
        styleV = ['mapbox://styles/mapbox/standard-beta'];
        map.setStyle(styleV[0]);
      }

      if (styleV.length > 0 && !styleV.includes(defaultMapStyle)) {
        defaultMapStyle = styleV[0];
        map.setStyle(defaultMapStyle);
      }

      if (mapProjection.length <= 0) {
        mapProjection = ['mercator'];
        map.setProjection(mapProjection[0]);
      }

      if (mapProjection.length > 0 && !mapProjection.includes(defaultMapProjection)) {
        defaultMapProjection = mapProjection[0];
        map.setProjection(defaultMapProjection);
      }

      if (styleV[0] === 'mapbox://styles/mapbox/standard-beta') {
        map.on('style.load', () => {
          let mapLightPresetString = mapLightPreset[0] ? mapLightPreset[0] : 'day';
          map.setConfigProperty('basemap', 'lightPreset', mapLightPresetString);
        });
      }
      /* Place a route on change of map style */


      addRouteOnChange();
      routeReload();
    });
    /**
     * Mapbox route _treweler_route_profile
     */

    jQuery("#js-twer-directions input[name='_treweler_route_profile']").on("change", function () {
      if (Object.keys(bufferData).length === 0 || bufferData.features.length === 0) {
        bufferData = draw.getAll();
      }

      let nRun = true;

      if ($(this).val() !== 'no' && checkedBtn === 'no') {
        checkedBtn = $(this).val();
        lineDrawnStyle = {
          'id': 'gl-draw-line',
          'type': 'line',
          'filter': ['all', ['==', '$type', 'LineString'], ['!=', 'mode', 'static']],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#317dfc',
            'line-dasharray': [0, 2],
            'line-width': 2,
            'line-opacity': 1
          }
        };
        /* Add/Remove Draw Control */

        removeAddDrawControl();
        updateRoute();
        nRun = false;
      } else if ($(this).val() === 'no' && checkedBtn !== 'no') {
        checkedBtn = $(this).val();
        let lineColor = $('#routeColor').val();
        lineDrawnStyle = {
          'id': 'gl-draw-line',
          'type': 'line',
          'filter': ['all', ['==', '$type', 'LineString'], ['!=', 'mode', 'static']],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#317dfc',
            'line-dasharray': [1, 0],
            'line-width': 3,
            'line-opacity': 1
          }
        };
        removeAddDrawControl();
        updateRoute();
        nRun = true;
      }

      if (nRun) {
        updateRoute();
      }

      reorderRoute();
    });
    /**
     * Route color picker
     */

    $('#color-picker-btn, .clr-picker span').on('click', function () {
      if ($('.color-picker').find('.a-color-picker').length === 0) {
        const pickerObj = TWER_HELPERS.AColorPicker.from('.color-picker').on('change', (picker, color) => {
          $('.clr-picker span').css('background-color', picker.color);
          $('#routeColor').val(picker.color);
          $('.color-picker').attr('acp-color', picker.color);

          if (event.type === 'mousedown' || event.type === 'click') {
            updateRoute();
          }
        }).on('coloradd', (picker, color) => {
          let cca = $('#addCustomColor');

          if (cca.val().indexOf('|' + color) === -1) {
            cca.val(cca.val() + '|' + color);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: cca.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        }).on('colorremove', (picker, color) => {
          let ccr = $('#addCustomColor');

          if (ccr.val().indexOf('|' + color) !== -1) {
            let sc = ccr.val().replace('|' + color, '');
            ccr.val(sc);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: ccr.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        });
        /*Picker positions*/

        /*const nextSiblingsSizes = nextSiblings(pickerObj[0].element.closest('.twer-tr-route-styles'));
         const colorPickerSize = pickerObj[0].element.closest('.color-picker').getBoundingClientRect().height;
           if(nextSiblingsSizes < colorPickerSize) {
         pickerObj[0].element.closest('.color-picker').classList.add('show-palette-top');
         } else {
         pickerObj[0].element.closest('.color-picker').classList.remove('show-palette-top');
         }*/

        /*Picker positions end*/
      } else {
        $('.color-picker').find('.a-color-picker').remove();
      }
    });
    $(window).on('click', function (event) {
      if (!$(event.target).hasClass('a-color-picker') && $(event.target).parents('.a-color-picker').length == 0 && $(event.target).attr('id') != 'color-picker-btn' && !$(event.target).hasClass('color-holder') && !$(event.target).hasClass('a-color-picker-palette-color')) {
        $('.color-picker').find('.a-color-picker').remove();
      }
    });
    $('#route_line_width, #route_line_opacity, #route_line_dash,#route_line_gap').on('input', function () {
      updateRoute();
    });
    /**
     * Toggle direction panel radio input
     *
     * @param elements - array of elements. 1 - it means that the element must be checked and the disabled attribute must be removed for it
     */

    function toggleDirectionsPanel() {
      let elements = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [1, 0, 0, 0];
      const directionsPanel = document.getElementById('js-twer-directions');
      const directionsProfiles = directionsPanel.getElementsByTagName('input');
      let i = 0;

      for (let directionsProfile of directionsProfiles) {
        if (elements[i]) {
          directionsProfile.checked = true;
          directionsProfile.disabled = false;
        } else {
          directionsProfile.checked = false;
          directionsProfile.disabled = true;
        }

        i++;
      }
    } // Show uploaded GPX file after close wp.media window


    function showUploadGPXFile() {
      if (!!gpxNameInput && gpxNameInput.value) {
        let gpxFileName = document.getElementsByClassName("gpx-trew-file");

        if (typeof gpxFileName[0] !== 'undefined') {
          gpxFileName[0].remove();
        }

        const gpxNameField = document.createElement('p');
        gpxNameField.className = 'hide-if-no-js gpx-trew-file';
        const text = document.createTextNode(gpxNameInput.value);
        gpxNameField.appendChild(text);
        gpxUploadPanel.prepend(gpxNameField);
        gpxUploadBtn.innerText = __('Remove this file', 'treweler');
        gpxUploadBtn.setAttribute('href', '#remove');
        gpxUploadBtnContainer.style.display = 'none';
        gpxAttachContainer.style.display = 'none';
        gpxAfterAddFile.style.display = 'block';
      } else {
        gpxUploadBtnContainer.style.display = 'block';
        gpxAttachContainer.style.display = 'block';
      }
    }

    if (gpxUploadPanel) {
      // Show uploaded GPX files after page load
      showUploadGPXFile();
    } // Click on Upload GPX button in metabox


    if (!!gpxUploadBtn) {
      let xmlFrame;
      gpxUploadBtn.addEventListener('click', e => {
        e.preventDefault();
        const thisBtn = e.target;

        if (thisBtn.getAttribute('href') === '#add') {
          if (xmlFrame) {
            xmlFrame.open();
            return;
          }

          xmlFrame = wp.media({
            title: __('Select GPX route', 'treweler'),
            button: {
              text: __('Upload GPX route', 'treweler')
            },
            library: {
              type: 'application/gpx+xml'
            },
            multiple: false
          });
          xmlFrame.on('select', function () {
            const xmlFrameFile = xmlFrame.state().get('selection').first();
            const xmlUrl = xmlFrameFile.toJSON().url;
            const xmlName = xmlFrameFile.attributes.filename;
            localStorage.setItem("gpxUploadHadRun", 'no');
            gpxInput.value = xmlUrl;
            gpxNameInput.value = xmlName;
            gpxAfterAddFile.style.display = 'block';
            toggleDirectionsPanel();
            showUploadGPXFile();
            readGPXFileAndPlotRoute(xmlUrl);
          });
          xmlFrame.open();
        } else {
          localStorage.setItem("gpxUploadHadRun", 'no');
          removeRouteData();
        }
      });
    }

    if (!!mapRoute && twer_ajax.api_key_is_valid) {
      TWER_ROUTE.initMap();
    } else {
      mapRouteBody.insertAdjacentHTML('afterbegin', `<div id="setting-error-treweler_invalid_api" class="notice notice-error settings-error is-dismissible"> 
<p><strong>${__('Mapbox access token is invalid. Please, enter a valid Mapbox access token.', 'treweler')}</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">${__('Dismiss this notice.', 'treweler')}</span></button></div>`);
    }

    $('.twer-root').tooltip({
      selector: '.twer-help-tooltip'
    });
  });
})(jQuery);
/******/ })()
;
//# sourceMappingURL=treweler-manage-routes.js.map