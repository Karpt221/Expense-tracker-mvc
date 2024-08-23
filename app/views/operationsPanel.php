<?php
use app\core\View; 

echo View::make('importForm');
echo View::make('exportForm');
if (isset($exportSuccess)) echo "<div>$exportSuccess</div>";
if (isset($exportSizeError)) echo "<div>$exportSizeError</div>";
if (isset($exportTypeError)) echo "<div>$exportTypeError</div>";

