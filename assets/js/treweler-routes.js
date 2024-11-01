/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./src/js/front/treweler-routes.js ***!
  \*****************************************/

/**
 * Init All Routes For Front End
 */

class TWER_ROUTES {
  constructor() {
    TWER.map.on('load', async () => {
      if (!TWER.isEmpty(TWER.routeData) || TWER.data.gpxRoutes.length > 0) {
        TWER.map.addSource('locations-route', {
          type: 'geojson',
          data: TWER.routeData,
          generateId: true
        }); // Async load gpx routes from sources

        this.setGpsRoutes();
      }
    });
  }

  async setGpsRoutes() {
    try {
      if (TWER.data.gpxRoutes) {
        // Wait after routes fully loaded
        await this.loadGpxRoutes();
      }

      if (TWER.routeData.features.length > 0) {
        for (let i = 0; i < TWER.routeData.features.length; i++) {
          if (TWER.routeData.features[i].properties.route_load === 'static') {
            const routeId = TWER.routeData.features[i].properties.route_id;
            TWER.map.addLayer({
              'id': `route-${routeId}`,
              'type': 'line',
              'source': 'locations-route',
              'layout': {
                'line-join': 'round',
                'line-cap': 'round'
              },
              'paint': {
                'line-color': ['get', 'line-color'],
                'line-width': ['get', 'line-width'],
                'line-opacity': ['get', 'line-opacity'],
                'line-dasharray': ['get', 'line-dasharray']
              },
              'filter': ['==', routeId, ['get', 'route_id']]
            });
          }
        }
      }
    } catch (err) {
      console.log(err);
    }
  }

  async loadGpxRoutes() {
    return new Promise(function (resolve, reject) {
      TWER.data.gpxRoutes.forEach(function (data, index) {
        const route_id = data.route_id;
        const route_url = data.route_source;
        const route_data = data.route_data;
        const metaCategory = data.category;
        const is_gpx_file = '.gpx' === route_url.substr(route_url.length - 4);
        const xhr = new XMLHttpRequest();

        if (route_url) {
          xhr.open('GET', route_url);

          if (is_gpx_file) {
            xhr.responseType = 'document';
            xhr.overrideMimeType('text/xml');
          }

          xhr.onload = () => {
            if (xhr.status >= 200 && xhr.status < 300) {
              resolve(xhr.response);
              const response = xhr.response;
              let is_load = false;

              if (response) {
                if (is_gpx_file) {
                  let coordinates = [];
                  let trkpts = response.getElementsByTagName('trkpt');
                  let lon;
                  let lat;

                  for (let trkpt of trkpts) {
                    lon = parseFloat(trkpt.getAttribute('lon'));
                    lat = parseFloat(trkpt.getAttribute('lat'));
                    coordinates.push([lon, lat]);
                  }

                  if (coordinates.length) {
                    for (let i = 0; i < TWER.routeData.features.length; i++) {
                      if (TWER.routeData.features[i].properties.route_id === route_id) {
                        TWER.routeData.features[i].geometry.coordinates = coordinates;
                      }
                    }

                    is_load = true;
                  }
                } else {
                  const responseJSON = JSON.parse(response);

                  if (!TWER.isEmpty(responseJSON)) {
                    const geometry = responseJSON.routes[0].geometry;

                    if (geometry) {
                      for (let i = 0; i < TWER.routeData.features.length; i++) {
                        if (TWER.routeData.features[i].properties.route_id === route_id) {
                          TWER.routeData.features[i].geometry = geometry;
                        }
                      }

                      is_load = true;
                    }
                  }
                }

                if (is_load) {
                  TWER.map.getSource('locations-route').setData(TWER.routeData);
                  TWER.map.addLayer({
                    'id': `route-${route_id}`,
                    'type': 'line',
                    'source': 'locations-route',
                    'layout': {
                      'line-join': 'round',
                      'line-cap': 'round'
                    },
                    'paint': {
                      'line-color': ['get', 'line-color'],
                      'line-width': ['get', 'line-width'],
                      'line-opacity': ['get', 'line-opacity'],
                      'line-dasharray': route_data['line-dasharray']
                    },
                    'metadata': {
                      'categories': `${metaCategory}`
                    },
                    'filter': ['all', ['==', route_id, ['to-number', ['get', 'route_id']]], ['==', 'dynamic', ['get', 'route_load']]]
                  });
                }
              }
            } else {
              reject(xhr.statusText);
            }
          };

          xhr.onerror = () => reject(xhr.statusText);

          xhr.send();
        }
      });
    });
  }

}

!(() => {
  window.addEventListener('load', () => {
    new TWER_ROUTES();
  });
})();
/******/ })()
;
//# sourceMappingURL=treweler-routes.js.map