<?php
use XoopsModules\Tadtools\FooTable;
use XoopsModules\Tadtools\Utility;

require_once __DIR__ . '/header.php';
xoops_loadLanguage('blocks', 'tadnews');

$FooTable = new FooTable();
$FooTable->render();

require_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$num = system_CleanVars($_REQUEST, 'num', 10, 'int');
$show_ncsn = system_CleanVars($_REQUEST, 'show_ncsn', '', 'string');
$show_button = system_CleanVars($_REQUEST, 'show_button', 0, 'int');
$start_from = system_CleanVars($_REQUEST, 'start_from', 0, 'int');
$p = system_CleanVars($_REQUEST, 'p', 0, 'int');
$randStr = system_CleanVars($_REQUEST, 'randStr', '', 'string');
$cell = system_CleanVars($_REQUEST, 'cell', '', 'array');
$ncsn = system_CleanVars($_REQUEST, 'ncsn', 0, 'int');
$tag_sn = system_CleanVars($_REQUEST, 'tag_sn', 0, 'int');
$keyword = system_CleanVars($_REQUEST, 'keyword', '', 'string');
$start_day = system_CleanVars($_REQUEST, 'start_day', '', 'string');
$end_day = system_CleanVars($_REQUEST, 'end_day', '', 'string');

$ncsn_arr = explode(',', $show_ncsn);

$b = $p - 1;
$n = $p + 1;
$start = $p * $num + $start_from;

if ($start <= 0) {
    $start = 0;
}

//echo "<p>strat:{$start},p:{$p},b:{$b},n:{$n},start_from:{$start_from},num:{$num}</p>";

$Tadnews->set_show_num($num);
if ($ncsn) {
    $Tadnews->set_view_ncsn($ncsn);
} else {
    $Tadnews->set_view_ncsn($ncsn_arr);
}

if ($tag_sn) {
    $Tadnews->set_view_tag($tag_sn);
}

if ($keyword) {
    $Tadnews->set_keyword($keyword);
}

if ($start_day) {
    $Tadnews->set_start_day($start_day);
}

if ($end_day) {
    $Tadnews->set_end_day($end_day);
}
$Tadnews->set_show_mode('list');
$Tadnews->set_news_kind('news');
$Tadnews->set_use_star_rating(false);
$Tadnews->set_cover(false);
$Tadnews->set_skip_news($start);
$all_news = $Tadnews->get_news('return');

$show_col = [];

foreach ($cell as $col) {
    if ('' == $col or 'hide' === $col) {
        continue;
    }

    $show_col[] = $col;
}

if (empty($show_col)) {
    $show_col = ['start_day', 'news_title', 'uid', 'ncsn', 'counter'];
}

$block = $FooTableJS;

$tt['start_day'] = "<th data-hide='phone' style='width:80px;'>" . Utility::to_utf8(_MD_TADNEWS_START_DATE) . '</th>';
$tt['news_title'] = "<th data-class='expand'>" . Utility::to_utf8(_MD_TADNEWS_NEWS_TITLE) . '</th>';
$tt['uid'] = "<th data-hide='phone' style='width:80px;'>" . Utility::to_utf8(_MD_TADNEWS_POSTER) . '</th>';
$tt['ncsn'] = "<th data-hide='phone' style='width:86px;' nowrap>" . Utility::to_utf8(_MD_TADNEWS_NEWS_CATE) . '</th>';
$tt['counter'] = "<th data-hide='phone'>" . Utility::to_utf8(_MD_TADNEWS_COUNTER) . '</th>';
$blockTitle = '';
foreach ($show_col as $colname) {
    $blockTitle .= $tt[$colname];
}

$block .= "
<table class='table table-striped footable'>
<thead>
  <tr>{$blockTitle}</tr>
</thead>
";
$total = 0;
if (empty($all_news['page'])) {
    $block .= '<tr><td colspan=5>' . _TADNEWS_EMPTY . '</td></tr>';
} else {
    $i = 2;

    foreach ($all_news['page'] as $news) {
        $need_sign = (!empty($news['need_sign'])) ? "<img src='{$news['need_sign']}' align='absmiddle' hspace='3' alt='{$news['news_title']}'>" : '';

        $start_day = "<td nowrap>{$news['post_date']}</td>";
        $news_title = "<td>{$news['prefix_tag']}{$need_sign}{$news['today_pic']} <a href='" . XOOPS_URL . "/modules/tadnews/index.php?nsn={$news['nsn']}'>{$news['news_title']}</a>{$news['files']}</td>";

        $uid = "<td nowrap style='text-align:center;'><a href='" . XOOPS_URL . "/userinfo.php?uid={$news['uid']}'>{$news['uid_name']}</a></td>";
        $ncsn = "<td nowrap style='text-align:center;'><a href='" . XOOPS_URL . "/modules/tadnews/index.php?ncsn={$news['ncsn']}'>{$news['cate_name']}</a></td>";
        $counter = "<td nowrap>{$news['counter']}</td>";
        $news_title = Utility::to_utf8($news_title);
        $uid = Utility::to_utf8($uid);
        $ncsn = Utility::to_utf8($ncsn);
        $block .= '<tr>';
        foreach ($show_col as $colname) {
            $block .= $$colname;
        }

        $block .= '</tr>';
        $i++;
        $total++;
    }
}

$b_button = ($b < 0) ? '' : "<button onClick='view_content{$randStr}({$b})' class='btn'>" . sprintf(_TADNEWS_BLOCK_BACK, $num) . '</button>';

$n_button = ($total < $num) ? '' : "<button style='float:right;' onClick='view_content{$randStr}({$n})' class='btn'>" . sprintf(_TADNEWS_BLOCK_NEXT, $num) . '</button>';

$button = ($show_button) ? "{$n_button}{$b_button}" : '';
//$button="{$n_button}{$b_button}";
$block .= "</table>
$button
<div style='clear:both;'></div>
";

echo $block;
