<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) {exit; }

class Gyan_Post_Blocks extends Widget_Base {

    public function get_name() {return 'gyan_post_blocks'; }
    public function get_title() {return esc_html__( 'Post Blocks', 'gyan-elements' ); }
    public function get_icon() { return 'gyan-el-icon eicon-gallery-grid'; }
    public function get_categories() {return [ 'gyan-advanced-addons' ]; }
    public function get_keywords() {return [ 'gyan post blocks', 'posts', 'blog','blocks' ]; }
    public function get_style_depends() {return [ 'gyan-advanced-addons' ]; }
    public function get_script_depends() { return [ 'gyan-widgets' ]; }

    protected function _register_controls() {

        $this->start_controls_section(
            'portfolio_query_section',
            [
                'label' => esc_html__( 'Query', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => '4'
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order by', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'date',
                'options'   => [
                    'date'       => esc_html__( 'Date', 'gyan-elements' ),
                    'title'      => esc_html__( 'Title', 'gyan-elements' ),
                    'rand'       => esc_html__( 'Random', 'gyan-elements' ),
                    'menu_order' => esc_html__( 'Menu Order', 'gyan-elements' ),
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => esc_html__( 'Order', 'gyan-elements' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'DESC',
                'options'   => [
                    'DESC' => esc_html__( 'Descending', 'gyan-elements' ),
                    'ASC'  => esc_html__( 'Ascending', 'gyan-elements' ),
                ]
            ]
        );

        $this->add_control(
            'include_posts_cat',
            [
                'label' => esc_html__( 'Include Categories', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => gyan_get_categories()
            ]
        );

        $this->add_control(
            'exclude_posts_cat',
            [
                'label' => esc_html__( 'Exclude Categories', 'plugin-domain' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => gyan_get_categories()
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => esc_html__( 'Offset', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => 0
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'large_post_section',
            [
                'label' => esc_html__( 'Large Post', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lp_show_date',
            [
                'label'                 => esc_html__( 'Date', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'lp_show_author',
            [
                'label'                 => esc_html__( 'Author Name', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'lp_show_comment_count',
            [
                'label'                 => esc_html__( 'Comment Count', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'lp_show_category',
            [
                'label'                 => esc_html__( 'Category', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'lp_show_excerpt',
            [
                'label'                 => esc_html__( 'Excerpt', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'lp_excerpt_length',
            [
                'label' => esc_html__( 'Excerpt Length', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => '120',
                'condition'             => [
                    'lp_show_excerpt'      => 'yes'
                ],
            ]
        );

        $this->add_control(
            'lp_title_length',
            [
                'label'           => esc_html__( 'Title Length', 'gyan-elements' ),
                'label_block'     => true,
                'type'            => Controls_Manager::NUMBER,
                'default'         => '60'
            ]
        );

        $this->add_control(
            'lp_show_readmore',
            [
                'label'                 => esc_html__( 'Read More', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'lp_readmore_text',
            [
                'label' => esc_html__( 'Read More Text', 'gyan-elements' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => '5 min read',
                'condition'             => [
                    'lp_show_readmore'      => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'lp_image',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'swm_image_size_post_grid'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'small_post_section',
            [
                'label' => esc_html__( 'Small Posts', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sp_show_date',
            [
                'label'                 => esc_html__( 'Date', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'sp_show_author',
            [
                'label'                 => esc_html__( 'Author Name', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'sp_show_comment_count',
            [
                'label'                 => esc_html__( 'Comment Count', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'sp_show_category',
            [
                'label'                 => esc_html__( 'Category', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'sp_show_excerpt',
            [
                'label'                 => esc_html__( 'Excerpt', 'gyan-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_off' => esc_html__( 'No', 'gyan-elements' ),
                'label_on'  => esc_html__( 'Yes', 'gyan-elements' ),
            ]
        );

        $this->add_control(
            'sp_excerpt_length',
            [
                'label'           => esc_html__( 'Excerpt Length', 'gyan-elements' ),
                'label_block'     => true,
                'type'            => Controls_Manager::NUMBER,
                'default'         => '120',
                'condition'       => [
                    'sp_show_excerpt' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'sp_title_length',
            [
                'label'           => esc_html__( 'Title Length', 'gyan-elements' ),
                'label_block'     => true,
                'type'            => Controls_Manager::NUMBER,
                'default'         => '55'
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'sp_image',
                'label'                 => esc_html__( 'Image Size', 'gyan-elements' ),
                'default'               => 'swm_image_size_post_grid'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'skin_style',
            [
                'label' => esc_html__( 'Skin', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'skin_1_color',
            [
                'label'                 => esc_html__( 'Skin 1 - Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_small_date,
                    {{WRAPPER}} .gyan_rp_boxed_full_meta,
                    {{WRAPPER}} .gyan_rp_boxed_list_meta_bg,
                    {{WRAPPER}} .gyan_rp_boxed_full_meta_sub ul li,
                    {{WRAPPER}} .gyan_rp_boxed_full_meta_sub ul li a,
                    {{WRAPPER}} .gyan_rp_boxed_full_meta_sub ul li a:hover'  => 'color: {{VALUE}}',
                    '{{WRAPPER}} .gyan_rp_boxed_small_date'  => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'skin_1_bg',
            [
                'label'                 => esc_html__( 'Skin 1 - Background', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#464db1',
                'selectors'             => [
                    '
                    {{WRAPPER}} .gyan_rp_boxed_list_img:before,
                    {{WRAPPER}} .gyan_rp_boxed_full_meta_sub


                    ' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'skin_2_color',
            [
                'label'                 => esc_html__( 'Skin 2 - Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_full_date' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'skin_2_bg',
            [
                'label'                 => esc_html__( 'Skin 2 - Background', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#fda128',
                'selectors'             => [
                    '.gyan_rp_boxed_list_content:before,
                    .gyan_rp_boxed_full_date' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'large_post_style',
            [
                'label' => esc_html__( 'Large Post', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'large_post_title_heading',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'large_post_title_typography',
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '24',
                        ],
                    ],
                    'line_height'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '36',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '600',
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan_rp_boxed h2.gyan_rp_boxed_full_content_title',
            ]
        );

        $this->add_control(
            'large_post_title_col',
            [
                'label'                 => esc_html__( 'Title Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#212638',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_full_content .gyan_rp_boxed_full_content_title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'large_post_title_col_hover',
            [
                'label'                 => esc_html__( 'Title Hover Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#464db1',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_full_content .gyan_rp_boxed_full_content_title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'large_post_excerpt_heading',
            [
                'label'                 => esc_html__( 'Excerpt', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'large_post_excerpt_typography',
                'condition'             => [
                    'lp_show_excerpt'      => 'yes'
                ],
                'selector' => '{{WRAPPER}} p.gyan_rp_boxed_excerpt_large',
            ]
        );

        $this->add_control(
            'large_post_excerpt_col',
            [
                'label'                 => esc_html__( 'Excerpt Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#505050',
                'condition'             => [
                    'lp_show_excerpt'      => 'yes'
                ],
                'selectors'             => [
                    '{{WRAPPER}} p.gyan_rp_boxed_excerpt_large' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'large_post_readmore_heading',
            [
                'label'                 => esc_html__( 'Read More', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'large_post_readmore_typography',
                'selector' => '{{WRAPPER}} p.gyan_rp_boxed_full_button a',
            ]
        );

        $this->add_control(
            'large_post_button_text_col',
            [
                'label'                 => esc_html__( 'Read More Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#777b8a',
                'selectors'             => [
                    '{{WRAPPER}} p.gyan_rp_boxed_full_button a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'large_post_button_text_col_hover',
            [
                'label'                 => esc_html__( 'Read More Text Hover Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#464db1',
                'selectors'             => [
                    '{{WRAPPER}} p.gyan_rp_boxed_full_button a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'large_post_content_bg',
            [
                'label'                 => esc_html__( 'Content Background', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#f5f5f5',
                'separator'             => 'before',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_full_title_section' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'large_post_meta_icons_col',
            [
                'label'                 => esc_html__( 'Meta Icons Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#d0d5e5',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_full_meta_sub ul li a i,
                    {{WRAPPER}} .gyan_rp_boxed_full_meta_sub ul li i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'small_post_style',
            [
                'label' => esc_html__( 'Small Posts', 'gyan-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'small_post_title_heading',
            [
                'label'                 => esc_html__( 'Title', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'small_post_title_typography',
                'fields_options' => [
                    'typography' => [
                        'default' =>'custom',
                    ],
                    'font_size'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ],
                    ],
                    'line_height'   => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '30',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '600',
                    ]
                ],
                'selector' => '{{WRAPPER}} .gyan_rp_boxed h2.gyan_rp_boxed_list_title',
            ]
        );

        $this->add_control(
            'small_post_title_col',
            [
                'label'                 => esc_html__( 'Title Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#212638',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_list_content .gyan_rp_boxed_list_title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'small_post_title_col_hover',
            [
                'label'                 => esc_html__( 'Title Hover Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#464db1',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_list_content .gyan_rp_boxed_list_title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'small_post_excerpt_heading',
            [
                'label'                 => esc_html__( 'Excerpt', 'gyan-elements' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'small_post_excerpt_typography',
                'condition'             => [
                    'lp_show_excerpt'      => 'yes'
                ],
                'selector' => '{{WRAPPER}} p.gyan_rp_boxed_excerpt_small',
            ]
        );

        $this->add_control(
            'small_post_excerpt_col',
            [
                'label'                 => esc_html__( 'Excerpt Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#505050',
                'condition'             => [
                    'sp_show_excerpt'      => 'yes'
                ],
                'selectors'             => [
                    '{{WRAPPER}} p.gyan_rp_boxed_excerpt_small' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'small_post_content_bg',
            [
                'label'                 => esc_html__( 'Content Background', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#f5f5f5',
                'separator'             => 'before',
                'selectors'             => [
                    '{{WRAPPER}} .gyan_rp_boxed_list_content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'small_post_meta_text_col',
            [
                'label'                 => esc_html__( 'Meta Text Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#505050',
                'selectors'             => [
                    '{{WRAPPER}} ul.gyan_rp_boxed_list_meta li a,
                    {{WRAPPER}} ul.gyan_rp_boxed_list_meta li' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'small_post_meta_text_col_hover',
            [
                'label'                 => esc_html__( 'Meta Text Hover Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#252831',
                'selectors'             => [
                    '{{WRAPPER}} ul.gyan_rp_boxed_list_meta li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'small_post_meta_icons_col',
            [
                'label'                 => esc_html__( 'Meta Icons Color', 'gyan-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#fda128',
                'selectors'             => [
                    '{{WRAPPER}} ul.gyan_rp_boxed_list_meta li a i,
                    {{WRAPPER}} ul.gyan_rp_boxed_list_meta li i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();


    }

    protected function render() {

        $data = $this->get_settings_for_display();
        $gyan_rp_boxed_full_post = '';
        $gyan_rp_boxed_list='';

        $args_one_full = array(
            'category__not_in' => $data['exclude_posts_cat'],
            'cat'              => $data['include_posts_cat'],
            'order'            => $data['order'],
            'orderby'          => $data['orderby'],
            'terms'            => array( 'link' ),
            'posts_per_page'   => 1,
            'offset'           => $data['offset'],
            'paged'            => get_query_var( 'paged' ),
            'tax_query'        => array(
                array(
                  'taxonomy' => 'post_format',
                  'field'    => 'slug',
                  'terms'    => array( 'post-format-link','post-format-quote','post-format-aside' ),
                  'operator' => 'NOT IN'
                )
            )
        );

        $gyan_rp_boxed_list = '';

        $blog_query = new WP_Query($args_one_full);

        while ($blog_query->have_posts()) : $blog_query->the_post();

            $postid             = get_the_ID();
            $format             = get_post_format();
            $post_id            = get_the_ID();
            $get_post_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), "gyan-blog-featured" );
            $post_thumbnail_id  = get_post_thumbnail_id($postid);
            $get_the_excerpt    = get_the_excerpt();

            //post image
            $image_url = Group_Control_Image_Size::get_attachment_image_src( $post_thumbnail_id, 'lp_image', $data );

            if ( ! $image_url ) {
                $image_url = $get_post_image_src;
            }

            $post_image = ( $image_url ) ? '<img src="' . $image_url . '" alt="" />' : '';

            //post date
            $post_date = ( 'yes' == $data['lp_show_date'] ) ? '<div class="gyan_rp_boxed_full_date gyan-ease-transition"><span class="gyan_rp_boxed_full_date_d">'.get_the_date('d').'</span><span class="gyan_rp_boxed_full_date_m">'.get_the_date('M').'</span></div>' : '';

            $post_mobile_date = ( 'yes' == $data['lp_show_date'] ) ? '<li class="gyan_rp_boxed_full_date_mobile"><i class="fa fa-clock"></i>'.get_the_date().'</li>' : '';

            //post author
            $post_author = ( 'yes' == $data['lp_show_author'] ) ? '<li><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'"><i class="fa fa-user"></i>'.get_the_author().'</a></li>' : '';

            //post category
            $get_lp_meta_cats = get_the_category();
            $get_lp_meta_cat_list = array();

            if($get_lp_meta_cats){
                foreach($get_lp_meta_cats as $category) {
                    $get_lp_meta_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', '__npo-sites-shortcodes__' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
                }
            }
            $get_all_categories = implode(', ', $get_lp_meta_cat_list);

            $post_category = ( 'yes' == $data['lp_show_category'] ) ? '<li><i class="fas fa-tags"></i>' .$get_all_categories . '</li>' : '';

            //post comments count
            $post_comment_count = ( 'yes' == $data['lp_show_comment_count'] ) ? '<li class="gyan_rp_boxed_full_meta_comment_full"><a href="'.esc_url(get_comments_link()).'"><i class="fa fa-comment"></i>'.get_comments_number($post_id).' '.__('Comments', '__npo-sites-shortcodes__').'</a></li>' : '';

            //post excerpt
            $post_excerpt = ( 'yes' == $data['lp_show_excerpt'] && $get_the_excerpt != '' ) ? '<p class="gyan_rp_boxed_excerpt_large">' . gyan_short_text(get_the_excerpt(), $data['lp_excerpt_length']) . '</p>' : '';

            //read more
            $post_readmore = ( 'yes' == $data['lp_show_readmore'] && $data['lp_readmore_text'] != '' ) ? '<p class="gyan_rp_boxed_full_button"><a href="' . get_permalink() . '" >' . esc_html($data['lp_readmore_text']) . '<i class="fa fa-arrow-right"></i></a></p>' : '';

            if ( $format != 'quote' && $format != 'aside' ) {

                $gyan_rp_boxed_full_post = '<div class="gyan_rp_boxed_full_post">
                        <div class="gyan_rp_boxed_full_post_img">
                            ' . $post_image . '
                        </div>
                        <div class="gyan_rp_boxed_full_content">
                            <div class="gyan_rp_boxed_full_meta">
                                <div class="gyan_rp_boxed_full_meta_sub">
                                    <ul>'
                                    . $post_mobile_date
                                    . $post_author
                                    . $post_comment_count
                                    . $post_category .
                                    '</ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="gyan_rp_boxed_full_title_section">
                                ' . $post_date . '
                                <h2 class="gyan_rp_boxed_full_content_title"><a href="' . get_permalink() . '">' . gyan_short_text(get_the_title(), $data['lp_title_length']) . '</a></h2>
                                ' . $post_excerpt . '
                                ' . $post_readmore . '
                            </div>
                        </div>
                    </div>';

            } //end if

        endwhile;

        wp_reset_postdata();

        $args_two_list = array(
            'category__not_in' => $data['exclude_posts_cat'],
            'cat'       => $data['include_posts_cat'],
            'order'     => $data['order'],
            'orderby'   => $data['orderby'],
            'offset'    => $data['offset'] + 1,
            'terms'     => array( 'link' ),
            'posts_per_page' => $data['posts_per_page'] - 1,
            'paged' => get_query_var( 'paged' ),
            'tax_query' => array(
                array(
                  'taxonomy' => 'post_format',
                  'field'    => 'slug',
                  'terms'    => array( 'post-format-link','post-format-quote','post-format-aside' ),
                  'operator' => 'NOT IN'
                )
            )
        );

        $blog_query = new WP_Query($args_two_list);

        while ($blog_query->have_posts()) : $blog_query->the_post();

            global $post;

            $postid                   = get_the_ID();
            $format                   = get_post_format();
            $get_post_thumb_small_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "gyan-blog-featured" );
            $post_thumbnail_id        = get_post_thumbnail_id($postid);
            $get_the_excerpt          = get_the_excerpt();

            //post image
            $image_url = Group_Control_Image_Size::get_attachment_image_src( $post_thumbnail_id, 'sp_image', $data );

            if ( ! $image_url ) {
                $image_url = $get_post_thumb_small_src[0];
            }

            $post_image_bg = ( $image_url ) ? 'style="background-image:url(' . $image_url . ');"' : '';

            //post date
            $post_date = ( 'yes' == $data['sp_show_date'] ) ? '<div class="gyan_rp_boxed_small_date gyan-ease-transition"><span class="gyan_rp_boxed_small_date_d">'.get_the_date('d').'</span><span class="gyan_rp_boxed_small_date_m">'.get_the_date('M').'</span></div>' : '';

            //post author
            $post_author = ( 'yes' == $data['sp_show_author'] ) ? '<li><i class="fas fa-user"></i><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author().'</a></li>' : '';

            //post category
            $get_sp_meta_cats = get_the_category();
            $get_sp_meta_cat_list = array();

            if($get_sp_meta_cats){
                foreach($get_sp_meta_cats as $category) {
                    $get_sp_meta_cat_list[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', '__npo-sites-shortcodes__' ), $category->name ) ) . '" >'.esc_html($category->cat_name).'</a>';
                }
            }
            $get_all_categories = implode(', ', $get_sp_meta_cat_list);

            $post_category = ( 'yes' == $data['sp_show_category'] ) ? '<li><i class="fas fa-tag"></i>' . $get_all_categories . '</li>' : '';

            //post comments count
            $post_comment_count = ( 'yes' == $data['sp_show_comment_count'] ) ? '<li class="gyan_rp_boxed_full_meta_comment_full"><i class="fas fa-comment"></i><a href="'.esc_url(get_comments_link()).'">'.get_comments_number($post_id).' '.__('Comments', '__npo-sites-shortcodes__').'</a></li>' : '';

            //post excerpt
            $post_excerpt = ( 'yes' == $data['sp_show_excerpt'] && $get_the_excerpt != '' ) ? '<p class="gyan_rp_boxed_excerpt_small">' . gyan_short_text(get_the_excerpt(), $data['sp_excerpt_length']) . '</p>' : '';

            if ( $format != 'quote' && $format != 'aside' ) {

                $post_id = get_the_ID();

                $gyan_rp_boxed_list .= '<div class="gyan_rp_boxed_list">
                            <div class="gyan_rp_boxed_list_img" ' . $post_image_bg . ' >
                                <span class="gyan_rp_boxed_list_meta_bg"></span>
                                ' . $post_date . '
                            </div>
                            <div class="gyan_rp_boxed_list_content">
                                <h2 class="gyan_rp_boxed_list_title"><a href="' . get_permalink() . '">' . gyan_short_text(get_the_title(), $data['sp_title_length']) . '</a></h2>
                                <ul class="gyan_rp_boxed_list_meta">'
                                    . $post_author
                                    . $post_comment_count
                                    . $post_category .
                                '</ul>
                                ' . $post_excerpt . '
                            </div>
                        </div>';
            }

        endwhile;
        wp_reset_postdata();

        $output = '<div>
                    <div class="gyan_rp_boxed">
                        <div class="gyan_rp_boxed_holder">
                            '.$gyan_rp_boxed_full_post.'
                            <div class="gyan_rp_boxed_list_wrap">
                                '.$gyan_rp_boxed_list.'
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>';

        echo $output;

    }

    protected function _content_template() {}

}