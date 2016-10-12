<?php

namespace Rareloop;

use acf_field;

class AcfMapField extends acf_field
{
    public function __construct(array $settings)
    {
        // name (string) Single word, no spaces. Underscores allowed
        $this->name = 'interactive_map';

        // label (string) Multiple words, can include spaces, visible when selecting a field type
        $this->label = 'Interactive Map';

        // category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
        $this->category = 'jquery';

        // defaults (array) Array of default settings which are merged into the field object. These are used later in settings
        $this->defaults = [
            'centerLat' => -37.81411,
            'centerLng' => 144.96328,
            'zoom' => 14,
        ];

        // settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
        // $this->settings = $settings;

        wp_enqueue_script('leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js');
        wp_enqueue_script('leaflet-editable', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet-editable/0.6.2/Leaflet.Editable.min.js');

        wp_enqueue_style('leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css');

        wp_enqueue_script('acf-input-test', plugins_url('wp-acf-map-drawing/src/Rareloop/js/interactive-map.js'), array('jquery'));
        wp_enqueue_style('acf-input-test', plugins_url('wp-acf-map-drawing/src/Rareloop/css/interactive-map.css'), []);

        parent::__construct();
    }

    /*
    *  render_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param   $field (array) the $field being rendered
    *
    *  @type    action
    *  @since   3.6
    *  @date    23/01/13
    *
    *  @param   $field (array) the $field being edited
    *  @return  n/a
    */
    public function render_field($field)
    {
        // echo '<pre>';
        //     print_r($field);
        // echo '</pre>';

        $geoJSON = !empty($field['value']['geoJSON']) ? $field['value']['geoJSON'] : null;
        $type = !empty($field['value']['type']) ? $field['value']['type'] : null;

        $fieldName = esc_attr($field['name']);

        /*
        *  Create a simple text input using the 'font_size' setting.
        */
        ?>
        <div class="interactive-map">
            <!-- <div class="acf-hidden"> -->
                <input type="text" class="interactive-map__input interactive-map__input--geojson" name="<?php echo $fieldName; ?>[geoJSON]" value='<?php echo $geoJSON; ?>' />
                <input type="text" class="interactive-map__input interactive-map__input--type" name="<?php echo $fieldName; ?>[type]" value="<?php echo $type; ?>" />
            <!-- </div> -->

            <div class="interactive-map__canvas">
                <div class="map-tools map-tools--draw">
                    <a href="#" class="map-tools__button" data-type="polygon">Polygon</a>
                    <a href="#" class="map-tools__button" data-type="marker">Marker</a>
                </div>
                <div class="map-tools map-tools--drawing">
                    <a href="#" class="map-tools__button" data-type="complete">Complete</a>
                </div>
                <div class="map-tools map-tools--delete">
                    <a href="#" class="map-tools__button" data-type="delete">Delete</a>
                </div>
            </div>
        </div>
        <?php
    }

    /*
    *  render_field_settings()
    *
    *  Create extra options for your field. This is rendered when editing a field.
    *  The value of $field['name'] can be used (like bellow) to save extra data to the $field
    *
    *  @type    action
    *  @since   3.6
    *  @date    23/01/13
    *
    *  @param   $field  - an array holding all the field's data
    */
    public function render_field_settings($field)
    {
        // centerLat
        acf_render_field_setting($field, [
            'label' => __('Center', 'acf'),
            'instructions' => __('Center the initial map', 'acf'),
            'type' => 'text',
            'name' => 'center_lat',
            'prepend' => 'lat',
            'placeholder' => $this->defaults['centerLat'],
        ]);

        // centerLng
        acf_render_field_setting($field, [
            'label' => __('Center', 'acf'),
            'instructions' => __('Center the initial map', 'acf'),
            'type' => 'text',
            'name' => 'center_lng',
            'prepend' => 'lng',
            'placeholder' => $this->defaults['centerLng'],
            'wrapper' => [
                'data-append' => 'center_lat',
            ],
        ]);

        // zoom
        acf_render_field_setting($field, [
            'label' => __('Zoom', 'acf'),
            'instructions' => __('Set the initial zoom level', 'acf'),
            'type' => 'text',
            'name' => 'zoom',
            'placeholder' => $this->defaults['zoom'],
        ]);
    }

    /*
    *  input_admin_footer
    *
    *  description
    *
    *  @type    function
    *  @date    6/03/2014
    *  @since   5.0.0
    *
    *  @param   $post_id (int)
    *  @return  $post_id (int)
    */
    // public function input_admin_footer()
    // {
    //    // vars
    //     $api = [

    //     ];

    //     // filter
    //     $api = apply_filters('acf/fields/interactive_map/api', $api);
    // }

    // public function update_value($value, $post_id, $field) {
    //     return $value;
    // }
}
