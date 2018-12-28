<?php

include 'start_page.ctp';

echo '<div id="myTabContent" class="tab-content">';

include "$activePage.ctp";

echo '</div>';

echo $this->Admin->ShowPageHeaderEnd();