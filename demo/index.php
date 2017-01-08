<?php
include __DIR__ . '/../vendor/autoload.php';

use Puja\Breadcrumb\Breadcrumb;

$breadcrumb = new Breadcrumb(array(
    array('title' => 'Home', 'link' => '/'),
    array('title' => 'Page', 'link' => '/page'),
    array('title' => 'Subpage', 'link' => '/subpage/?a=5&b[]=7&b[]=8'),
));

echo $breadcrumb->add('Subpage 2', '/subpage2')
    ->setFirstCssClassName('first')
    ->setLastCssClassName('last')
    ->render();
