<?php

$search_key=getParam('search_key',null);
$count = true;   // i write here this variable only for beign more understand able why have +1 param in function below
$res = Article::getPublishedArticles($search_key, $count);  //if count is true then esponse is array, 2nd index will be the counter
$countAll = $res[1];

$T['count_all']=$countAll ? $countAll : 0;  //or if false then could be error either
define('MAX_PAGE_INDEX', ceil($countAll/PER_PAGE));
define('PREV_PAGE', PAGE_INDEX > 0);
define('NEXT_PAGE', PAGE_INDEX < (MAX_PAGE_INDEX-1));

//lets make select for pager, for fun :D
$pager = "PAGE ".(PAGE_INDEX+1);    // default [if less than 2 option then dont need select]
if (MAX_PAGE_INDEX > 1) {
    $arr= ['<form action="" method="GET"><select name="p" onchange="this.form.submit();" class="pager">'];
    for ($i=0; $i<MAX_PAGE_INDEX; $i++){
        $selected = ($i===PAGE_INDEX) ? 'selected' : '';
        $arr[] = "<option value=".$i." ".$selected.">".($i+1)."</option>";
    }
    $arr[] = "</select></form>";
    $pager = implode('', $arr);

}
$T['articles'] = $res[0];
$T['pager'] = $pager;