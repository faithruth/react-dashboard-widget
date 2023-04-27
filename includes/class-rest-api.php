<?php
/**
 * A class to register rest endpoints and fetch dashboard widget data
*/

class Rest_API{
    public function register_hooks(){
        add_action( 'rest_api_init', [$this, 'register_rest_endpoint'] );
    }

    public function register_rest_endpoint(){
        register_rest_route( 
           'dashboard-widget/v1', 
           '/data/(?P<number>\d+)', 
           array(
            'method' => 'GET',
            'callback' => [$this, 'get_graph_data'],
            'args' => array(
                'number' => array(
                    'validate_callback' => function( $param, $request, $key ){
                        return is_numeric( $param );
                    },
                    'required' => true
                )
            )
           )
        );

    }

    public function get_graph_data( $request ) {
        $days = $request->get_param('number');
        $data = array();
        while( $days >= 1 ) {
            $date =date( 'm/d/Y', strtotime("-$days days"));
            $data[] = array(
                'name' => $date,
                'pv' => rand(0, 1000),
                'uv' => rand(0, 1000),
            );

            $days --;
        }

        return $data;
    }
}
$api = new Rest_API();
$api->register_hooks();