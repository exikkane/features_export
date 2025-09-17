<?php

use Tygh\Navigation\LastView\Backend;
use Tygh\Enum\ProductFeatures;

function fn_exim_get_last_view_features_count()
{
    $last_view = new Backend(AREA, 'product_features', 'index');
    $view_id = $last_view->getCurrentViewId();
    $last_view_results = $last_view->getViewParams($view_id);

    if (!$last_view_results) {
        return 0;
    }

    return $last_view_results['total_items'];
}

function fn_exim_get_last_view_feature_ids_condition()
{
    $last_view = new Backend(AREA, 'product_features', 'index');
    $view_id = $last_view->getCurrentViewId();
    $last_view_results = $last_view->getViewParams($view_id);

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

    list($data,,) = fn_get_product_features($data_function_params);
    $data_function_params['feature_types'] = ['G'];
    list($groups_data,,) = fn_get_product_features($data_function_params);

    $data = array_merge($data, $groups_data);

    return [
        'feature_id' => array_keys($data),
    ];
}
