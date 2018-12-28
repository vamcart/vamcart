<?php

$this->Html->script([
    'admin/modified.js',
    'admin/focus-first-input.js'
], ['inline' => false]);

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cog');

echo '<ul id="myTab" class="nav nav-tabs">';

foreach ($pages as $page => $name) {
    if ($page === $activePage) {
        echo '<li class="active"><a href="'.$page.'" data-toggle="tab" aria-expanded="true">'.__d(WEBBANKIR_MODULE, $name).'</a></li>';
    } else {
        echo '<li><a href="'.$page.'" aria-expanded="false">'.__d(WEBBANKIR_MODULE, $name).'</a></li>';
    }
}

echo '</ul>';