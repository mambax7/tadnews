<style type="text/css" media="screen">
  .resp-vtabs .resp-tabs-container{
    min-height: <{$block.min_height}>px;
  }
</style>

<div id="<{$block.tag_news_name}>">
  <ul class="resp-tabs-list vert">
    <{if $block.latest_news}>
      <li><{$smarty.const._MB_TADNEWS_LATEST_NEWS_TAB}></li>
    <{/if}>
    <{foreach from=$block.tags key=tag_sn item=tag}>
      <li><{$tag}></li>
    <{/foreach}>
  </ul>

  <div class="resp-tabs-container vert">
    <{if $block.latest_news}>
      <div>
        <{foreach from=$block.latest_news item=news}>
          <div style="padding: 8px;">
            <{$news.post_date}> <{$news.always_top_pic}> <{$news.prefix_tag}>
            <a href="<{$xoops_url}>/modules/tadnews/index.php?nsn=<{$news.nsn}>"><{$news.news_title}></a>
          </div>
        <{/foreach}>
      </div>
    <{/if}>
    <{foreach from=$block.tags key=tag_sn item=tag}>
      <div>
        <{if $block.all_news.$tag_sn.page}>
          <{foreach from=$block.all_news.$tag_sn.page item=news}>
            <div style="padding: 8px;">
              <{$news.post_date}> <{$news.always_top_pic}>
              <a href="<{$xoops_url}>/modules/tadnews/index.php?ncsn=<{$news.ncsn}>"><{$news.cate_name}></a> /
              <a href="<{$xoops_url}>/modules/tadnews/index.php?nsn=<{$news.nsn}>"><{$news.news_title}></a>
            </div>
          <{/foreach}>
          <div class="text-right">
            [ <a href="<{$xoops_url}>/modules/tadnews/index.php?ncsn=<{$news.ncsn}>">more...</a> ]
          </div>
        <{/if}>
      </div>
    <{/foreach}>
  </div>
</div>
<div style="clear: both;"></div>