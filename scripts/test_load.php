<?php
require_once __DIR__ . '/../Interface/BaseRepositoryInterface.php';
require_once __DIR__ . '/../Interface/CatalogRepositoryInterface.php';
require_once __DIR__ . '/../Repository/BaseRepository.php';
require_once __DIR__ . '/../Repository/CatalogRepository.php';

echo "interface_exists(App\\Contract\\CatalogRepositoryInterface): ";
var_export(interface_exists('App\\Contract\\CatalogRepositoryInterface'));
echo "\nclass_exists(CatalogRepository): ";
var_export(class_exists('CatalogRepository'));
echo "\n";
