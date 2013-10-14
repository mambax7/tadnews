<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2007-11-04
// $Id: tadnews_newspaper_list.php,v 1.1 2008/04/10 05:29:56 tad Exp $
// ------------------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH."/modules/tadnews/block_function.php";

//區塊主函式 (滑動新聞)
function tadnews_slidernews2_show($options){
  global $xoopsDB,$xoopsModule,$xoopsUser,$xoopsOption;

  if(empty($options[2]))$options[2]="ResponsiveSlides";

  if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/{$options[2]}.php")){
    redirect_header("index.php",3, _MB_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH."/modules/tadtools/{$options[2]}.php";

  $ncsn_arr=explode(',',$options[4]);

  include_once XOOPS_ROOT_PATH."/modules/tadnews/class/tadnews.php";

  $tadnews=new tadnews();

  $tadnews->set_show_num($options[0]);
  $tadnews->set_view_ncsn($ncsn_arr);
  $tadnews->set_show_mode('summary');
  $tadnews->set_news_kind("news");
  $tadnews->set_summary($options[1]);
  $tadnews->set_use_star_rating(false);
  $tadnews->set_cover(false);
  $all_news=$tadnews->get_news('return');

  if(empty($all_news['page']))return;

  $slider=new slider($options[1]);

  $n=0;
  foreach($all_news['page'] as $news){
    $slider->add_content($news['nsn'],$news['news_title'],$news['content'],$news['image_big'],$news['post_date'],XOOPS_URL."/modules/tadnews/index.php?nsn={$news['nsn']}");
    $n++;
    if($n>=$options[0])break;
  }

  $block=$slider->render();

  return $block;
}

//區塊編輯函式
function tadnews_slidernews2_edit($options){

  $ResponsiveSlides=$options[2]=="ResponsiveSlides"?"selected":"";
  $flexslider2=$options[2]=="flexslider2"?"selected":"";

  $block_news_cate=block_news_cate($options[3]);

  $form="{$block_news_cate['js']}
  <table style='width:auto;'>
  <tr><th>
  "._MB_TADNEWS_SLIDERNEWS_BLOCK_EDIT_BITEM2."
  </th><td>
  <INPUT type='text' name='options[0]' value='{$options[0]}' size=6>
  </td></tr>
  <tr><th>
  "._MB_TADNEWS_SLIDERNEWS_BLOCK_EDIT_BITEM3."
  </th><td>
  <INPUT type='text' name='options[1]' value='{$options[1]}' size=6>
  </td></tr>
  <tr><th>
  "._MB_TADNEWS_SLIDERNEWS_BLOCK_EDIT_BITEM4."
  </th><td>
  <select name='options[2]' >
  <option value='ResponsiveSlides' $ResponsiveSlides>ResponsiveSlides</option>
  <option value='flexslider2' $flexslider2>flexslider2</option>
  </select>
  </td></tr>
  <tr><th>"._MB_TADNEWS_CATE_NEWS_EDIT_BITEM0."</th><td>{$block_news_cate['form']}
  <INPUT type='hidden' name='options[3]' id='bb' value='{$options[3]}'></td></tr>
  </table>
  ";
  return $form;
}

?>