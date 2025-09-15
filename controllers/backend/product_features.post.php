<?php

if ($mode == 'export_range') {
    if (!empty($_REQUEST['feature_ids'])) {
        $feature_ids = (array) $_REQUEST['feature_ids'];
    }

    if (!empty($feature_ids)) {
        if (empty(Tygh::$app['session']['export_ranges'])) {
            Tygh::$app['session']['export_ranges'] = [];
        }

        if (empty(Tygh::$app['session']['export_ranges']['features']['pattern_id'])) {
            Tygh::$app['session']['export_ranges']['features'] = ['pattern_id' => 'features'];
        }

        Tygh::$app['session']['export_ranges']['features']['data'] = ['feature_id' => $feature_ids];

        unset($_REQUEST['redirect_url'], Tygh::$app['session']['export_ranges']['features']['data_provider']);

        return [
            CONTROLLER_STATUS_REDIRECT,
            'exim.export?section=features&pattern_id=' . Tygh::$app['session']['export_ranges']['features']['pattern_id'],
        ];
    }
}

if ($mode === 'export_found') {

    if (empty(Tygh::$app['session']['export_ranges'])) {
        Tygh::$app['session']['export_ranges'] = [];
    }

    if (empty(Tygh::$app['session']['export_ranges']['features']['pattern_id'])) {
        Tygh::$app['session']['export_ranges']['features'] = ['pattern_id' => 'features'];
    }

    Tygh::$app['session']['export_ranges']['features']['data_provider'] = [
        'count_function' => 'fn_exim_get_last_view_features_count',
        'function'       => 'fn_exim_get_last_view_feature_ids_condition',
    ];

    unset($_REQUEST['redirect_url'], Tygh::$app['session']['export_ranges']['features']['data']);

    return [
        CONTROLLER_STATUS_OK,
        'exim.export?section=features&pattern_id=' . Tygh::$app['session']['export_ranges']['features']['pattern_id'],
    ];
}
