function filter_mydate($s) {
    if (preg_match('@^(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)$@', $s, $m) == false) {
        return false;
    }
    if (checkdate($m[2], $m[3], $m[1]) == false || $m[4] >= 24 || $m[5] >= 60 || $m[6] >= 60) {
        return false;
    }
    return $s;
}

--------------
$format = 'm/d/Y H:i:s A';
  $date = '12/29/2017  2:31:42 AM';
		$d = DateTime::createFromFormat($format, $date);
		if($d && $d->format($format) == $date) {
			echo 'dung';
		} else{
			echo 'sai';
		}