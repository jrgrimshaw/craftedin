<?php
$time = 0.00;
$start_time = microtime(true);

require_once dirname(__FILE__) . '/app/init.php';

$q = escape(Input::get('q'));

if($q) {
    $usersWhere = "";
    $keywords = preg_split('/[\s]+/', $q);
    $totalKeywords = count($keywords);
    
    foreach($keywords as $key => $keyword) {
        // Get SQL where statements ready
        $usersWhere .= "username LIKE '%" . addslashes($keyword) . "%' OR name LIKE '%" . addslashes($keyword) . "%'";

        if($key != ($totalKeywords - 1)) {
            // Separate keywords for SQL
            $usersWhere .= " AND ";
        }
    }

    $db = DB::getInstance();
    
    // All users that match the search
    $usersCount = $db->query("SELECT * FROM users WHERE {$usersWhere} ORDER BY id ASC")->count();
    $postsCount = $db->query("SELECT p.*
                            FROM posts p
                            INNER JOIN comments c
                            ON(p.id = c.post_id)
                            WHERE ((p.content LIKE '%{$q}%') OR c.content LIKE '%{$q}%')
                            GROUP BY p.id
                            ORDER BY p.date DESC")->count();
    $resultsCount = $usersCount + $postsCount;

    // Small area searches
    $peopleRowsPreview = $db->query("SELECT * FROM users WHERE (page = 0) AND ({$usersWhere}) ORDER BY id ASC LIMIT 5")->results();
    $peopleRowsPreviewCount = $db->query("SELECT * FROM users WHERE (page = 0) AND ({$usersWhere}) ORDER BY id ASC LIMIT 5")->count();
    $pageRowsPreview = $db->query("SELECT * FROM users WHERE (page = 1) AND ({$usersWhere}) ORDER BY id ASC LIMIT 5")->results();
    $pageRowsPreviewCount = $db->query("SELECT * FROM users WHERE (page = 1) AND ({$usersWhere}) ORDER BY id ASC LIMIT 5")->count();

    // Full results
    $peopleRows = $db->query("SELECT * FROM users WHERE (page = 0) AND ({$usersWhere}) ORDER BY id ASC")->results();
    $peopleRowsCount = $db->query("SELECT * FROM users WHERE (page = 0) AND ({$usersWhere}) ORDER BY id ASC")->count();
    $pageRows = $db->query("SELECT * FROM users WHERE (page = 1) AND ({$usersWhere}) ORDER BY id ASC")->results();
    $pageRowsCount = $db->query("SELECT * FROM users WHERE (page = 1) AND ({$usersWhere}) ORDER BY id ASC")->count();
} else {
    Redirect::to('/');
}

$time = number_format(microtime(true) - $start_time, 2);

$title = 'Search - "' . $q . '"';
$content = 'search';

require_once dirname(__FILE__) . '/app/views/view.php';