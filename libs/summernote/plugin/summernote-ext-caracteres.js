(function (factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else {
    // Browser globals: jQuery
    factory(window.jQuery);
  }
}(function ($) {
  // template
  var tmpl = $.summernote.renderer.getTemplate();
  $.summernote.addPlugin({
    name: 'caracter',
    buttons: { // buttons
      caracteres: function (lang, options) {
        return tmpl.iconButton(options.iconPrefix + 'header', {
          event : 'Caracteres Especiais',
          title: 'Caracteres Especiais',
          hide: true,
          icon: 'sadsad'
        });
      },

      caracterDropdown: function (lang, options) {
        var list = '<table><tr>';
            list += '<td><a class="btn btn-default btn-sm" data-event="caracterDropdown" href="javascript:void(0)" data-value="&pi;">&pi;</a></td>';
            list += '<td><a class="btn btn-default btn-sm" data-event="caracterDropdown" href="javascript:void(0)" data-value="&Delta;">&Delta;</a></td>';
            list += '<td><a class="btn btn-default btn-sm" data-event="caracterDropdown" href="javascript:void(0)" data-value="&gt;">&gt;</a></td>';
            list += '</tr></table>';
        var dropdown = '<ul class="dropdown-menu">' + list + '</ul>';

        return tmpl.iconButton(options.iconPrefix + 'header', {
          title: 'Caracteres Especiais',
          hide: true,
          dropdown : dropdown
        });
      }
    },
    events: {
      caracterDropdown: function (event, editor, layoutInfo, value) {
        // Get current editable node
        var $editable = layoutInfo.editable();
        // Call insertText with 'hello'
         editor.insertText($editable, value);
      }
    }
  });
}));
