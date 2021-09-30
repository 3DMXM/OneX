<?php
$url = 'https://view.officeapps.live.com/op/view.aspx?src='.urlencode($downloadUrl);
header("Location:$url");
exit();