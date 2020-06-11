<?php
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/Josje92/squde-clean-wordpress-theme/',
    __FILE__,
    'squde-clean-wordpress-theme'
);

$myUpdateChecker->setBranch('master');