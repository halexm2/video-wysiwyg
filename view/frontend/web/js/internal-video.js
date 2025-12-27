require([
    'jquery',
    'underscore',
    'jquery/ui'
], function ($, _) {
    'use strict';

    $.widget('mage.internalVideo', {
        options: {
            internalVideoElemKey: '[data-content-type="internal_video"]',
            isMobile: $(window).width() <= 768
        },

        _init: function () {
            this.processInternalVideoElements();
            this.initResizeEvent();
        },

        isMobileView() {
            return $(window).width() <= 768;
        },

        initResizeEvent() {
            var self = this;

            $(window).resize(_.debounce(function () {
                const isMobile = self.isMobileView();

                if (isMobile && !self.options.isMobile) {
                    self.options.isMobile = true;
                    self.processInternalVideoElements();

                    return;
                }

                if (!isMobile && self.options.isMobile) {
                    self.options.isMobile = false;
                    self.processInternalVideoElements();
                }
            }, 300));
        },

        processInternalVideoElementsItem(videoElement) {
            if (this.options.isMobile) {
                const mobileWidth = videoElement.attr('mobile_width');
                const mobileHeight = videoElement.attr('mobile_height');

                videoElement.attr('width', mobileWidth);
                videoElement.attr('height', mobileHeight);

                return;
            }

            const desktopWidth = videoElement.attr('desktop_width');
            const desktopHeight = videoElement.attr('desktop_height');

            videoElement.attr('width', desktopWidth);
            videoElement.attr('height', desktopHeight);
        },

        processInternalVideoElements: function () {
            $(document).find(this.options.internalVideoElemKey).map((index, elem) => {
                const videoElem = $(elem).children();

                this.processInternalVideoElementsItem(videoElem);
            });
        }
    });

    return $.mage.internalVideo();
});
