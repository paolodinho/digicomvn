<?php
// Mo lai (publish) cac dong dgc_gia theo danh sach "republish" trong JSON. Chay: wp eval-file republish-ids.php <file.json> [dry]
$f = $args[0] ?? ''; $dry = in_array('dry', $args, true);
$d = json_decode(file_get_contents($f), true); $n = 0;
foreach (($d['republish'] ?? array()) as $id) {
	if (get_post_type($id) !== 'dgc_gia' || get_post_status($id) !== 'draft') continue;
	if (!$dry) wp_update_post(array('ID' => $id, 'post_status' => 'publish'));
	$n++;
}
WP_CLI::log(($dry ? '[DRY] ' : '[DA GHI] ') . "republish: $n");
