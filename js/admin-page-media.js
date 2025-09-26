(function ($) {
    'use strict';

    var settings = typeof window.logicNagoyaPageMedia !== 'undefined' ? window.logicNagoyaPageMedia : {};

    function createImagePreview($container, url, altText) {
        $container.empty();

        if (!url) {
            return;
        }

        var $img = $('<img>', {
            src: url,
            alt: altText || '',
            css: {
                maxWidth: '300px'
            }
        });

        $container.append($img);
    }

    function handleImageField(selectSelector, removeSelector, fieldSelector, previewSelector, config) {
        var frame;
        var $selectButton = $(selectSelector);
        var $removeButton = $(removeSelector);
        var $field = $(fieldSelector);
        var $preview = $(previewSelector);

        if (!$selectButton.length || !$field.length || !$preview.length) {
            return;
        }

        $selectButton.on('click', function (event) {
            event.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: config && config.title ? config.title : '',
                button: {
                    text: config && config.buttonText ? config.buttonText : ''
                },
                multiple: false
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();

                $field.val(attachment.id);
                createImagePreview($preview, attachment.url, config && config.previewAlt ? config.previewAlt : '');
            });

            frame.open();
        });

        $removeButton.on('click', function (event) {
            event.preventDefault();
            $field.val('');
            $preview.empty();
        });
    }

    function handlePdfField(selectSelector, removeSelector, fieldSelector, previewSelector, config) {
        var frame;
        var $selectButton = $(selectSelector);
        var $removeButton = $(removeSelector);
        var $field = $(fieldSelector);
        var $preview = $(previewSelector);

        if (!$selectButton.length || !$field.length || !$preview.length) {
            return;
        }

        $selectButton.on('click', function (event) {
            event.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: config && config.title ? config.title : '',
                button: {
                    text: config && config.buttonText ? config.buttonText : ''
                },
                multiple: false,
                library: {
                    type: 'application/pdf'
                }
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();

                $field.val(attachment.id);
                $preview.empty().append($('<p>', { text: attachment.filename }));
            });

            frame.open();
        });

        $removeButton.on('click', function (event) {
            event.preventDefault();
            $field.val('');
            $preview.empty();
        });
    }

    $(function () {
        handleImageField(
            '#floor-plan-image-select',
            '#floor-plan-image-remove',
            '#floor-plan-image',
            '#floor-plan-image-preview',
            settings.floorPlan || null
        );

        handleImageField(
            '#concept-image-select',
            '#concept-image-remove',
            '#concept-image',
            '#concept-image-preview',
            settings.concept || null
        );

        handlePdfField(
            '#equipment-pdf-select',
            '#equipment-pdf-remove',
            '#equipment-pdf',
            '#equipment-pdf-preview',
            settings.equipment || null
        );
    });
})(jQuery);
