/**
 * Theme Customizer enhancements for a better user experience.
 */

(function ($) {
  'use strict';

  if (typeof wp === 'undefined' || !wp.customize) {
    return;
  }

  wp.customize('blogname', function (value) {
    value.bind(function (newValue) {
      $('.site-title a').text(newValue);
    });
  });

  wp.customize('blogdescription', function (value) {
    value.bind(function (newValue) {
      $('.site-description').text(newValue);
    });
  });

  wp.customize('header_textcolor', function (value) {
    value.bind(function (color) {
      const cssColor = color === 'blank' ? 'transparent' : color;
      $('.site-title a, .site-description').css('color', cssColor);
    });
  });
})(jQuery);
