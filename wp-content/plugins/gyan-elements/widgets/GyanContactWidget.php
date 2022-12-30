<?php
if ( !class_exists( 'GyanContactWidget' ) ) {
    class GyanContactWidget extends WP_Widget {

        function __construct() {
            $widget_ops = array( 'classname' => 'widget_contact', 'description' => esc_html__( "Display address, phone, email.", 'gyan-elements' ) );
            parent::__construct('gyan_contact', esc_html__('Custom - Contact Info', 'gyan-elements'), $widget_ops);
            add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
        }

        public function upload_scripts() {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');

            $gyan_min_js = get_option('swm_enable_minify_gyan_elements_js',true) ? '-min.js' : '.js';
            wp_enqueue_script( 'gyan-custom-widgets', GYAN_PLUGIN_URL . 'widgets/custom-widgets' . $gyan_min_js, array( 'jquery', ),GYAN_PLUGIN_VERSION, TRUE );
        }

        function widget( $args, $instance ) {
            extract( $args );

            $title      = apply_filters('widget_title', empty( $instance['title'] ) ? '' : $instance['title']);
            $c_phone    = apply_filters( 'widget_text', empty( $instance['c_phone'] ) ? '' : $instance['c_phone'], $instance );
            $c_email    = apply_filters( 'widget_text', empty( $instance['c_email'] ) ? '' : $instance['c_email'], $instance );
            $c_time     = apply_filters( 'widget_text', empty( $instance['c_time'] ) ? '' : $instance['c_time'], $instance );
            $c_address  = apply_filters( 'widget_text', empty( $instance['c_address'] ) ? '' : $instance['c_address'], $instance );
            $desc       = apply_filters( 'widget_text', empty( $instance['desc'] ) ? '' : $instance['desc'], $instance );
            $logo_image = !empty($instance['logo_image']) ? $instance['logo_image'] : '' ;

            echo '<div class="gyan_custom_contact_info">';
            echo $before_widget;
            if ( $title != '' ) {
                echo $before_title . wp_kses($title,gyan_kses_allowed_text()) . $after_title;
            }

            if ( $logo_image != '' ) {
                echo '<div><img class="gyan-wid-logo-img" src="'.esc_url($logo_image).'" alt="" /></div>';
            }

            if ( $desc != '' ) {
                echo '<p>' . wp_kses($desc,gyan_kses_allowed_textarea()) . '</p>';
            }
            ?>

            <div class="gyan-cinfo-wid-icons">
                <ul>
                    <li class="gyan-cinfo-phone"><?php echo wp_kses($c_phone,gyan_kses_allowed_text()); ?></li>
                    <li class="gyan-cinfo-email"><a href="mailto:<?php echo wp_kses($c_email,gyan_kses_allowed_text()); ?>"><?php echo wp_kses($c_email,gyan_kses_allowed_text()); ?></a></li>
                    <li class="gyan-cinfo-time"><?php echo wp_kses($c_time,gyan_kses_allowed_text()); ?></li>
                    <li class="gyan-cinfo-address"><?php echo wp_kses($c_address,gyan_kses_allowed_textarea()); ?></li>
                </ul>
            </div>
            <div class="clear"></div>
            <?php
            echo $after_widget;
            echo '</div>';
        }

        function update( $new_instance, $old_instance ) {

            $instance               = $old_instance;
            $instance['title']      = wp_kses($new_instance['title'],gyan_kses_allowed_text());
            $instance['c_phone']    = wp_kses($new_instance['c_phone'],gyan_kses_allowed_text());
            $instance['c_email']    = wp_kses($new_instance['c_email'],gyan_kses_allowed_text());
            $instance['c_time']     = wp_kses($new_instance['c_time'],gyan_kses_allowed_text());
            $instance['logo_image'] = stripslashes($new_instance['logo_image']);

            if ( current_user_can('unfiltered_html') ) {
                $instance['c_address'] =  $new_instance['c_address'];
                $instance['desc'] =  $new_instance['desc'];
            } else {
                $instance['c_address'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['c_address']) ) );
                $instance['desc'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['desc']) ) );
            }

            return $instance;
        }

        function form( $instance ) {
            //Defaults
            $instance = wp_parse_args( (array) $instance, array('title'=>'Contact Info','c_phone'=>'(+1) 800-915-6270','c_email'=>'contact@example.com','c_time'=>'Mon - Fri: 8.00 am - 7.00 pm','desc'=>'','logo_image'=>'','c_address'=>'456, Lorem Street, Ipsum Road,New York, USA.'));
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Widget Title:', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_name( 'logo_image' ); ?>"><?php echo esc_html('Logo Image:','gyan-elements'); ?></label>
                <input name="<?php echo $this->get_field_name( 'logo_image' ); ?>" id="<?php echo $this->get_field_id( 'logo_image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_attr( $instance['logo_image'] ); ?>" class="widefat" />
                <input class="gyan_upload_widget_image_button" type="button" value="Upload Image" />
            </p>
            <p><label for="<?php echo $this->get_field_id('desc'); ?>"><?php echo esc_html__('Small Description:', 'gyan-elements'); ?></label><br />
            <textarea  class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo esc_textarea($instance['desc']); ?></textarea></p>
             <p>
                <label for="<?php echo $this->get_field_id( 'c_phone' ); ?>"><?php esc_html_e('Phone Number:', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'c_phone' ); ?>" name="<?php echo $this->get_field_name( 'c_phone' ); ?>" value="<?php echo esc_attr( $instance['c_phone'] ); ?>" style="width:95%;" />
            </p>
             <p>
                <label for="<?php echo $this->get_field_id( 'c_email' ); ?>"><?php esc_html_e('Email:', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'c_email' ); ?>" name="<?php echo $this->get_field_name( 'c_email' ); ?>" value="<?php echo esc_attr( $instance['c_email'] ); ?>" style="width:95%;" />
            </p>
             <p>
                <label for="<?php echo $this->get_field_id( 'c_time' ); ?>"><?php esc_html_e('Timing:', 'gyan-elements') ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'c_time' ); ?>" name="<?php echo $this->get_field_name( 'c_time' ); ?>" value="<?php echo esc_attr( $instance['c_time'] ); ?>" style="width:95%;" />
            </p>
            <p><label for="<?php echo $this->get_field_id('c_address'); ?>"><?php echo esc_html__('Address:', 'gyan-elements'); ?></label><br />
            <textarea  class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('c_address'); ?>" name="<?php echo $this->get_field_name('c_address'); ?>"><?php echo esc_textarea($instance['c_address']); ?></textarea></p>
           <?php
        }
    }
}

register_widget('GyanContactWidget');