<?php
/**
 * Class to display recharts graph in the dashboard
 */

class Dashboard_Widget{
    public function register_hooks(){
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_scripts'] );
        add_action( 'wp_dashboard_setup', [$this, 'register_dahboard_widgets'] );
    }

    public function enqueue_scripts(){
        wp_enqueue_script( 
            'react-dashboad-scripts', 
            plugin_dir_url( __DIR__ ) . 'build/index.js',
            ['wp-element'],
            null,
            true
        );

        wp_enqueue_style( 
            'react-dashboard-styles', 
            plugin_dir_url( __DIR__ ) . 'build/index.css',
            [], 
            null, 
            'all'
        );
    }

    /**
     * Register dashbood widgets
     *
     * @return void
     */
    public function register_dahboard_widgets(){
        wp_add_dashboard_widget( 
            'react_dahboard_widget',
            esc_html__( 'React Dashboard Widget', 'react-dashboard-widget' ),
            [$this, 'render_dahboard_widgets'],
        );
    }

    public function render_dahboard_widgets(){
        echo '<div id="react-graph-widget"></div>';
    }
}
$widget = new Dashboard_Widget();
$widget->register_hooks();