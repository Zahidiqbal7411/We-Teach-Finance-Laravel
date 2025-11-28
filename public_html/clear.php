<?php
// Only for temporary use
echo "<pre>";
echo "Clearing Laravel caches...\n";

shell_exec('php artisan cache:clear');
shell_exec('php artisan config:clear');
shell_exec('php artisan route:clear');
shell_exec('php artisan view:clear');
shell_exec('php artisan optimize:clear');

echo "Done!";
