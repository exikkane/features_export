<?php

use Tygh\Navigation\LastView\Backend;

function fn_exim_get_last_view_features_count()
{
    $last_view = new Backend(AREA, 'features', 'index');
    $view_id = $last_view->getCurrentViewId();
    $last_view_results = $last_view->getViewParams($view_id);

    if (!$last_view_results) {
        return 0;
    }

    return $last_view_results['total_items'];
}

function fn_exim_get_last_view_feature_ids_condition()
{
    $last_view = new Backend(AREA, 'features', 'index');
    $view_id = $last_view->getCurrentViewId();
    $last_view_results = $last_view->getViewParams($view_id);
    fn_print_die($last_view_results);
    $data_function_params = [];
    if ($last_view_results) {
        unset(
            $last_view_results['total_items'],
            $last_view_results['sort_by'],
            $last_view_results['sort_order'],
            $last_view_results['sort_order_rev'],
            $last_view_results['page'],
            $last_view_results['items_per_page']
        );
        $data_function_params = $last_view_results;
    }

    $data_function_params['get_conditions'] = true;
    $data_function_params['load_products_extra_data'] = false;

    list($fields, $join, $condition) = fn_get_products($data_function_params, 0, CART_LANGUAGE);
    $product_ids = db_get_fields(
        'SELECT DISTINCT ?p' .
        ' FROM ?:products AS products' .
        ' ?p' .
        ' WHERE 1 = 1' .
        ' ?p',
        $fields['product_id'],
        $join,
        $condition
    );

    return [
        'product_id' => $product_ids
    ];
}
