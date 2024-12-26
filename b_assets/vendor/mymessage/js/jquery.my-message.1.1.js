/**
 * Supported Browsers: IE8+
 */
var MyMessage = (function () {
  function message(setting) {
    // Merge default parameters
    this.messageContainer = null;
    this.opts = null;
    this._setting(setting);
    this.init();
  }

  /* Default parameters */
  message.DEFAULTS = {
    iconFontSize: "20px", // Icon size
    messageFontSize: "12px", // Message font size
    showTime: 3000, // Time until message disappears
    align: "center", // Position of the message
    positions: {
      // Position range for the message
      // top: "10px",
      // bottom: "10px",
      // right: "10px",
      // left: "10px"
    },
    message: "This is a message", // Default message
    type: "normal", // Type of the message (e.g., success, error, warning)
  };

  /* Set message parameters */
  message.prototype._setting = function (setting) {
    this.opts = $.extend({}, message.DEFAULTS, setting);
  };

  message.prototype.setting = function (key, val) {
    console.log(arguments.length);
    if (arguments.length === 1) {
      if ("object" === typeof key) {
        for (var k in key) {
          this.opts[k] = key[k];
        }
      }
    } else if (arguments.length === 2) {
      if ("string" === typeof key) {
        this.opts[key] = val;
      }
    }
  };

  /*
   * Adds the necessary DOM to the body tag
   */
  message.prototype.init = function () {
    var styles = "";

    if (this.opts.positions.top) {
      styles += "top:" + this.opts.positions.top + ";";
    }
    if (this.opts.positions.right) {
      styles += "right:" + this.opts.positions.right + ";";
    }
    if (this.opts.positions.left) {
      styles += "left:" + this.opts.positions.left + ";";
    }
    if (this.opts.positions.bottom) {
      styles += "bottom:" + this.opts.positions.bottom + ";";
    }

    // Calculate width if both right and left are present
    // Handle width based on right and left positions
    if (this.opts.positions.right && this.opts.positions.left) {
      // Both right and left provided, use calc to subtract them from 100%
      styles +=
        "width:calc(100% - " +
        this.opts.positions.right +
        " - " +
        this.opts.positions.left +
        ");";
    } else if (this.opts.positions.right) {
      // Only right provided, subtract right from 100%
      styles += "width:calc(100% - " + this.opts.positions.right + ");";
    } else if (this.opts.positions.left) {
      // Only left provided, subtract left from 100%
      styles += "width:calc(100% - " + this.opts.positions.left + ");";
    }

    var domStr = "<div class='m-message' style='" + styles + "'></div>";
    this.messageContainer = $(domStr);
    this.messageContainer.appendTo($("body"));
  };

  /*
   * Adds a message to the respective container
   * message: the actual message
   * type: type of the message
   */
  message.prototype.add = function (message, type) {
    var domStr = "";
    type = type || this.opts.type;
    domStr +=
      "<div class='c-message-notice' style='" +
      "text-align:" +
      this.opts.align +
      ";'><div class='m_content'><i class='";
    switch (type) {
      case "normal":
        domStr += "icon-bubble";
        break;
      case "success":
        domStr += "icon-check-alt";
        break;
      case "error":
        domStr += "icon-notification";
        break;
      case "warning":
        domStr += "icon-cancel-circle";
        break;
      default:
        throw "Invalid type parameter passed. Please use one of: normal, success, error, warning.";
        break;
    }
    domStr +=
      "' style='font-size:" +
      this.opts.iconFontSize +
      ";'></i><span style='font-size:" +
      this.opts.messageFontSize +
      ";'>" +
      message +
      "</span></div></div>";
    var $domStr = $(domStr).appendTo(this.messageContainer);
    this._hide($domStr);
  };

  /**
   * Hide the message
   * $domStr: The jQuery object of the message
   */
  message.prototype._hide = function ($domStr) {
    setTimeout(function () {
      $domStr.fadeOut(1000);
    }, this.opts.showTime);
  };

  return {
    message: message /* Public interface */,
  };
})();
