<?php
function mytheme_acf_color_palette() {
    ?>
    <script type="text/javascript">
        (function($) {
            acf.add_action('ready', function() {
                // Override the default color palette
                var colorPicker = $('.acf-color-picker');
                
                acf.add_filter('color_picker_args', function(args, field) {
                    args.palettes = [
                        '#1A1A2E', // Deep Navy
                        '#E94560', // Brand Red
                        '#0F3460', // Dark Blue
                        '#533483', // Purple
                        '#FFFFFF', // White
                        '#F5F5F5', // Light Gray
                        '#333333', // Dark Gray
                        '#000000'  // Black
                    ];
                    return args;
                });
            });
        })(jQuery);
    </script>
    <?php
}
add_action('acf/input/admin_head', 'mytheme_acf_color_palette');
?>