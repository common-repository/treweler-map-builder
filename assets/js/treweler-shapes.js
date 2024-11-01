/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./src/js/front/treweler-shapes.js ***!
  \*****************************************/

/**
 * Init All Shapes For Front End
 */

class TWER_SHAPES {
  /**
   * Сonstructor
   *
   * @param props
   */
  constructor(props) {
    const shapes = TWER.data.shapes;
    let shapesCollection = {
      type: 'FeatureCollection',
      features: []
    };

    if (shapes.length > 0) {
      for (let i = 0; i < shapes.length; i++) {
        if (shapes[i].length > 0) {
          const collection = typeof shapes[i] === 'string' ? JSON.parse(shapes[i]) : shapes[i];
          const features = collection.features;

          if (features.length > 0) {
            for (let j = 0; j < features.length; j++) {
              shapesCollection.features.push(features[j]);
            }
          }
        }
      }
    }

    TWER.map.on('load', async () => {
      if (shapesCollection.features.length > 0) {
        shapesCollection = this.prepare_features(shapesCollection);
        TWER.map.addSource('shapes_sources', {
          type: 'geojson',
          data: shapesCollection
        });
        TWER.map.addLayer({
          id: 'line_layer',
          type: 'line',
          'filter': ['all', ['==', '$type', 'LineString'], ['!=', 'mode', 'static']],
          layout: {
            'line-cap': 'round',
            'line-join': 'round'
          },
          source: 'shapes_sources',
          paint: {
            'line-color': ['to-color', ['get', 'line_color']],
            'line-dasharray': ['get', 'line_dasharray'],
            'line-width': ['to-number', ['get', 'line_width']]
          }
        });
        TWER.map.addLayer({
          id: 'polygon_layer_fill',
          type: 'fill',
          'filter': ['all', ['==', '$type', 'Polygon'], ['!=', 'mode', 'static']],
          source: 'shapes_sources',
          paint: {
            'fill-color': ['to-color', ['get', 'fill_color']]
          }
        });
        TWER.map.addLayer({
          id: 'polygon_layer_stroke',
          type: 'line',
          'filter': ['all', ['==', '$type', 'Polygon'], ['!=', 'mode', 'static']],
          layout: {
            'line-cap': 'round',
            'line-join': 'round'
          },
          source: 'shapes_sources',
          paint: {
            'line-color': ['to-color', ['get', 'stroke_color']],
            'line-dasharray': ['get', 'stroke_dasharray'],
            'line-width': ['to-number', ['get', 'stroke_width']]
          }
        });
      }
    });
  }

  prepare_features(collection) {
    for (let i = 0; i < collection.features.length; i++) {
      // Set right coordinates for Circle shape
      if (collection.features[i].geometry.hasOwnProperty('coordinatesCircle')) {
        collection.features[i].geometry.coordinates = collection.features[i].geometry.coordinatesCircle;
      }
    }

    return collection;
  }

}

!(() => {
  window.addEventListener('load', () => {
    new TWER_SHAPES();
  });
})();
/******/ })()
;
//# sourceMappingURL=treweler-shapes.js.map