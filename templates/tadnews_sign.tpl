<p>
  <{$toolbar}>
</p>


<{if $op=="list_sign"}>
  <h1>
    <a href="<{$xoops_url}>/modules/tadnews/index.php?nsn=<{$nsn}>"><{$news_title}></a>
  </h1>

  <div class="row">
    <{foreach item=sign from=$sign}>
      <div class="col-md-2 well">
        <div><a href="index.php?uid=<{$sign.uid}>&op=list_user_sign"><{$sign.uid_name}></a></div>
        <div><{$sign.sign_time}></div>
      </div>
    <{/foreach}>
  </div>

<{elseif $op=="list_user_sign"}>
  <h1>
    <a href="<{$xoops_url}>/userinfo.php?uid=<{$uid}>"><{$uid_name}></a>
  </h1>

  <div class="row">
    <{foreach item=sign from=$sign}>
      <div class="col-md-3 well">
        <div>[<{$sign.nsn}>] <a href='<{$xoops_url}>/modules/tadnews/index.php?nsn=<{$sign.nsn}>'><{$sign.news_title}></a></div>
        <div><{$sign.sign_time}></div>
      </div>
    <{/foreach}>
  </div>
<{/if}>