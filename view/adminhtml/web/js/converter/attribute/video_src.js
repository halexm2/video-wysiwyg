/*eslint-disable */
/* jscs:disable */
define([
  "Magento_PageBuilder/js/config",
    "Magento_PageBuilder/js/utils/image",
    "Magento_PageBuilder/js/utils/object",
    "Magento_PageBuilder/js/utils/url"
], function (_config, _image, _object, _url) {
    /**
     * @api
     */
    var Src = /*#__PURE__*/function () {
        "use strict";

        function Src() {}

        var _proto = Src.prototype;

        function decodeUrl(value) {
            var result = "";
            value = decodeURIComponent(value.replace(window.location.href, ""));
            var regexp = /{{.*\s*url="?(.*\.([a-z|A-Z|4]*))"?\s*}}/;

            if (regexp.test(value)) {
                var _regexp$exec = regexp.exec(value),
                  url = _regexp$exec[1],
                  type = _regexp$exec[2];

                var image = {
                    name: url.split("/").pop(),
                    size: 0,
                    type: "image/" + type,
                    url: _config.getConfig("media_url") + url
                };
                result = [image];
            }

            return result;
        }

        /**
         * Convert value to internal format
         *
         * @param value string
         * @returns {string | object}
         */
        _proto.fromDom = function fromDom(value) {
            if (!value) {
                return "";
            }

            return (0, decodeUrl)(value);
        }
        /**
         * Convert value to knockout format
         *
         * @param {string} name
         * @param {DataObject} data
         * @returns {string}
         */
        ;

        _proto.toDom = function toDom(name, data) {
            var value = (0, _object.get)(data, name);

            if (value[0] === undefined || value[0].url === undefined) {
                return "";
            }

            var imageUrl = value[0].url;
            var mediaUrl = (0, _url.convertUrlToPathIfOtherUrlIsOnlyAPath)(_config.getConfig("media_url"), imageUrl);
            var mediaPath = imageUrl.split(mediaUrl);
            return "{{media url=" + mediaPath[1] + "}}";
        };

        return Src;
    }();

    return Src;
});
//# sourceMappingURL=src.js.map
